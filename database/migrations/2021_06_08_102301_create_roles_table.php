<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('slug');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->bigInteger('created_uid');
            $table->bigInteger('updated_uid')->nullable();
            $table->timestamps();

            $table->foreign('created_uid')->references('id')->on('users');
            $table->foreign('updated_uid')->references('id')->on('users');

        });
    }

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
