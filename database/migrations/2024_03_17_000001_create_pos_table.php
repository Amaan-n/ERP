<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('invoice_number')->nullable();
            $table->unsignedBigInteger('customer_id')->default(0)->nullable();
            $table->string('status')->comment('pending, completed, canceled');
            $table->double('invoice_amount')->default(0);
            $table->string('discount_type')->comment('fixed, percentage')->nullable();
            $table->double('discount_value')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('refund_amount')->default(0);
            $table->double('final_amount')->default(0);
            $table->string('payment_type')->nullable();
            $table->string('charge_id')->nullable();
            $table->string('charge_url')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamp('payment_captured_at')->nullable();
            $table->longText('payment_response')->nullable();
            $table->text('notes')->nullable();
            $table->string('created_from')->default('admin')->comment('admin, pos');
            $table->unsignedInteger('created_by')->default(0)->nullable();
            $table->unsignedInteger('updated_by')->default(0)->nullable();
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
        Schema::dropIfExists('pos');
    }
}
