<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        if(session("status_login")){

            return view("dashboard");
        }else{
            return redirect("login");
        }
    }
}
