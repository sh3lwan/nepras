<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('birth_date');
            $table->integer('identity')->unsigned();
            $table->string('image');
            $table->string('address');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')
                ->references('id')->on('contracts')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees');
    }
}
