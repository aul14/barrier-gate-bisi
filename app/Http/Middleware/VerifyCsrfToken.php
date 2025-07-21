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
        'api_cpi',
        'api_cpi/status',
        'api_cpi/registrasi',
        'api_cpi/regis_token',
        'api_cpi/delete'
    ];
}
