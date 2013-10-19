<?php

class SettingTableSeeder extends Seeder {

    public function run()
    {
        DB::table('settings')->delete();

        Setting::create(array(
            'title'       => 'LivBox',
            'description' => 'File System Manager',
            'language'    => 'en',
            'timezone'    => 'UTC',
            'year'        => '2013'
        ));
    }
}