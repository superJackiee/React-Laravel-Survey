<?php

namespace App\Http\Middleware;

use App\Helper;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

define('VERIFY_CSRF_TOKEN_ROUTE_PREFIX', Helper::getDotEnvFileVar('LARAVEL_SURVEY_PREFIX_URL'));
define('VERIFY_CSRF_TOKEN_API_ROUTE_POST_SAVE_ANSWER', VERIFY_CSRF_TOKEN_ROUTE_PREFIX.'/api/save_answer');
define('VERIFY_CSRF_TOKEN_API_ROUTE_POST_SESSION_ID', VERIFY_CSRF_TOKEN_ROUTE_PREFIX.'/*/session_id');
define('VERIFY_CSRF_TOKEN_API_ROUTE_FETCH_COUNTRY_INFO', VERIFY_CSRF_TOKEN_ROUTE_PREFIX.'/api/fetch_country_info');

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        VERIFY_CSRF_TOKEN_API_ROUTE_POST_SESSION_ID,
        VERIFY_CSRF_TOKEN_API_ROUTE_POST_SAVE_ANSWER,
        VERIFY_CSRF_TOKEN_API_ROUTE_FETCH_COUNTRY_INFO,
    ];
}
