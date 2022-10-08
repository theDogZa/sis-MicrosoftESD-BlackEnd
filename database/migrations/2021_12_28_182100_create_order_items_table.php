<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->comment('order_id');
            $table->bigInteger('inventory_id');
            $table->string('license_key')->nullable();
            $table->dateTime('license_at')->nullable();
            $table->bigInteger('created_uid');
            $table->bigInteger('updated_uid')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('inventory_id')->references('id')->on('inventory');
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
        Schema::dropIfExists('order_items');
    }
}
