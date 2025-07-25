<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('company_description');
            $table->text('company_address');
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('company_website')->nullable();
            $table->string('whatsapp_number');
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->json('business_hours')->nullable(); // jam operasi
            $table->text('terms_and_conditions')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->decimal('shipping_fee', 8, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0); // dalam peratus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};
