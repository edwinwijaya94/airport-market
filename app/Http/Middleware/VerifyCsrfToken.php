<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //Add order and order line
    	'api/virtualmarket/order/add',
    	'api/virtualmarket/order/add/*',
        'api/virtualmarket/rating/add',
        'api/virtualmarket/feedback/add',
        'api/virtualmarket/orderline/*',
        'api/virtualmarket/user/edit',
        'api/virtualmarket/garendong/register',
    ];
}
