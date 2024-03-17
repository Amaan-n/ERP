<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosHasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_has_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pos_id')->default(0);
            $table->unsignedBigInteger('product_id')->default(0);
            $table->integer('quantity')->default(1);
            $table->double('amount')->default(0);
            $table->string('discount_type')->comment('fixed, percentage')->nullable();
            $table->double('discount_value')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('final_amount')->default(0);
            $table->longText('product_data')->nullable();
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
        Schema::dropIfExists('pos_has_products');
    }
}
