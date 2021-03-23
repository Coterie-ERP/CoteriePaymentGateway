<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'api/v1',
    'as' => 'coterie-payment-gateway.',
    'namespace' => 'Modules\CoteriePaymentGateway\Http\Controllers'
], function () {
    Route::prefix('/gateway')->group(function() {
        Route::prefix('receiver')->group(function(){
            Route::any('/', function(){
                echo 'test successful';
            });
            Route::any('/online', [\Modules\CoteriePaymentGateway\Http\Controllers\Receiver::class,'online']);
            Route::any('/validate', [\Modules\CoteriePaymentGateway\Http\Controllers\Receiver::class,'validate']);
            Route::any('/offline', [\Modules\CoteriePaymentGateway\Http\Controllers\Receiver::class,'offline']);
            Route::post('/register', [\Modules\CoteriePaymentGateway\Http\Controllers\Receiver::class,'register'])->middleware('admin');
        });

//         Route::prefix('mpesa');
    });
});
