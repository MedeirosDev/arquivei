<?php

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'last_cursor' => 0,
            'path_successes' => 'nfe_successes/',
            'path_failures' => 'nfe_failures/',
        ]);
    }
}
