<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('maiden_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->string('phone_home')->nullable();
            $table->string('phone_mobile')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip')->nullable();

            $table->bigInteger('gender_id')->nullable()->unsigned();
            $table->bigInteger('parent_1_id')->nullable()->unsigned();
            $table->bigInteger('parent_2_id')->nullable()->unsigned();
            $table->bigInteger('partner_id')->nullable()->unsigned();
            $table->bigInteger('parent_1_relationship_id')->nullable()->unsigned();
            $table->bigInteger('parent_2_relationship_id')->nullable()->unsigned();
            $table->bigInteger('partner_relationship_id')->nullable()->unsigned();

            $table->boolean('late')->default(0)->index();
            $table->boolean('historic')->default(0)->index();
            $table->boolean('demo')->default(0)->index();

            $table->timestamp('birthday')->nullable();
            $table->timestamp('wedding_anniversary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('gender_id')->references('id')->on('lookup_genders')->onDelete('set NULL');
            $table->foreign('parent_1_id')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('parent_2_id')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('partner_id')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('parent_1_relationship_id')->references('id')->on('lookup_relationships')->onDelete('set NULL');
            $table->foreign('parent_2_relationship_id')->references('id')->on('lookup_relationships')->onDelete('set NULL');
            $table->foreign('partner_relationship_id')->references('id')->on('lookup_relationships')->onDelete('set NULL');
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
