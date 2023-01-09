<?php

if (!function_exists('paginationData')) {
    function paginationData($data): array
    {
        return [
            "per_page" => $data->perPage(),
            "current_page" => $data->currentPage(),
            "total" => $data->total(),
            "last_page" => $data->lastPage(),
            "from" => $data->toArray()['from'],
            "to" => $data->toArray()['to']
        ];
    }
}
