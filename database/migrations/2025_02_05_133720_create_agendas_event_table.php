<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendas_event', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('start_daytime');
            $table->dateTime('end_daytime');
            $table->string('place');
            $table->string('location');
            $table->text('description');
            $table->string('event_url')->nullable();
            $table->boolean('cancelled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas_event');
    }
};
