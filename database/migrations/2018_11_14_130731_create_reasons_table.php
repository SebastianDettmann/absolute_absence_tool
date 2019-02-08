<?php

use App\Reason;
use App\Libs\Datamap;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('hex_color')->default('#a0a0a0');
            $table->boolean('has_to_confirm')->default(false);
            $table->timestamps();
        });


        Reason::flushEventListeners();
        foreach (Datamap::getAbsenceReasons() as $reason){
            array_forget($reason, 'id');
            Reason::forceCreate($reason);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reasons');
    }
}
