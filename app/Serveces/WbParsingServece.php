<?php

namespace App\Serveces;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
class WbParsingServece
{
    public function parseEndpoint(string $table, string $endpoint, string $dateFrom, array $id, array $params = [])
    {
        // Значения
        $limit = config('services.wb.limit');;
        $key = config('services.wb.key');
        $baseUrl = config('services.wb.base_url');

        $cacheKey = "parser_page_{$table}";
        $page = cache()->get($cacheKey, 1);
        $pagesPerRun = 20; 
        $targetPage = $page + $pagesPerRun;

        do {
            // Запрос и конструирование запроса
            $response = Http::get("{$baseUrl}/{$endpoint}", array_merge([
                'dateFrom' => $dateFrom,
                'dateTo' => date('Y-m-d'),
                'page' => $page,
                'limit' => $limit,
                'key' => $key
            ], $params));

            // Присвоение данных из Json
            $data = $response->json();
            $items = $data['data'] ?? [];

            // Заполнение таблицы
            if (!empty($items)) {
                DB::table($table)->upsert($items, $id, array_keys($items[0]));
                
                $page++;
                // Сохраняем прогресс после каждой успешной страницы
                cache()->put($cacheKey, $page); 
            }
            
            // Сброс счётчика
            if (empty($items)) {
                cache()->forget($cacheKey);
                break;
            }

        } while ($page < $targetPage);
    }

}