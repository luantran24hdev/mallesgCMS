<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = [
            'user_name' => 'superadmin',
            'short_name' => "John Doe",
            'email_id' => "supper@admin2.malle.net",
            'lara_password' => bcrypt('testing123'),
            'user_type' => "A",
            'created_on' => Carbon::now(),
            'active' => 'Y',
            'confirmed' => 'Y',
            'status' => 'Y',
            'dash_access' => 'Y'
        ];

        $user = User::firstOrCreate(['email_id'=>$user['email_id']],$user);

    }
}
