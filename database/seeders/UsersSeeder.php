<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['id_user' => 1, 'name' => 'Admin', 'email' => 'admin@systemtest.com.br', 'password' => '$2y$10$jp0BM1ojjDfhgLYtEp6pAOnPUI33zckEm3/5YOOB4XLNTkSWfpL52', 'status' => 'ATIVO', 'profile' => 'ADMINISTRADOR' ]); //Senha: admin
    }
}
