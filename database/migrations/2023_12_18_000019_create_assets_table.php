<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('asset_model_id')->nullable();
            $table->unsignedBigInteger('asset_category_id')->nullable();
            $table->string('code')->nullable();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->nullable()->default('available');
            $table->date('purchase_date')->nullable();
            $table->double('purchase_cost')->nullable()->default(0);
            $table->string('order_number')->nullable();
            $table->integer('warranty_in_months')->nullable();
            $table->longText('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
