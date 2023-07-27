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
        Schema::create('masyarakat_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->string('status'); // [0 EXPIRED] || [1 PENDING] || [2 SUCCESS] || [3 CANCELLED]
            $table->integer('verification_status')->default(0);
            $table->string('date');
            $table->enum('type', ["CASH", "NONCASH"]);
            $table->string('invoice_number')->unique();
            $table->string('reference_number')->nullable();
            $table->string('transaction_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pemungut_id')->nullable();
            $table->unsignedBigInteger('sub_district_id')->nullable();
            $table->unsignedBigInteger('pemungut_transaction_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('pemungut_transaction_id')
                ->references('id')
                ->on('pemungut_transactions');

            $table->foreign('pemungut_id')
                ->references('id')
                ->on('users');

            $table->foreign('sub_district_id')
                ->references('id')
                ->on('sub_districts');
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
