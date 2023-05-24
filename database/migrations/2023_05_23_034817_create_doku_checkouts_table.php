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
        Schema::create('doku_checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 255);
            $table->string('session_id', 255);
            $table->string('payment_method_types', 255);
            $table->string('payment_due_date', 255);
            $table->string('payment_token_id', 255);
            $table->string('payment_url', 255);
            $table->string('payment_expired_date', 255);
            $table->string('uuid', 255);
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
        Schema::dropIfExists('doku_checkouts');
    }
};
