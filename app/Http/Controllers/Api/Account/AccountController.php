<?php

namespace App\Http\Controllers\Api\Account;

use App\Account;
use App\Http\Controllers\Api\ApiController;
use App\Source;
use SKAgarwal\GoogleApi\PlacesApi as GooglePlaces;
use Zttp\Zttp;

class AccountController extends ApiController
{
    public function store()
    {
        $data = request()->all();

        //TODO: switch to normal worflow in vue
        $locations = [
            "one_location" => 1,
            "multi_location" => 2,
            "marketing" => 3
        ];

        /** @var Account $acc */
        $acc = auth()->user()->accounts()->create([
            'name' => $data['company_name'],
            'website' => $data['company_website'] ?? '',
            'phone' => $data['company_phone'],
            'address' => $data['company_address'],
            'country' => $data['country'],
            'province' => $data['province'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'domain_id' => $data['services'][0],
            'type_id' => $locations[$data['type']],
            'raw_data' => [
                'team' => $data['team'] ?? [],
                'competitions' => $data['competitions'] ?? [],
            ]
        ]);

        // save data as source of truth
        if ($data['type'] === 'one_location') {
            $source = new Source([
                'name' => $data['company_name'],
                'website' => $data['company_website'] ?? '',
                'phone' => $data['company_phone'],
                'address' => $data['company_address'],
                'country' => $data['country'],
                'province' => $data['province'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'account_id' => $acc->id,
                'external_id' => 1
            ]);
            $source->save();
        }

        if (request()->session()->has('form') && request()->session()->get('current-step')) {
                request()->session()->forget(['form', 'current-step']);
        }
        return response()->json($acc);
    }
}
