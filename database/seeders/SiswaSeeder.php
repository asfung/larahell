<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nisn' => '1234567890',
                'nama' => 'John Doe',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2005-01-01',
                'alamat' => 'Jl. Sudirman No. 123',
                'telepon' => '+6281234567890',
            ],
            [
                'nisn' => '0987654321',
                'nama' => 'Jane Doe',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2006-02-02',
                'alamat' => 'Jl. Merdeka No. 456',
                'telepon' => '+6280987654321',
            ],
        ]);
    }
}
