<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Users;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::query()->where('name','petugas')->first();
        Users::query()->create([
            'role_id' => $role->role_id,
            'api_token_petugas' => Str::random(16),
            'username' => 'Petugas1',
            'email' => 'petugas1@gmail.com',
            'password' => 'petugas111'
        ]);

        Users::query()->create([
            'role_id' => $role->role_id,
            'api_token_petugas' => Str::random(16),
            'username' => 'Petugas2',
            'email' => 'petugas2@gmail.com',
            'password' => 'petugas222'
        ]);
    }
}
