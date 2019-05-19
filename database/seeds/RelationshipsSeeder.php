<?php

use Illuminate\Database\Seeder;

class RelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationships = [
            'Great Grandmother',
            'Great Grandfather',
            'Grandmother',
            'Grandfather',
            'Mother',
            'Father',
            'Wife',
            'Aunt',
            'Great Aunt',
            'Uncle',
            'Great Uncle',
            'Husband',
            'Boyfriend',
            'Girlfriend',
            'Fiance',
            'Ex-wife',
            'Ex-husband',
            'Mother-in-law',
            'Father-in-law',
            'Brother-in-law',
            'Sister-in-law',
            'Sister',
            'Brother',
            'Cousin',
            'Half Sister',
            'Half Brother',
            'Step Sister',
            'Step Brother',
            'Step Mother',
            'Step Father',
            'Legal Guardian',
            'Other',
        ];

        sort($relationships);

        foreach($relationships as $relationship)
        {
            \App\Relationship::create(['title' => $relationship]);
        }
    }
}
