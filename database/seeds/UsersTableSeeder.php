<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'name'              => 'abc',
                'email'             => 'test1@test.com',
                'password'          => Hash::make('12345678'),
                'remember_token'    => Str::random(10),
            ],[
                'name'              => 'def',
                'email'             => 'test2@test.com',
                'password'          => Hash::make('12345678'),
                'remember_token'    => Str::random(10),
            ],[
                'name'              => 'ghi',
                'email'             => 'test3@test.com',
                'password'          => Hash::make('12345678'),
                'remember_token'    => Str::random(10),
            ]
        ]);
    }
}
