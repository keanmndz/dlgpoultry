<?php

use Illuminate\Database\Seeder;
use DLG\Customers;

class CustomersTableSeeder extends Seeder
{

    public function run()
    {
        $customer =
        [
        	[
                'lname' => 'Bernardo', 
                'fname' => 'Kathryn', 
                'mname' => 'Bayanin',
                'email' => 'kathryn@maildrop.cc',
                'password' => bcrypt('kathryn'), 
                'company' => 'ABS-CBN', 
                'address' => 'Nueva Ecija', 
                'contact' => '09123456789',
                'token' => str_random(10),
                'remember_token' => str_random(10)
            ],
        	
            [
                'lname' => 'Rodriguez', 
                'fname' => 'Malia', 
                'mname' => 'Bayanin', 
                'email' => 'malia@maildrop.cc',
                'password' => bcrypt('malia'),
                'company' => 'La Luna Sangre', 
                'address' => 'San Isidro', 
                'contact' => '09123456789',
                'token' => str_random(10),
                'remember_token' => str_random(10)
            ],
        	
            [
                'lname' => 'Wilson', 
                'fname' => 'Georgina', 
                'mname' => 'Ricohermoso', 
                'email' => 'georgina@maildrop.cc',
                'password' => bcrypt('georgina'),
                'company' => 'Star World', 
                'address' => 'Kansas, USA', 
                'contact' => '09123456789',
                'token' => str_random(10),
                'remember_token' => str_random(10) 
            ],
        	
            [
                'lname' => 'Padilla', 
                'fname' => 'Daniel', 
                'mname' => 'Villanueva', 
                'email' => 'daniel@maildrop.cc',
                'password' => bcrypt('daniel'),
                'company' => 'ABS-CBN', 
                'address' => 'Manila', 
                'contact' => '09123456789',
                'token' => str_random(10),
                'remember_token' => str_random(10)
            ],
        	
            [
                'lname' => 'Pangilinan', 
                'fname' => 'Rya', 
                'mname' => 'Bayanin', 
                'email' => 'rya@maildrop.cc',
                'password' => bcrypt('ryap'),
                'company' => 'DLSL CSO', 
                'address' => 'San Jose, Batangas', 
                'contact' => '09123456789',
                'token' => str_random(10),
                'remember_token' => str_random(10)
            ],

            [
                'lname' => 'Dy Bunteng', 
                'fname' => 'Joanne', 
                'mname' => 'Delos Santos', 
                'email' => 'joandybunteng@gmail.com',
                'password' => bcrypt('frosty'),
                'company' => 'Yakult Batangas', 
                'address' => 'Lipa City', 
                'contact' => '09175370602',
                'token' => str_random(10),
                'remember_token' => str_random(10)
            ],
        ];

        foreach($customer as $cust)
        {
        	Customers::create($cust);
        }
    }
}
