<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("body");

            $table->unsignedBigInteger("post_id");
            $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade");

            $table->unsignedBigInteger("commenter_id");
            $table->foreign("commenter_id")->references("id")->on("users")->onDelete("cascade");

            $table->tinyInteger('parent_id')->default("0")->nullable();

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
        Schema::dropIfExists('comments');
    }
}
