<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_agents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('event_id')->references('id')->on('events')->onDelete('CASCADE');
            $table->string('code');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_agents');
    }
}
