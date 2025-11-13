<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; 

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'     => 'Admin Chính',
            'email'    => 'admin@shopphone.vn',
            'password' => Hash::make('matkhau123'), 
        ]);
    }
}