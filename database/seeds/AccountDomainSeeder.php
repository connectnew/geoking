<?php

use Illuminate\Database\Seeder;

use App\AccountDomain;

class AccountDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = [
            'Transport' => 'transport.png',
            'Retail' => 'retail_icon.png',
            'Food and Beverage' => 'food_and_beverage_icon.png',
            'Healthcare' => 'healthcare_icon.png',
            'Entertainment' => 'entertainment_icon.png',
            'Hospitality' => 'hospitality_icon.png',
            'Self-Service' => 'self_service.png',
            'Public Service' => 'public_service_icon.png',
            'Education' => 'education_icon.png'
        ];

        foreach($domains as $name => $img){

            $data = AccountDomain::where('title', $name)->whereNull('icon')->first();
            if($data){
                $data->icon = $img;
                $data->save();
            }
        }
    }
}
