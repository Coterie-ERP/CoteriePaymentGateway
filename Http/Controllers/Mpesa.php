<?php

namespace Modules\CoteriePaymentGateway\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CoteriePaymentGateway\Billing\PaymentGateway;

class Mpesa extends Controller
{
    public function initiateSTK(PaymentGateway $paymentGateway,Request $request)
    {
        $this->validate($request,[
            'phone_number'=>'required|numeric',
            'amount'=>'required|numeric|gt:0',
            'reference'=>'required',
            'description'=>'required',
            'company_id'=>'required'
        ]);

        // send the stk request
        $paymentGateway->mpesa();
        $paymentGateway->setReference($request->reference);
        $paymentGateway->setDescription($request->description);
        $paymentGateway->setCompanyId($request->company_id);
        $paymentGateway->charge($request->amount);
        $paymentGateway->setChargeAccount($request->phone_number);
        $paymentGateway->setMerchantAccount('default');
        dd($paymentGateway->process());
    }
}
