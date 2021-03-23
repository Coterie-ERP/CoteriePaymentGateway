<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'portal',
    'middleware' => 'portal',
    'namespace' => 'Modules\CoteriePaymentGateway\Http\Controllers'
], function () {
    // Route::get('invoices/{invoice}/coterie-payment-gateway', 'Main@show')->name('portal.invoices.coterie-payment-gateway.show');
    // Route::post('invoices/{invoice}/coterie-payment-gateway/confirm', 'Main@confirm')->name('portal.invoices.coterie-payment-gateway.confirm');
});
