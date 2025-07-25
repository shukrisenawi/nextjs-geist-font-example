<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->json('sizes')->nullable(); // ['S', 'M', 'L', 'XL'] untuk baju
            $table->json('materials')->nullable(); // jenis bahan
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // gambar tambahan
            $table->boolean('is_active')->default(true);
            $table->boolean('allow_custom_design')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
