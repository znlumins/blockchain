<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Admin
        User::create([
            'name' => 'Admin Pusat', 
            'username' => 'admin',
            'password' => bcrypt('admin'), 
            'role' => 'admin',
        ]);
        
        // 2. Buat Warga (seperti di PDF "Riya Septian Anggraini")
        User::create([
            'name' => 'Riya Septian Anggraini', 
            'username' => 'riya',
            'password' => bcrypt('riyacantik'), 
            'role' => 'warga',
        ]);

        // 3. Buat Dummy Project
        Project::create([
            'nama_proyek' => 'Pembangunan Jalan Provinsi Urban Zone',
            'deskripsi' => 'Perbaikan dan perluasan jalan provinsi sepanjang 5km.',
            'lokasi' => 'Menteng, Jakarta Pusat',
            'anggaran' => 100000000,
            'tahun' => '2025',
            'status' => 'usulan'
        ]);
    }
}