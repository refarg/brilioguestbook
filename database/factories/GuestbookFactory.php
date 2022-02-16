<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GuestbookFactory extends Factory
{
    // protected $model = \App\Models\Guestbook::class;
    /**
     * Define the model's default state.
     *
     * @return array
     * 
     * error Array to string conversion karena nama fakernya belum benar, kayak $faker->firstName itu firstNamenya yang salah, coba cari lagi
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('id_ID');
        $province_id = \App\Models\Province::all()->random()->code;
        $city_id = \App\Models\City::where('code', 'like', $province_id . '%')->get()->random()->code;
        return [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'organization' => $faker->company(),
            'address' => $faker->streetAddress(),
            'province_code' => $province_id,
            'city_code' => $city_id,
            'message' => $faker->sentence(),
        ];
    }
}
