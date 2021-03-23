<?php


namespace Modules\CoteriePaymentGateway\Billing;


use Carbon\Carbon;
use Illuminate\Support\Str;

class Transaction
{
    /**
     * @param $transaction
     * @param $company_id
     *
     * @return string
     * @author isaac
     */
    public function generate($transaction,$company_id): string
    {
        /**
         * Syntax : Random 6 digits:_Company_id:_transaction
         */

        // date month year
        $date=Carbon::now();

        return base_convert($date->year,10,16).':'.base_convert($date->month,10,16).':'.base_convert($date->day,10,2).':'.base_convert($company_id,10,16).':'.$transaction;
    }

    public function read($transaction)
    {
        return explode(':',$transaction)[4];
    }
}