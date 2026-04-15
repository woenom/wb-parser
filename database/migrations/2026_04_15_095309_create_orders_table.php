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
        Schema::create('orders', function (Blueprint $table) {
            // Идентификаторы
            $table->id()->unique();
            $table->bigInteger('income_id');
            $table->string('odid');
            $table->bigInteger('nm_id');
            $table->string('g_number')->unique();
            $table->bigInteger('barcode');
            
            // Текстовые поля и артикулы
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');

            // География и склад
            $table->string('warehouse_name');
            $table->string('oblast');

            // Финансы (используем decimal для точности)
            $table->decimal('total_price', 10, 2);
            $table->integer('discount_percent');

            // Флаги (boolean)
            $table->boolean('is_cancel')->default(false);
            
            // Даты
            $table->date('last_change_date');
            $table->dateTime('date');
            $table->timestamp('cancel_dt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
