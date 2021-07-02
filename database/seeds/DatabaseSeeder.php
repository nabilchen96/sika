<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'  => 'pusbangkar',
            'role'  => 'pusbangkar',
            'email' => 'pusbangkar@poltekbangplg.ac.id',
            'password'  => Hash::make('password'),
            'jk'        => '1',
            'nip'   => "9999999999",
        ]);
    }
}
