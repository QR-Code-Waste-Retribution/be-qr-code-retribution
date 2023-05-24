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
        Schema::create('payment_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('acquirer');
            $table->string('channel');
            $table->bigInteger('amount');
            $table->string('original_request_id');
            $table->string('date');
            $table->unsignedBigInteger('masyarakat_transaction_id');
            $table->timestamps();

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
        Schema::dropIfExists('payment_notifications');
    }
};
