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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('attribute_key', 100); // power, voltage, flow_rate, etc.
            $table->string('attribute_value', 255)->nullable(); // giá trị của thuộc tính
            $table->string('attribute_unit', 50)->nullable(); // đơn vị: HP, V, L/phút, etc.
            $table->text('attribute_description')->nullable(); // mô tả thuộc tính
            $table->integer('sort_order')->default(0); // thứ tự hiển thị
            $table->boolean('is_visible')->default(true); // có hiển thị không
            $table->timestamps();
            
            // Index
            $table->index(['product_id', 'attribute_key']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
