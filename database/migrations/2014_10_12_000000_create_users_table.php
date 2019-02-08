<?php

use App\User;
use App\Libs\Datamap;
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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->boolean('admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(bcrypt(str_random(64)));
            $table->rememberToken();
            $table->string('language')->default(Datamap::getAppLanguages()->pluck('locale')->first());
            $table->timestamps();
        });

        User::flushEventListeners();
        User::forceCreate(Datamap::getFirstAdmin());
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
