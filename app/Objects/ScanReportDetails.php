<?php

namespace App\Objects;

use Barryvdh\DomPDF\Facade as FacadePDF;
use Barryvdh\DomPDF\PDF;

/**
 * Class ScanReportDetails
 * @package App\Objects
 */
class ScanReportDetails
{
    protected $list = [];

    /**
     * @param ScanReport $report
     * @param array $apiNames
     * @return array
     */
    public function makeDetails(ScanReport $report, array $apiNames): array
    {
        $details = [
            'name' => $report->getScanName(),
            'phone' => $report->getScanPhone(),
            'address' => $report->getScanAddress(),
            'mean_score' => 0
        ];
        if (empty($apiNames)) {
            return $details;
        }
        $meanScore = 0;
        foreach ($apiNames as $apiName) {
            $details[$apiName] = $this->getDetailsByApi($report, $apiName);
            $meanScore += $details[$apiName]['score'];
        }
        $meanScore /= count($apiNames);

        $details['mean_score'] = floor($meanScore);
        $this->list[] = $details;
        return $details;
    }

    /**
     * @param int $totalLocations
     * @return PDF|null
     */
    public function makePDF(int $totalLocations): ?PDF
    {
        if ($this->list === [] || $totalLocations < 1) {
            return null;
        }

        $result = [];
        $score = 0;
        foreach ($this->list as $item) {
            $score += $item['mean_score'];
            if ($result === []) {
                $result = $item;
            }
        }

        $result['mean_score'] = floor($score / $totalLocations);

        $pdf = FacadePDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->setPaper('A4', 'landscape')
            ->loadView('pages.listings.scan-pdf', ['result' => $result, 'listResults' => $this->list]);

        return $pdf;
    }


    /**
     * @param ScanReport $report
     * @param string $apiName
     * @return array
     */
    private function getDetailsByApi(ScanReport $report, string $apiName): array
    {
        return [
            'score' => $report->getScore($apiName),
            'total_status' => $this->getTotalStatus($report->isListed($apiName), $report->isResLocationVerified($apiName)),
            'name' => [
                'value' => $report->getResName($apiName),
                'listed' => $report->isNameListed($apiName),
                'matched' => $report->isNameMatched($apiName),
                'status' => $this->getItemStatus($report->isListed($apiName), $report->isNameListed($apiName), $report->isNameMatched($apiName))
            ],
            'phone' => [
                'value' => $report->getResPhone($apiName),
                'listed' => $report->isPhoneListed($apiName),
                'matched' => $report->isPhoneMatched($apiName),
                'status' => $this->getItemStatus($report->isListed($apiName), $report->isPhoneListed($apiName), $report->isPhoneMatched($apiName))
            ],
            'address' => [
                'value' => $report->getResAddress($apiName),
                'listed' => $report->isAddressListed($apiName),
                'matched' => $report->isAddressMatched($apiName),
                'status' => $this->getItemStatus($report->isListed($apiName), $report->isAddressListed($apiName), $report->isAddressMatched($apiName))
            ],
        ];
    }

    /**
     * @param bool $globalListed
     * @param bool $resLocationVerified
     * @return string
     */
    private function getTotalStatus(bool $globalListed, bool $resLocationVerified): string
    {
        if (!$globalListed) {
            return 'Not Listed';
        }
        return $resLocationVerified ? 'Listed' : 'Not Verified';
    }

    /**
     * @param bool $globalListed
     * @param bool $listed
     * @param bool $matched
     * @return string
     */
    private function getItemStatus(bool $globalListed, bool $listed, bool $matched): string
    {
        if (!$globalListed) {
            return 'Not Listed';
        }
        if (!$listed) {
            return 'Missing';
        }
        return $matched ? 'Match' : 'Mismatch';
    }

}