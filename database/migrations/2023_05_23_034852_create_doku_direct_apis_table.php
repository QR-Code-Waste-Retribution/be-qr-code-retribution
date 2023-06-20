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
        Schema::create('doku_direct_apis', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 255);
            $table->string('virtual_account_number', 255);
            $table->string('how_to_pay_page', 255);
            $table->string('how_to_pay_api', 255);
            $table->string('created_date', 255);
            $table->string('expired_date', 255);
            $table->string('created_date_utc', 255);
            $table->string('expired_date_utc', 255);
            $table->unsignedBigInteger('masyarakat_transaction_id')->nullable();
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
        Schema::dropIfExists('doku_direct_apis');
    }
};
