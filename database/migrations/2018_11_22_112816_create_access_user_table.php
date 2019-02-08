<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('access_id')->nullable();
            $table->foreign('access_id')
                ->references('id')
                ->on('accesses');

            $table->timestamps();
        });

        User::flushEventListeners();
        $user = User::first();
        $user->accesses()->attach(1);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_user');
    }
}
