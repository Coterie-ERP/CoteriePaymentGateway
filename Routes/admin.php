<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'coterie-payment-gateway.',
    'namespace' => 'Modules\CoteriePaymentGateway\Http\Controllers'
], function () {
    Route::prefix('coterie-payment-gateway')->group(function() {
    });
});
