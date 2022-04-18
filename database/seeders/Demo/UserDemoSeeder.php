<?php

namespace Database\Seeders\Demo;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDemoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Soro Pierre Ibrahim',
            'email' => 'soro.pierre@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => User::TYPE_NORMAL
        ]);
        User::create([
            'name' => 'Felix Kouassi',
            'email' => 'felix.kouassi@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => User::TYPE_PRO
        ]);
        User::create([
            'name' => 'Jean Evra Crespo',
            'email' => 'evra.crespo@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => User::TYPE_PRO
        ]);
        User::create([
            'name' => 'Didier Zokora',
            'email' => 'didier.zokora@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => User::TYPE_PRO
        ]);
        User::factory(10)->create();
    }
}
