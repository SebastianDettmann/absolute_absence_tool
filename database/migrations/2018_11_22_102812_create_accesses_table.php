<?php

use App\Access;
use App\Libs\Datamap;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Access::flushEventListeners();

        foreach (Datamap::getAccessPoints() as $access){
            array_forget($access, 'id');
            Access::forceCreate($access);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesses');
    }
}
