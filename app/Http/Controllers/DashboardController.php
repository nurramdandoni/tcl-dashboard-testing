<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\TemperatureData;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        if(session("status_login")){
            // echo now();
            // var_dump($temperatureDatas);
            // $temperatureDatas = TemperatureData::with('chamber', 'client')->get();
            // echo json_encode($temperatureDatas);
            return view("dashboard");
        }else{
            return redirect("login");
        }
    }
    public function getdataBarChart(Request $request){
        // Dapatkan data dari request POST
        $clientId = $request->input('client_id');
        $tanggal = $request->input('tanggal');

        $temperatureDatas = TemperatureData::where('created_at','like',$tanggal)->where('id_client', $clientId)->with('chamber', 'client')->get();
        echo json_encode($temperatureDatas);
    }
}
