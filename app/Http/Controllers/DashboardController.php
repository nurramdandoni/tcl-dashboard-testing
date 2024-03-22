<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\TemperatureData;
use Illuminate\Support\Facades\DB;

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
        $chamberId = $request->input('chamber_id');
        $clientId = $request->input('client_id');
        $tanggal = $request->input('tanggal');

        $temperatureDatas = TemperatureData::where('created_at','like',$tanggal)->where('id_chamber', $chamberId)->where('id_client', $clientId)->with('chamber', 'client')->get();
        echo json_encode($temperatureDatas);
    }
    public function getdataTanggal(){

        $temperatureDatas = DB::select(DB::raw('SELECT *, DATE(created_at) as created_date FROM temperature_datas GROUP BY created_date'));
        echo json_encode($temperatureDatas);
    }
}
