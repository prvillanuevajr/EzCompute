<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address');
            $table->string('phone_number');
            $table->boolean('is_admin')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        \App\User::create([
            "id" => 1,
            "name" => "Presmelito Villanueva",
            "email" => "prvillanuevajr@gmail.com",
            "address" => "Blk 2 Lot 18 Sinag St Mandaluyong City",
            "phone_number" => "09053362953",
            "password" => \Illuminate\Support\Facades\Hash::make('admin'),
        ]);
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
}
