<?php

namespace Modules\CoteriePaymentGateway\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Modules\CoteriePaymentGateway\Mpesa\Logger;

/**
 * Class Receiver
 *
 * @package Modules\CoteriePaymentGateway\Http\Controllers
 * @author  isaac
 */
class Receiver extends Controller
{

    private const STK='STK';
    private const C2B='C2B';
    private const B2B='B2B';
    private const B2C='B2C';
    private const REVERSAL='REVERSAL';


    /**
     * @param Request $request
     * @param Logger  $logger
     *
     * @author isaac
     */
    public function online(Request $request,Logger $logger)
    {
        $request=(object) $request->all();
        dd($request);
        $logger->persist($request,self::STK);
    }

    /**
     * @param Request $request
     *
     * @author isaac
     */
    public function offline(Request $request)
    {
        dd($request->all());
    }

    /**
     * @param Request $request
     *
     * @author isaac
     */
    public function pullTransactions(Request $request)
    {
        
    }

    /**
     * @param Request $request
     *
     * @author isaac
     */
    public function queueTimeout(Request $request)
    {
        
    }

    /**
     * @param Request $request
     *
     * @author isaac
     */
    public function register(Request $request)
    {
        
    }
}
