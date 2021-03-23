<?php


namespace Modules\CoteriePaymentGateway\Mpesa;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Logger
{
    private const FILE_STORAGE = 'file';
    private const DATABASE = 'database';
    private const LOGGER = 'logger';
    private $driver=self::FILE_STORAGE;

    public function __construct()
    {
        $this->config();
    }

    public function config()
    {
    }

    public function persist($data, $type = null)
    {
        $timestamp = Carbon::now()->timestamp;

        // log to file storage
        if ($this->driver == self::FILE_STORAGE) {
            $timestamp = Carbon::now()->timestamp;
            Storage::put($type . '/stk_' . $timestamp . '.log', print_r($data, true));
        }

        // log to database
        if ($this->driver == self::DATABASE) {
            // todo Save to database
        }

        // log to default log manager
        if ($this->driver == self::LOGGER) {
            Log::info('STK:: ' . $timestamp . ': ' . $data);
        }
    }
}