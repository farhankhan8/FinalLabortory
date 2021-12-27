<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableTestsTable extends Migration
{

    public function up()
    {
        Schema::create('available_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('name')->unique();
            $table->string('testFee');
            $table->string('urgentFee');
            $table->integer('stander_timehour');
            $table->integer('urgent_timehour');
            $table->string('testCode');

            $table->string('resultValueCount');
            $table->string('type')->default(1);

            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('available_tests');
    }
}
