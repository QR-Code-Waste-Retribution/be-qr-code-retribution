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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->string('status');
            $table->string('date');
            $table->enum('type', ["CASH", "NONCASH"]);
            $table->string('reference_number')->nullable();
            $table->string('transaction_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pemungut_id')->nullable();
            $table->unsignedBigInteger('sub_district_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('pemungut_id')
                ->references('id')
                ->on('users');

            $table->foreign('sub_district_id')
                ->references('id')
                ->on('sub_districts');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
