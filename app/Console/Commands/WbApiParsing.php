<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Serveces\WbParsingServece;

#[Signature('app:wb-api-parsing')]
#[Description('Command description')]
class WbApiParsing extends Command
{
    public function handle(WbParsingServece $parser)
    {
        // Значения
        $date_from_default = config('services.wb.date_from_default');

        // Сообщение
        $this->info('Начало обработки...');

        // Эндпоинты
        $endpoints = [
            'sales' => 'api/sales',
            'orders' => 'api/orders',
            'stocks' => 'api/stocks',
            'incomes' => 'api/incomes',
        ];
        
        // Идентификаторы каждой из таблиц
        $uniqueKeys = [
            'sales'   => 'g_number',
            'orders'  => 'g_number',
            'stocks'  => 'nm_id',
            'incomes' => 'income_id',
        ];

        // Цикл для парсинга
        foreach ($endpoints as $table => $url) {
            $this->line("Обработка {$table}...");

            // Конструирование даты в зависимости от эндпоинта
            $date = match($table) {
                'stocks' => date('Y-m-d'),
                default  => $date_from_default,
            };

            // Присвоение идентификатора
            $uniqueKey = (array)($uniqueKeys[$table] ?? ['id']);

            // Парсинг
            $parser->parseEndpoint($this, $table, $url, $date, $uniqueKey);
        }

        // Сообщение
        $this->info('Данные стянуты успешно');
    }
}
