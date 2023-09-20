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
            $table->longText('aditional_info')->nullable();
            $table->string('product_image')->nullable()->default('default-product.jpg');
            $table->unsignedSmallInteger('product_rating')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
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
