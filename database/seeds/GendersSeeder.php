<?php

use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            'Male', 'Female', 'Other'
        ];

        sort($genders);

        foreach($genders as $gender)
        {
            \App\Gender::create(['title' => $gender]);
        }
    }
}
