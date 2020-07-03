<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name', 80)->nullable(false);
            $table->string('last_name', 80)->nullable(false);
            $table->string('email', 50)->nullable(false);
            $table->string('user_name', 6)->unique();
            $table->text('password');
            $table->enum('role', ['admin', 'employee']);
            $table->boolean('status')->default(1);
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
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
        Schema::dropIfExists('users');
    }
}
