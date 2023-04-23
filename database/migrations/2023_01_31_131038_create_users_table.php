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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nik')->unique()->nullable();
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->text('address')->nullable();
            $table->string('phoneNumber')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('sub_district_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('role_id')->default(1);
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');

            $table->foreign('sub_district_id')
                ->references('id')
                ->on('sub_districts');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
