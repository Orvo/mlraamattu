<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(!User::where('email', 'admin')->exists())
    	{
			$user 				= new User();
			
			$user->name 		= "Ylläpitäjä";
			$user->email 		= "admin";
			$user->password 	= Hash::make("password");
			$user->access_level = 1;
					
			$user->save();
			
			echo "Created user ID " . $user->id . "\n";
			echo "Updating credentials is recommended!\n";
    	}
    	else
    	{
    		echo "Admin user already exists with default credentials!\n";
    	}
    }
}
