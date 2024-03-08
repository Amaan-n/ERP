<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('grid')->default(4);
            $table->string('key')->nullable();
            $table->string('display_text')->nullable();
            $table->boolean('is_visible')->default(1)->nullable();
            $table->text('value')->nullable();
            $table->string('input_type')->nullable()->default('text');
            $table->longText('options')->nullable();
            $table->integer('added_by')->unsigned()->nullable();
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
        Schema::dropIfExists('configurations');
    }
}
