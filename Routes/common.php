<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'coterie-payment-gateway.',
    'namespace' => 'Modules\CoteriePaymentGateway\Http\Controllers'
], function () {
    Route::prefix('coterie-payment-gateway')->group(function() {
        /**
         * Initiate STK transaction
         */
        Route::post('mpesa/initiate/stk',[\Modules\CoteriePaymentGateway\Http\Controllers\Mpesa::class,'initiateSTK']);
    });
});
