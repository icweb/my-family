<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarriagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marriages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('family_id')->unsigned();
            $table->bigInteger('partner_1_id')->unsigned();
            $table->bigInteger('partner_2_id')->unsigned();
            $table->bigInteger('partner_1_relationship_id')->unsigned()->nullable();
            $table->bigInteger('partner_2_relationship_id')->unsigned()->nullable();
            $table->boolean('demo')->default(0)->index();
            $table->timestamp('marriage_date')->nullable();
            $table->timestamp('divorce_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('marriages', function (Blueprint $table) {
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('partner_1_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('partner_2_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('partner_1_relationship_id')->references('id')->on('lookup_relationships')->onDelete('set NULL');
            $table->foreign('partner_2_relationship_id')->references('id')->on('lookup_relationships')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marriages');
    }
}
