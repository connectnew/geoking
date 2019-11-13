<?php

use Illuminate\Database\Seeder;

use App\ReviewCategory;

class ReviewCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReviewCategory::create([
            'name' => 'Service',
            'icon' => 'img11.png',
            'position' => 1,
            'show' => 1,
        ]);

        ReviewCategory::create([
            'name' => 'Value for Money',
            'icon' => 'img22.png',
            'position' => 2,
            'show' => 1,
        ]);

        ReviewCategory::create([
            'name' => 'Staff',
            'icon' => 'img66.png',
            'position' => 3,
            'show' => 1,
        ]);

        ReviewCategory::create([
            'name' => 'Facility',
            'icon' => 'img33.png',
            'position' => 4,
            'show' => 1,
        ]);

        ReviewCategory::create([
            'name' => 'Distribution',
            'icon' => 'img44.png',
            'position' => 5,
            'show' => 1,
        ]);

        ReviewCategory::create([
            'name' => 'Healthcare',
            'icon' => 'img55.png',
            'position' => 6,
            'show' => 1,
        ]);
    }
}
