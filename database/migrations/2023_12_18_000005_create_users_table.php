<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->default(0)->nullable();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('picture')->nullable();
            $table->string('password')->nullable();
            $table->string('LinkedIn_URL')->nullable();
            $table->string('twitter_URL')->nullable();
            $table->string('instagram_URL')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('is_root_user')->nullable()->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->longText('about')->nullable();
            $table->rememberToken();
            $table->string('reset_password_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
