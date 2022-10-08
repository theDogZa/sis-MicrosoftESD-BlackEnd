<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            
            $table->id();
            $table->string('customer_name')->comment('customer name');
            $table->string('email')->comment('customer email');
            $table->string('tel', 15)->comment('customer tel');
            $table->string('path_no', 40)->comment('VENDOR_ARTICLE');
            $table->string('receipt_no')->comment('receipt number PWM');  
            $table->bigInteger('sale_uid')->comment('user_id sale by order');
            $table->dateTime('sale_at')->comment('date time sale by order');
            $table->bigInteger('created_uid');
            $table->bigInteger('updated_uid')->nullable();
            $table->timestamps();

            $table->foreign('sale_uid')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
