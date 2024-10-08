<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration{

    public function up(){
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->unique(); // Google Calendar event ID
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('events');
    }
}