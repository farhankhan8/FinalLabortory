<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Pname');
            $table->string('email');
            $table->string('phone');
            $table->datetime('start_time');
            $table->date('dob');
            $table->unsignedBigInteger ('patient_category_id');

            $table->foreign('patient_category_id')->references('id')->on('patient_categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('gend');            
            $table->timestamps();
        });
        DB::statement("ALTER TABLE patients AUTO_INCREMENT = 351759;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
