<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            
            $table->id();
            $table->string('sold_to', 15)->comment('T_HEADER->SOLDTO');
            $table->string('billing_no', 15);
            $table->string('billing_item', 15);
            $table->date('billing_at')->comment('T_HEADER->BILLING_DOCDATE');
            $table->string('material_no', 25)->comment('article_no');
            $table->longText('material_desc', 100)->nullable();
            $table->integer('qty');
            $table->string('po_no', 15)->comment('gr_po_no');
            $table->string('vendor_article', 40)->comment('path_no');
            $table->tinyInteger('active')->default(1);
            $table->integer('sale_count')->default(0);
            $table->bigInteger('created_uid')->default(0)->comment('0 = system');
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
        Schema::dropIfExists('billings');
    }
}
