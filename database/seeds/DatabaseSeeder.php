<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        factory('App\Contract', 2)->create();
        factory('App\Employee', 50)->create();
        factory('App\FamilyMember', 80)->create();


    }
}
