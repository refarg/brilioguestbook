<?php

namespace Tests\Feature\Http\Controllers\General;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Auth;

class PublicControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_submit_guestbook(){
        // $this->seed();
        $guest = \App\Models\Guestbook::factory()->create();

        $response = $this->put(route('guestbook-submit'), [
            'first_name' => $guest->first_name,
            'last_name' => $guest->last_name,
            'organization' => $guest->organization,
            'address' => $guest->address,
            'province_code' => $guest->province_code,
            'city_code' => $guest->city_code,
            'message' => $guest->message,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('guestbook-homepage'));
    }

    public function test_get_city_data(){
        $province = \App\Models\Province::all()->random();

        $response = $this->post(route('get-city'), [
            'province_code' => $province->code,
        ]);

        $response->assertStatus(200);
        $response->assertJson(function($json){
            $json->hasAll(['0']);
        });
    }

    public function test_get_city_data_fail(){

        $province = \App\Models\Province::all()->random();

        $response = $this->post(route('get-city'), [
            'province_code' => null,
        ]);

        $response->assertStatus(404);
        $response->assertJson(function($json){
            $json->hasAll(['message']);
        });
    }


}
