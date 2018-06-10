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
        DB::table('users')->insert([
            'name' => "Kian",
            'about' => "page of",
            'email'=> "user1@mail.com",
            'password'=>"abc123",
        ]);
        DB::table('users')->insert([
            'name' => "John",
            'about' => "page of",
            'email'=> "user2@mail.com",
            'password'=>"abc123",
        ]);
        DB::table('users')->insert([
            'name' => "Lisa",
            'about' => "page of",
            'email'=> "user3@mail.com",
            'password'=>"abc123",
        ]);
        DB::table('users')->insert([
            'name' => "Brad",
            'about' => "page of",
            'email'=> "user4@mail.com",
            'password'=>"abc123",
        ]);
        DB::table('users')->insert([
            'name' => "Denise",
            'about' => "page of",
            'email'=> "user5@mail.com",
            'password'=>"abc123",
        ]);
        DB::table('users')->insert([
            'name' => "Amy",
            'about' => "page of",
            'email'=> "user6@mail.com",
            'password'=>"abc123",
        ]);
    }
}
