<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("role");
            $table->timestamps();
        });

        //This 
        /*DB::table('roles')->insert(
            [ 
                ["role" => "adminstrator"], 
                ["role" => "moderator"], 
                ["role" => "user"],
                ["role" => "peon"]
            ]
        );*/
        //

        //Or this
        //$this->createRoles("adminstrator", "moderator", "user", "peon");
    }

    //and this?
    /*private function createRoles(string ...$roles)  {
        foreach ($roles as $role) {
            $model = new Role();
            $model->setAttribute("role", $role);
            $model->save();
        }
    }*/

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
