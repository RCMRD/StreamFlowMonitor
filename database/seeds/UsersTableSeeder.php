<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	 
    public function run()
    {
		
		$first_name="Joseph";
	    $last_name="Chemutt";
	    $shortcode = gen_team_member_short_code($first_name. " ". $last_name);
		$user = new User();

        
             $user->short_code  = $shortcode;
             $user->first_name = $first_name;
             $user->last_name = $last_name;
             $user->email   = 'chemuttjose@gmail.com';
             $user->password  =Hash::make('123456');
             //'is_administrator'  => TRUE, // Administrator
			 
         
		 
		 $user->save();
			
			$role=Role::find(1);
			$user->attachRole($role);


    }


}
