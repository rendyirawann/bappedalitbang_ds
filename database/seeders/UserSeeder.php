<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data diambil dari backup user.sql Yii2 Anda
        $users = [
            ['id' => 1, 'username' => 'developer', 'email' => 'rendy9008@gmail.com', 'bidang_id' => null],
            ['id' => 2, 'username' => 'admin', 'email' => 'adminbappeda@gmail.com', 'bidang_id' => null],
            ['id' => 3, 'username' => 'ekonomi', 'email' => 'kabatu@medan.bkn.go.id', 'bidang_id' => 7],
            ['id' => 4, 'username' => 'pemerintahan', 'email' => 'mutasi@medan.bkn.go.id', 'bidang_id' => 8],
            ['id' => 5, 'username' => 'ppepd', 'email' => 'pensiun@medan.bkn.go.id', 'bidang_id' => 1],
            ['id' => 6, 'username' => 'infrastruktur', 'email' => 'inka@medan.bkn.go.id', 'bidang_id' => 2],
            ['id' => 7, 'username' => 'litbang', 'email' => 'kakanreg@medan.bkn.go.id', 'bidang_id' => 3],
            ['id' => 8, 'username' => 'keuangan', 'email' => 'keuangan@bappedalitbang.deliserdangkab.go.id', 'bidang_id' => 6],
            ['id' => 9, 'username' => 'program', 'email' => 'program@bappedalitbang.deliserdangkab.go.id', 'bidang_id' => 5],
            ['id' => 10, 'username' => 'operator', 'email' => 'operator@gmail.com', 'bidang_id' => null],
            ['id' => 11, 'username' => 'sekretariat', 'email' => 'pdsk@medan.bkn.go.id', 'bidang_id' => 4],
            ['id' => 14, 'username' => 'admin_nisa', 'email' => 'admin@gmail.com', 'bidang_id' => 7],
            ['id' => 15, 'username' => 'admin_dila', 'email' => 'admin2@gmail.com', 'bidang_id' => 1],
            ['id' => 16, 'username' => 'admin_reza', 'email' => 'admin3@gmail.com', 'bidang_id' => 4],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                // Kunci pencarian agar tidak dobel (Cari berdasarkan email)
                ['email' => $userData['email']],

                // Data yang akan diisi/diupdate
                [
                    'id' => $userData['id'], // Mempertahankan ID asli dari Yii2
                    'name' => ucfirst($userData['username']), // Laravel default butuh kolom 'name'
                    'username' => $userData['username'],
                    'bidang_id' => $userData['bidang_id'],
                    'status' => 10, // 10 adalah kode "Aktif" bawaan Yii2

                    // PASSWORD DI-SET SAMA DENGAN USERNAME
                    'password' => Hash::make($userData['username']),
                ]
            );
        }

        $this->command->info('Mantap! 14 Akun User berhasil di-seeding. Password = Username.');
    }
}
