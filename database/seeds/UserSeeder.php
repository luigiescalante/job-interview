<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = \Illuminate\Support\Carbon::now();
        DB::table('users')->insert([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'user_name'=>'admin',
            'password' => bcrypt('neology'),
            'user_name'=>'admin',
            'status'=>1,
            'created_at'=>$today->format('Y-m-d h:i:s'),
        ]);
    }
}
