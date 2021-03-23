<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'api/v1',
    'as' => 'coterie-payment-gateway.',
    'namespace' => 'Modules\CoteriePaymentGateway\Http\Controllers'
], function () {
    Route::prefix('/gateway')->group(function() {
        Route::prefix('initiate')->group(function(){
            Route::any('/', function(){
                echo 'test successful';
            });
            Route::get('mpesa/stk',[\Modules\CoteriePaymentGateway\Http\Controllers\Mpesa::class,'initiateSTK']);
        });

//         Route::prefix('mpesa');
    });
});
