<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('product_code')->unique();
            $table->unsignedMediumInteger('product_price')->default(0);
            $table->unsignedInteger('product_stock')->default(0);
            $table->unsignedInteger('alert_quantity')->default(1);
            $table->longText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->longText('additional_info')->nullable();
            $table->string('product_image')->nullable()->default('default-product.png');
            $table->unsignedSmallInteger('product_rating')->nullable()->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
