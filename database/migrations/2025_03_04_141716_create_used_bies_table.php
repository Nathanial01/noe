<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('used_bies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Adjust columns based on your needs
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('used_bies');
    }
};
