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
    	'api/order/add',
    	'api/order/add/*',
        'api/rating/add',
        'api/feedback/add',
        'api/orderline/*',
        'api/user/edit',
        'api/shopper/register',
        'api/cart/add',
        'api/cart/edit',
    ];
}
