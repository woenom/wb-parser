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
        Schema::create('incomes', function (Blueprint $table) {
            // Идентификаторы
            $table->id()->unique();
            $table->bigInteger('income_id')->unique();
            $table->bigInteger('nm_id');
            $table->bigInteger('barcode');
            $table->string('number')->nullable();
            
            // Характеристики товара
            $table->string('supplier_article');
            $table->string('tech_size');
            
            // Склад и количество
            $table->string('warehouse_name');
            $table->integer('quantity');
            
            // Финансы
            $table->decimal('total_price', 10, 2)->default(0);
            
            // Даты
            $table->date('date');
            $table->date('last_change_date');
            $table->date('date_close');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
