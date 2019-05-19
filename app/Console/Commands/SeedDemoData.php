<?php

namespace App\Console\Commands;

use App\Family;
use App\Gender;
use App\Relationship;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SeedDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'family:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds the database with demo data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fake = Factory::create();

        // Create Families
        $family_ids = [];

        for($x = 0; $x < 10; $x++)
        {
            $fraternalName = $fake->lastName;

            $familyRecord = Family::create([
                'demo' => 1,
                'title' => 'The ' . $fraternalName . 's',
                'maternal_name' => $fake->lastName,
                'fraternal_name' => $fraternalName,
                'mother_id' => null,
                'father_id' => null,
            ]);

            $family_ids[] = $familyRecord->id;
        }

        // Now we have he families out where we can assign stuff to them
        $families = Family::whereIn('id', $family_ids)->get();

        foreach($families as $family)
        {
            // Create some shared information for the grandmother and grandfather
            $grandHome = $fake->phoneNumber;
            $grandStreetAddress = $fake->streetAddress;
            $grandCity = $fake->city;
            $grandState = $fake->state;
            $grandZip = $fake->postcode;
            $grandWeddingAnniversary = date('Y-m-d H:i:s', strtotime('- ' . rand(10,30) . ' years'));

            // Get the relationships
            $husbandRelationship = Relationship::select('id')->where(['title' => 'Husband'])->first();
            $wifeRelationship = Relationship::select('id')->where(['title' => 'Wife'])->first();

            // Create the grand parents names
            $grandfatherName = $fake->firstName('male') . ' ' . $family->fraternal_name;
            $grandmotherName = $fake->firstName('female') . ' ' . $family->fraternal_name;

            // Create the grandfather
            $grandfather = $family->users()->create([
                'demo' => 1,
                'name' => $grandfatherName,
                'email' => $fake->safeEmail,
                'password' => Hash::make('password'),
                'nickname' => $grandfatherName,
                'phone_home' => $grandHome,
                'phone_mobile' => $fake->phoneNumber,
                'address_street' => $grandStreetAddress,
                'address_city' => $grandCity,
                'address_state' => $grandState,
                'address_zip' => $grandZip,
                'partner_relationship_id' => $wifeRelationship->id,
                'gender_id' => 2,
                'late' => 0,
                'historic' => 0,
                'birthday' => date('Y-m-d H:i:s', strtotime('- ' . rand(30,40) . ' years')),
                'wedding_anniversary' => $grandWeddingAnniversary,
            ]);

            // Create the grandmother
            $grandmother = $family->users()->create([
                'demo' => 1,
                'name' => $grandmotherName,
                'maiden_name' => $fake->lastName,
                'email' => $fake->safeEmail,
                'password' => Hash::make('password'),
                'nickname' => $grandmotherName,
                'phone_home' => $grandHome,
                'phone_mobile' => $fake->phoneNumber,
                'address_street' => $grandStreetAddress,
                'address_city' => $grandCity,
                'address_state' => $grandState,
                'address_zip' => $grandZip,
                'partner_id' => $grandfather->id,
                'partner_relationship_id' => $husbandRelationship->id,
                'gender_id' => 1,
                'late' => 0,
                'historic' => 0,
                'birthday' => date('Y-m-d H:i:s', strtotime('- ' . rand(30,40) . ' years')),
                'wedding_anniversary' => $grandWeddingAnniversary,
            ]);

            // Assign the grandmother as the grandfather's partner
            $grandfather->update(['partner_id' => $grandmother->id]);

            // Add the grandparents to the family
            $family->familyUsers()->create(['user_id' => $grandfather->id, 'demo' => 1]);
            $family->familyUsers()->create(['user_id' => $grandmother->id, 'demo' => 1]);

            // Update the family with the IDs
            $family->update([
                'mother_id' => $grandmother->id,
                'father_id' => $grandfather->id
            ]);

            // Create some children
            for($x = 0; $x < rand(1, 10); $x++)
            {
                $gender = Gender::findOrFail(rand(1, 2));
                $childName = $fake->firstName(strtolower($gender->title)) . ' ' . $family->fraternal_name;

                $childRecord = $family->users()->create([
                    'demo' => 1,
                    'name' => $childName,
                    'email' => $fake->safeEmail,
                    'password' => Hash::make('password'),
                    'nickname' => $childName,
                    'phone_home' => $grandHome,
                    'phone_mobile' => $fake->phoneNumber,
                    'address_street' => $grandStreetAddress,
                    'address_city' => $grandCity,
                    'address_state' => $grandState,
                    'address_zip' => $grandZip,
                    'gender_id' => $gender->id,
                    'parent_1_id' => $grandfather->id,
                    'parent_2_id' => $grandmother->id,
                    'late' => 0,
                    'historic' => 0,
                    'birthday' => date('Y-m-d H:i:s', strtotime('- ' . rand(10,20) . ' years')),
                ]);

                // Add the child to the family
                $family->familyUsers()->create(['user_id' => $childRecord->id, 'demo' => 1]);

                $shouldMary = array_rand([true, false, false]);

                if($shouldMary)
                {
                    $shouldHaveKids = array_rand([true, false, false]);
                    $numberOfKids = rand(1,5);

                    $husbandLastName = $fake->lastName;

                    $wifeName = $fake->firstName('female') . ' ' . $husbandLastName;
                    $husbandName = $fake->firstName('male') . ' ' . $husbandLastName;

                    $husbandHomePhone = $fake->phoneNumber;
                    $husbandStreetAddress = $fake->streetAddress;
                    $husbandCity = $fake->city;
                    $husbandState = $fake->state;
                    $husbandZip = $fake->postcode;

                    if($childRecord->gender_id === 1)
                    {
                        // This is a female
                        $husband = $family->users()->create([
                            'demo' => 1,
                            'name' => $husbandName,
                            'email' => $fake->safeEmail,
                            'password' => Hash::make('password'),
                            'nickname' => $husbandName,
                            'phone_home' => $husbandHomePhone,
                            'phone_mobile' => $fake->phoneNumber,
                            'address_street' => $husbandStreetAddress,
                            'address_city' => $husbandCity,
                            'address_state' => $husbandState,
                            'address_zip' => $husbandZip,
                            'partner_id' => $childRecord->id,
                            'partner_relationship_id' => $wifeRelationship->id,
                            'gender_id' => 2,
                            'late' => 0,
                            'historic' => 0,
                            'birthday' => date('Y-m-d H:i:s', strtotime('- ' . rand(10,20) . ' years')),
                        ]);

                        //Add husband to family
                        $family->familyUsers()->create(['user_id' => $husband->id, 'demo' => 1]);

                        // Update wife's partner and name
                        $childRecord->update([
                            'name' => $wifeName,
                            'nickname' => $wifeName,
                            'maiden_name' => $family->fraternal_name,
                            'phone_home' => $husbandHomePhone,
                            'address_street' => $husbandStreetAddress,
                            'address_city' => $husbandCity,
                            'address_state' => $husbandState,
                            'address_zip' => $husbandZip,
                            'partner_id' => $husband->id,
                            'partner_relationship_id' => $husbandRelationship->id,
                            'wedding_anniversary' => date('Y-m-d H:i:s', strtotime('- ' . rand(1,10) . ' years'))
                        ]);
                    }
                    else
                    {
                        $wifeName = $fake->firstName('female') . ' ' . explode(' ', $childRecord->name)[1];
                        // This will be treated as male
                        $wife = $family->users()->create([
                            'demo' => 1,
                            'name' => $wifeName,
                            'email' => $fake->safeEmail,
                            'password' => Hash::make('password'),
                            'nickname' => $wifeName,
                            'maiden_name' => $fake->lastName,
                            'phone_home' => $husbandHomePhone,
                            'phone_mobile' => $fake->phoneNumber,
                            'address_street' => $husbandStreetAddress,
                            'address_city' => $husbandCity,
                            'address_state' => $husbandState,
                            'address_zip' => $husbandZip,
                            'partner_id' => $childRecord->id,
                            'partner_relationship_id' => $husbandRelationship->id,
                            'gender_id' => 1,
                            'late' => 0,
                            'historic' => 0,
                            'birthday' => date('Y-m-d H:i:s', strtotime('- ' . rand(10,20) . ' years')),
                        ]);

                        //Add wife to family
                        $family->familyUsers()->create(['user_id' => $wife->id, 'demo' => 1]);

                        // Update husband's partner and name
                        $childRecord->update([
                            'phone_home' => $husbandHomePhone,
                            'address_street' => $husbandStreetAddress,
                            'address_city' => $husbandCity,
                            'address_state' => $husbandState,
                            'address_zip' => $husbandZip,
                            'partner_id' => $wife->id,
                            'partner_relationship_id' => $wifeRelationship->id,
                            'wedding_anniversary' => date('Y-m-d H:i:s', strtotime('- ' . rand(1,10) . ' years'))
                        ]);
                    }

                    if($shouldHaveKids)
                    {
                        $children_ids = [];

                        for($x = 0; $x < $numberOfKids; $x++)
                        {
                            $grandChildGender = Gender::findOrFail(rand(1, 2));
                            $grandChildName = $fake->firstName($gender->title) . ' ' . explode(' ', $childRecord->name)[1];

                            $grandChild = $family->users()->create([
                                'demo' => 1,
                                'name' => $grandChildName,
                                'email' => $fake->safeEmail,
                                'password' => Hash::make('password'),
                                'nickname' => $grandChildName,
                                'phone_home' => $husbandHomePhone,
                                'phone_mobile' => $fake->phoneNumber,
                                'address_street' => $husbandStreetAddress,
                                'address_city' => $husbandCity,
                                'address_state' => $husbandState,
                                'address_zip' => $husbandZip,
                                'parent_1_id' => $childRecord->id,
                                'gender_id' => $grandChildGender->id,
                                'late' => 0,
                                'historic' => 0,
                                'birthday' => date('Y-m-d H:i:s', strtotime('- ' . rand(1,10) . ' years')),
                            ]);

                            $children_ids[] = $grandChild->id;

                            if(isset($childRecord->partner))
                            {
                                $grandChild->update(['parent_2_id' => $childRecord->partner->id]);
                            }

                            $family->familyUsers()->create(['user_id' => $grandChild->id, 'demo' => 1]);
                        }
                    }
                }
            }
        }

        $this->info('Demo data has successfully been seeded to the database');
    }
}
