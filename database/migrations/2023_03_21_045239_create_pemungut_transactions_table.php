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
            $table->bigInteger('status')->default(0);
            $table->unsignedBigInteger('pemungut_id');
            $table->unsignedBigInteger('masyarakat_transaction_id')->nullable();
            $table->bigInteger('total');
            $table->dateTime('date');
            $table->timestamps();

            
            $table->foreign('pemungut_id')
                ->references('id')
                ->on('users');

            $table->foreign('masyarakat_transaction_id')
                ->references('id')
                ->on('masyarakat_transactions');
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
