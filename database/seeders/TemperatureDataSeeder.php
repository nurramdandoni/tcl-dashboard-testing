<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemperatureDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('temperature_datas')->insert([
            [
                'id_chamber' => '1',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '2',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '3',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '4',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '5',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '6',
                'id_client' => '1',
                'temperature_data' => '-22',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '7',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '8',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '9',
                'id_client' => '1',
                'temperature_data' => '-20',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'id_chamber' => '10',
                'id_client' => '1',
                'temperature_data' => '-23',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            // Tambahkan lebih banyak data di sini jika diperlukan
        ]);
    }
}
