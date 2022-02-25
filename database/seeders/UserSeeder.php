<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
Use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        
        ['name'=>'Rafi','email'=>'rafi@gmail.com','password'=>'12345'],
        ['name'=>'Rahim','email'=>'rahim@gmail.com','password'=>'1235'],
        ['name'=>'Kaspi','email'=>'kaspi@gmail.com','password'=>'123456'],
        ['name'=>'Karim','email'=>'karim@gmail.com','password'=>'12']
        ];
        
        User::insert($users);
    }
}
