<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('street');
            $table->string('municipality')->nullable();
            $table->integer('house_number');
            $table->string('house_number_addition')->nullable();
            $table->string('house_letter')->nullable();
            $table->string('postal_code');
            $table->string('type');
            $table->integer('construction_year')->nullable();
            $table->boolean('csv_imported')->default(false);
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('avatar')->nullable();
            $table->string('reference')->unique();
            $table->date('label_expiration_date')->nullable();
            $table->date('label_registration_date')->nullable();
            $table->string('energy_index')->nullable();
            $table->string('energy_label')->nullable();
            $table->boolean('api')->default(false);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
