<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableTestInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('available_test_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('available_test_id');
            $table->string('inventory_id');
            $table->bigInteger('itemUsed');
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
        Schema::dropIfExists('available_test_inventories');
    }
}
