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
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('pemungut_id');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('pemungut_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['districts_id']);
            $table->dropColumn('pemungut_id');
            $table->dropColumn('district_id');
        });
    }
};
