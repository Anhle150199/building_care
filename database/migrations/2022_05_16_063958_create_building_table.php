<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('address');
            $table->string('phone', 11)->nullable();
            $table->string('email')->nullable();
            $table->enum('status', array('active', 'lock', 'prepare'));
            $table->integer('height')->nullable();
            $table->integer('acreage')->comment("diện tích")->nullable();
            $table->integer('floors_number');
            $table->integer('apartment_number');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building');
    }
}
