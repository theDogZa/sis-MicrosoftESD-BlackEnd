<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            
            $table->id();
            $table->bigInteger('billing_id')->comment('id to table billing');
            //$table->string('item_no', 15)->comment('INVOICE_ITEM');
            $table->string('serial', 25)->comment('SERIAL');
            $table->string('serial_long', 35)->comment('SERIAL_30');
            $table->string('imei', 35)->nullable()->comment('IMEI');
            $table->string('material_no', 25)->comment('article_no from sap');
            $table->string('serial_raw', 45)->comment('Serial RAW Data');
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('sale_status')->default(0)->comment('update on sale');
            $table->bigInteger('created_uid')->default(0)->comment('0 = system');
            $table->bigInteger('updated_uid')->nullable();
            $table->timestamps();

            $table->foreign('billing_id')->references('id')->on('billings');
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
        Schema::dropIfExists('inventory');
    }
}
