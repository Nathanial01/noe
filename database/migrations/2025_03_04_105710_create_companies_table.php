<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->integer('house_number')->nullable();
            $table->string('house_number_addition')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('branding_name')->nullable();
            $table->string('branding_city')->nullable();
            $table->string('branding_street')->nullable();
            $table->integer('branding_house_number')->nullable();
            $table->string('branding_house_number_addition')->nullable();
            $table->string('branding_postal_code')->nullable();
            $table->boolean('wl_footer')->default(false);
            $table->integer('kvk_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->integer('credit_amount')->default(0);
            $table->string('promotional_code')->nullable();
            $table->string('status')->nullable();
            $table->boolean('renewal_mail_sent')->default(false);
            $table->date('billing_expiration_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('disclaimer_title')->nullable();
            $table->text('disclaimer_text')->nullable();
            $table->boolean('show_company_info')->default(true);
            $table->boolean('imported_csv')->default(false);
            $table->boolean('api_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
