<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->index();
            $table->string('maternal_name')->nullable();
            $table->string('fraternal_name')->nullable();
            $table->bigInteger('mother_id')->unsigned()->nullable();
            $table->bigInteger('father_id')->unsigned()->nullable();
            $table->boolean('demo')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

//        Schema::table('families', function (Blueprint $table) {
//            $table->foreign('mother_id')->references('id')->on('users')->onDelete('set NULL');
//            $table->foreign('father_id')->references('id')->on('users')->onDelete('set NULL');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('families');
    }
}
