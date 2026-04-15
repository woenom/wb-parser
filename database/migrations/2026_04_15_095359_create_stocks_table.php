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
        Schema::create('stocks', function (Blueprint $table) {
            // Идентификаторы
            $table->id()->unique();
            $table->bigInteger('nm_id')->unique();
            $table->bigInteger('barcode');
            $table->string('sc_code')->nullable();

            // Характеристики
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();

            // Склад и логистика
            $table->string('warehouse_name');
            $table->integer('quantity')->default(0);
            $table->integer('quantity_full')->nullable(); // Полный остаток
            $table->integer('in_way_to_client')->nullable(); // В пути к клиенту
            $table->integer('in_way_from_client')->nullable(); // В пути от клиента

            // Финансы и флаги
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->boolean('is_supply')->nullable();
            $table->boolean('is_realization')->nullable();

            // Даты
            $table->date('date');
            $table->date('last_change_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
