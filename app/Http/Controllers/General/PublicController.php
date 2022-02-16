<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Guestbook;
use App\Models\Province;
use App\Models\City;

use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    public function index(){
        $data = Guestbook::orderBy('created_at', 'DESC')->get();
        $province_data = Province::all();
        return view('guest.guest-book.index', [
            'province_datas' => $province_data,
            'data' => $data,
        ]);
    }

    public function add_submit(Request $request){
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
            $data = Guestbook::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'organization' => $request->organization,
                'address' => $request->address,
                'message' => $request->message,
                'province_code' => $request->province,
                'city_code' => $request->city,
            ]);

            return redirect(route('guestbook-homepage'))->with([
                'status_message' => 'Success',
            ]);
        }
    }

    public function get_city_data(Request $request){
        if($request->province_code){
            $city_data = City::where('code', 'like', $request->province_code . '%')->get();
            return response($city_data->toJson(), 200)->header('Content-Type', 'application/json');
        } else {
            $message = ["message" => "no data"];
            return response(json_encode($message), 404)->header('Content-Type', 'application/json');
        }
    }

    public function validation(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'organization' => 'string|nullable|max:255',
            'address' => 'string|nullable|max:255',
            'message' => 'required|string|max:255',
            'province' => 'required|integer|exists:province,code',
            'city' => 'required|integer|exists:city,code',
        ]);
        return $validator;
    }
}
