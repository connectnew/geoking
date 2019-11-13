<?php

use Illuminate\Database\Seeder;

use App\ReviewLanguage;

class ReviewLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReviewLanguage::create([
            'name' => 'English',
            'code' => 'en-US',
            'position' => 1,
            'show' => 1,
        ]);

        ReviewLanguage::create([
            'name' => 'Arabic',
            'code' => 'ar-SA',
            'position' => 2,
            'show' => 1,
        ]);
    }
}
