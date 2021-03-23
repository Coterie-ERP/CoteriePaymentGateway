<?php


    namespace Modules\CoteriePaymentGateway\Mpesa;


    use Modules\CoteriePaymentGateway\Vault\Vault;

    class Config
    {
        public static function getConfig($driver)
        {
            if($driver=='vault'){
                $credentials=self::vault();
            }
        }

        private static function vault($store,$path)
        {
            return Vault::get($store,$path);
        }
    }
