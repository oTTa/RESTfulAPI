<?php

use Illuminate\Database\Seeder;
use App\Vehiculo;
use App\Fabricante;
use Faker\Factory as Faker;

class VehiculoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{   
            $faker = Faker::create();
            $cantidad = Fabricante::all()->count();
            
            for ($j=0; $j<$cantidad; $j++){
                for ($i=0; $i<3 ; $i++)
                {
                    Vehiculo::create
                        ([
                            'color' => $faker->safeColorName(),
                            'cilindraje' => $faker->randomFloat(2,0,1000),
                            'potencia' => $faker->randomNumber(3),
                            'peso' => $faker->randomFloat(2,800,2000),
                            'fabricante_id' => $faker->numberBetween(1, $cantidad)
                        ]);
                }
            }
	}

}

