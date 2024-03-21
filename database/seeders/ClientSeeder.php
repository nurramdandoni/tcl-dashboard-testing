<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('clients')->insert([
            [
                'nama_client' => 'General',
                'batas_atas' => '-17',
                'batas_bawah' => '-23',
                'keterangan' => 'Keterangan Client General',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            [
                'nama_client' => 'CFGS',
                'batas_atas' => '-12',
                'batas_bawah' => '-19',
                'keterangan' => 'Keterangan Client CFGS',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Asumsi user dengan ID 1 adalah yang membuat
                'updated_by' => 1  // Asumsi user dengan ID 1 adalah yang terakhir mengupdate
            ],
            // Tambahkan lebih banyak data di sini jika diperlukan
        ]);
    }
}
