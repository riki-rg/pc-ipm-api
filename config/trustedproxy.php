<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Semua traffic masuk via Cloudflare Tunnel -> webstack-nginx -> sidecar
    | nginx (pc-ipm-api-web) -> php-fpm. Kita harus percaya proxy chain ini
    | supaya header X-Forwarded-Proto/Host dibaca dengan benar (HTTPS, domain).
    | Tanpa ini: signed URL Livewire upload gagal (401), cookie salah scheme.
    |
    */
    'proxies' => '*', // percaya semua (aman: hanya bisa diakses dari docker network internal)

    /*
    | Header proxy yang dipercaya (default Laravel sudah benar)
    */
    'headers' => [
        (defined('Illuminate\Http\Request::HEADER_X_FORWARDED_FOR') ? Illuminate\Http\Request::HEADER_X_FORWARDED_FOR : 'FORWARDED_FOR') => 'X-Forwarded-For',
        (defined('Illuminate\Http\Request::HEADER_X_FORWARDED_HOST') ? Illuminate\Http\Request::HEADER_X_FORWARDED_HOST : 'FORWARDED_HOST') => 'X-Forwarded-Host',
        (defined('Illuminate\Http\Request::HEADER_X_FORWARDED_PORT') ? Illuminate\Http\Request::HEADER_X_FORWARDED_PORT : 'FORWARDED_PORT') => 'X-Forwarded-Port',
        (defined('Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO') ? Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO : 'FORWARDED_PROTO') => 'X-Forwarded-Proto',
        (defined('Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB') ? Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB : 'FORWARDED_AWS_ELB') => 'X-Forwarded-Proto',
    ],
];
