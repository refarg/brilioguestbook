<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        if($request->user()->role_id == 1){
            return redirect(route('admin.guestbook.index'));
        } else {
            return view('dashboard');
        }
    }
}
