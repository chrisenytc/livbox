<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email'         => 'test@example.com',
            'password'      => Hash::make('test'),
            'role'          => '0',
            'locked'        => FALSE,
            'last_login'    => new DateTime(),
            'last_activity' => time()
        ));
    }
}