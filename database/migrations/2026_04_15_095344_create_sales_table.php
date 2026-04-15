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
        Schema::create('sales', function (Blueprint $table) {
            // Идентификаторы
            $table->id()->unique();
            $table->string('g_number')->unique();
            $table->string('sale_id');
            $table->bigInteger('income_id');
            $table->bigInteger('nm_id');
            $table->bigInteger('barcode');
            $table->bigInteger('odid')->nullable();

            // Текстовые поля и артикулы
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            
            // География и склад
            $table->string('warehouse_name');
            $table->string('country_name');
            $table->string('oblast_okrug_name');
            $table->string('region_name');

            // Финансы (используем decimal для точности)
            $table->decimal('total_price', 10, 2);
            $table->integer('discount_percent');
            $table->decimal('promo_code_discount', 10, 2)->nullable();
            $table->decimal('spp', 10, 2)->default(0);
            $table->decimal('for_pay', 10, 2);
            $table->decimal('finished_price', 10, 2);
            $table->decimal('price_with_disc', 10, 2);

            // Флаги (boolean)
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);
            $table->integer('is_storno')->nullable();

            // Даты
            $table->date('date');
            $table->date('last_change_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
