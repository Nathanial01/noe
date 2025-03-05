<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->integer('points')->default(0);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->json('questions')->nullable();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('pre_juli_contract')->default(false);
            $table->boolean('new_construction_raise')->default(false);
            $table->timestamp('finished_at')->nullable();
            $table->boolean('is_trial_calc')->default(false);
            $table->boolean('duplication_finished')->default(false);
            $table->string('api_pdf_url')->nullable();
            $table->string('status')->nullable();
            $table->string('path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checks');
    }
};
