<?php

namespace App\Services;

use App\Location;
use App\Objects\ScanEntity;
use App\Objects\ScanReport;
use App\Source;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use SKAgarwal\GoogleApi\PlacesApi as GooglePlaces;
use RuntimeException;
use Google_Service_Exception;

/**
 * Class ScanService
 * @package App\Services
 */
class ScanService
{
    public const GOOGLE_MAPS_PLATFORM_API_NAME = 'google'; //'google_map';
    public const GOOGLE_MY_BUSINESS_API_NAME = 'google'; //'google_my_business';

    /**
     * @param GooglePlaces $apiClient
     * @param ScanEntity $entity
     * @param array|null $bounds
     * @return ScanReport
     */
    public function googlePlacesScan(GooglePlaces $apiClient, ScanEntity $entity, ?array $bounds = null): ScanReport
    {
        $scanReport = new ScanReport($entity);
        $params = [];
        if (isset($bounds['northeast'], $bounds['southwest'])) {
            //rectangle:south,west|north,east
            $params['locationbias'] = sprintf(
                'rectangle:%s,%s|%s,%s',
                $bounds['southwest']['lat'],
                $bounds['southwest']['lng'],
                $bounds['northeast']['lat'],
                $bounds['northeast']['lng']
            );
        }

        try {
            $response = $apiClient->findPlace($entity->getName(), 'textquery', $params);
            if ($response->get('status') === 'OK') {
                $placeId = $response->get('candidates')->first()['place_id'];
                return $this->googlePlacesMakeReport($apiClient, $placeId, $scanReport);
            }
            $response = $apiClient->findPlace($entity->getPhone(), 'phonenumber', $params);
            if ($response->get('status') === 'OK') {
                $placeId = $response->get('candidates')->first()['place_id'];
                return $this->googlePlacesMakeReport($apiClient, $placeId, $scanReport);
            }
        } catch (GooglePlacesApiException $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $scanReport;
    }

    /**
     * @param GooglePlaces $apiClient
     * @param string $placeId
     * @param ScanReport $scanReport
     * @return ScanReport
     */
    private function googlePlacesMakeReport(GooglePlaces $apiClient, string $placeId, ScanReport $scanReport): ScanReport
    {
        try {
            $res = $apiClient->placeDetails($placeId);
            if ($res->get('status') === 'OK') {
                $resEntity = $scanReport->getResEntity(self::GOOGLE_MAPS_PLATFORM_API_NAME);
                $resEntity->setIsLocationVerified(true);
                foreach ($res->get('result') as $key => $item) {
                    switch ($key) {
                        case 'name':
                            $resEntity->setName($item);
                            break;
                        case 'international_phone_number':
                            $resEntity->setPhone($item);
                            break;
                        case 'address_components':
                            $resEntity = $this->parseAddressComponents($resEntity, $item);
                            break;
                    }
                }

                $scanReport->addResEntity(self::GOOGLE_MAPS_PLATFORM_API_NAME, $resEntity);
            }
        } catch (GooglePlacesApiException $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $scanReport;
    }

    /**
     * @param ScanEntity $entity
     * @param array $addressComponents
     * @return ScanEntity
     */
    private function parseAddressComponents(ScanEntity $entity, array $addressComponents): ScanEntity
    {
        $address = [];
        foreach ($addressComponents as $component) {
            if (in_array('postal_code', $component['types'], false)) {
                $entity->setPostalCode($component['short_name']);
            }
            if (in_array('country', $component['types'], false)
                || in_array('postal_town', $component['types'], false)
            ) {
                $entity->setCountry($component['short_name']);
            }
            if (in_array('administrative_area_level_1', $component['types'], false)) {
                $entity->setProvince($component['long_name']);
            }
            if (in_array('locality', $component['types'], false)) {
                $entity->setCity($component['short_name']);
            }
            // address
            if (in_array('street_number', $component['types'], false)) {
                $address[0] = $component['short_name'];
            }
            if (in_array('route', $component['types'], false)
                || in_array('intersection', $component['types'], false)
                || in_array('street_address', $component['types'], false)
            ) {
                $address[1] = $component['short_name'];
            }
            if (in_array('floor', $component['types'], false)) {
                $address[2] = $component['short_name'];
            }
            if (in_array('room', $component['types'], false)) {
                $address[3] = $component['short_name'];
            }
        }
        if ([] !== $address) {
            ksort($address);
            $entity->setAddress(implode(' ', $address));
        }

        return $entity;
    }

    /**
     * @param GoogleMyBusiness $googleMyBusiness
     * @param Source $source
     * @param Location $location
     * @return ScanReport
     */
    public function googleMyBusinessScan(GoogleMyBusiness $googleMyBusiness, Source $source, Location $location): ScanReport
    {
        $scanEntity = new ScanEntity();
        $scanEntity->setName($source->name);
        $scanEntity->setPhone($source->phone);
        $scanEntity->setCountry($source->country);
        $scanEntity->setProvince($source->province);
        $scanEntity->setCity($source->city);
        $scanEntity->setAddress($source->address);
        $scanEntity->setPostalCode($source->postal_code);

        $scanReport = new ScanReport($scanEntity);

        try {
            $name = $location->raw_data['name'] ?? null;

            try {
                $res = $googleMyBusiness->accounts_locations->get($name)->toSimpleObject();
            } catch (Google_Service_Exception $e) {
                return $scanReport;
            }
            $resEntity = $scanReport->getResEntity(self::GOOGLE_MY_BUSINESS_API_NAME);
            $resEntity->setName($res->locationName ?? null);
            $resEntity->setPhone($res->primaryPhone ?? null);
            $resEntity->setCountry($res->address['regionCode'] ?? null);
            $resEntity->setProvince($res->address['administrativeArea'] ?? null);
            $resEntity->setCity($res->address['locality'] ?? null);
            $resEntity->setAddress($res->address['addressLines'][0] ?? null);
            $resEntity->setPostalCode($res->address['postalCode'] ?? null);
            $resEntity->setIsLocationVerified((bool)($res->locationState['isVerified'] ?? false));

            return $scanReport;
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}