<?php

use Illuminate\Database\Seeder;

class PetTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Bearded Dragon',
            'Bird',
            'Burro',
            'Cat',
            'Chameleon',
            'Chicken',
            'Chinchilla',
            'Chinese Water Dragon',
            'Cow',
            'Dog',
            'Donkey',
            'Duck',
            'Ferret',
            'Fish',
            'Gecko',
            'Goose',
            'Gerbil',
            'Goat',
            'Guinea Fowl',
            'Guinea Pig',
            'Hamster',
            'Hedgehog',
            'Hog',
            'Horse',
            'Iguana',
            'Llama',
            'Lizard',
            'Mouse',
            'Mule',
            'Peafowl',
            'Pig',
            'Pigeon',
            'Pony',
            'Pot Bellied Pig',
            'Rabbit',
            'Rat',
            'Sheep',
            'Skink',
            'Snake',
            'Stick Insect',
            'Sugar Glider',
            'Tarantula',
            'Turkey',
            'Turtle',
            'Other',
        ];

        sort($types);

        foreach($types as $type)
        {
            \App\PetType::create(['title' => $type]);
        }
    }
}
