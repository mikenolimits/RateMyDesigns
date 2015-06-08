<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {
	public $seeders = ['UserTableSeeder','DesignsTableSeeder'];
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		foreach($this->seeders as $seed){
			$this->call($seed);
		}
		// $this->call('UserTableSeeder');
	}

}
