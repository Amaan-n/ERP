<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->unsignedBigInteger('asset_category_id')->nullable();
            $table->unsignedBigInteger('field_group_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->string('model_number')->nullable();
            $table->longText('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('asset_models');
    }
}
