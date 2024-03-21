<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TemperatureData extends Model
{
    use HasFactory;
    protected $table = 'temperature_datas';

    public function chamber()
    {
        return $this->belongsTo(Chamber::class, 'id_chamber', 'id_chamber');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }
}
