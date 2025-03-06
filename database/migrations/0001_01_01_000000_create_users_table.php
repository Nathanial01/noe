<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->text('residential_address')->nullable();
            $table->string('government_id')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('social_security_number')->nullable();
            $table->string('proof_of_address')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('source_of_income')->nullable();
            $table->string('annual_income_range')->nullable();
            $table->decimal('net_worth', 15, 2)->nullable();
            $table->string('investment_experience')->nullable();
            $table->string('risk_tolerance')->nullable();
            $table->text('investment_objectives')->nullable();
            $table->boolean('terms_agreed')->default(false);
            $table->boolean('privacy_policy_consented')->default(false);
            $table->boolean('risk_disclosure_agreed')->default(false);
            $table->string('tax_form')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
