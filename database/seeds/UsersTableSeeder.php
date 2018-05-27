<?php

use Illuminate\Database\Seeder;
use DLG\User;
use DLG\Activity;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{

    public function run()
    {

        $users = [

            // SysAdmin
            [
                "fname" => "Mark",
                "lname" => "De Vera",
                "email" => "mark.devera@dlsl.edu.ph",
                "password" => bcrypt("sirmark"),
                "mobile" => "09123456789",
                "address" => "De La Salle Lipa",
                "access" => "SysAdmin",
                "token" => str_random(10),
                "remember_token" => str_random(10),
                "last_login" => "None"
            ],

            [
                "fname" => "Keena",
                "lname" => "Mendoza",
                "email" => "keenamendoza@gmail.com",
                "password" => bcrypt("keena"), 
                "mobile" => "09171120667",  
                "address" => "#428 Zone 3 Brgy. Pinagkawitan, Lipa City, Batangas", 
                "access" => "SysAdmin", 
                "token" => str_random(10), 
                "remember_token" => str_random(10),
                "last_login" => "None"
            ],

            // Manager
            [
                "fname" => "Serine",
                "lname" => "Obviar",
                "email" => "serineobviar@gmail.com",
                "password" => bcrypt("serine"),
                "mobile" => "09267572433",
                "address" => "Granja, Lipa City, Batangas",
                "access" => "Manager",
                "token" => str_random(10),
                "remember_token" => str_random(10),
                "last_login" => "None"
            ],

            // Farm Hand
            [
                "fname" => "John",
                "lname" => "Doe",
                "email" => "johndoe@maildrop.cc",
                "password" => bcrypt("johndoe"),
                "mobile" => "09123456789",
                "address" => "Brgy. Lodlod, Lipa City",
                "access" => "Farm Hand",
                "token" => str_random(10),
                "remember_token" => str_random(10),
                "last_login" => "None"
            ],

            // Veterinarian
            [
                "fname" => "Dr. Jane",
                "lname" => "Smith",
                "email" => "janesmith@maildrop.cc",
                "password" => bcrypt("jane"),
                "mobile" => "09123456789",
                "address" => "Brgy. Antipolo, Lipa City",
                "access" => "Veterinarian",
                "token" => str_random(10),
                "remember_token" => str_random(10),
                "last_login" => "None"
            ]
        ];

        foreach ($users as $user)
        {
            User::create($user);
        }

    }
}
