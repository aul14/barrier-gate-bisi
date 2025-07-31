<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api_bisi',
        'api_bisi/status',
        'api_bisi/registrasi',
        'api_bisi/regis_token',
        'api_bisi/delete',
        'api_bisi/store_log_plc'
    ];
}
