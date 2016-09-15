<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
            $this->call('FabricanteSeeder');
            $this->call('VehiculoSeeder');
            
            User::truncate();//elimina todo lo que hay en la tabla e inserta de nuevo.
            $this->call('UserSeeder');
	}

}
