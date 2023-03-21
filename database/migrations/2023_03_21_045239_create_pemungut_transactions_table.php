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
        Schema::create('pemungut_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('status');
            $table->unsignedBigInteger('pemungut_id');
            $table->bigInteger('total');
            $table->timestamps();

            
            $table->foreign('pemungut_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemungut_transactions');
    }
};
