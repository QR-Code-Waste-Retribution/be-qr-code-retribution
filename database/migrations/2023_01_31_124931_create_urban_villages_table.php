<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urban_villages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('sub_district_id');
            $table->foreign('sub_district_id')
                    ->references('id')
                    ->on('sub_districts');
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
        Schema::dropIfExists('urban_villages');
    }
};
