<?php


    namespace Modules\CoteriePaymentGateway\Vault;

    use Exception;
    use Illuminate\Support\Facades\Http;

    class Vault
    {
        protected static  $VAULT_BASE_ENDPOINT;
        protected static  $VAULT_AUTH_PATH;
        protected static  $VAULT_TOKEN;
        protected static  $VAULT_USERNAME;
        protected static  $VAULT_PASSWORD;


        private static function login()
        {
            (new self)->setConfig();
            $baseUri=self::$VAULT_BASE_ENDPOINT;
            $auth_endpoint='/auth/'.self::$VAULT_AUTH_PATH.'/login/'.self::$VAULT_USERNAME;
            $endpoint=$baseUri . $auth_endpoint;
            try {
                $headers = [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ];
                $formParams=[
                    'password' => self::$VAULT_PASSWORD
                ];
                $response=Http::withoutVerifying()->withHeaders($headers)->asJson()->post($endpoint,$formParams)->object();
                self::$VAULT_TOKEN=$response->auth->client_token;
            }catch (\Throwable $e){
                throw new Exception($e->getMessage(),500);
            }
        }

        public static function store($path,array $data,$store='secret')
        {
            self::login();
            try {
                $endpoint = self::$VAULT_BASE_ENDPOINT . '/'.$store.'/data/' . $path;
                $headers = [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Vault-Token' => self::$VAULT_TOKEN
                ];
                $formParams=[
                    'json'=>[
                        'data'=>[
                            $data
                        ]
                    ]
                ];
                $response=GuzzleClient::request('POST',$endpoint,$headers,$formParams);
                $response=json_decode($response,false);
                return true;
            }catch (\Throwable $e){
                throw new Exception($e->getMessage(),500);
            }
        }

        public static function get($store,$path)
        {
            self::login();
            try {
                $baseUri = self::$VAULT_BASE_ENDPOINT . '/'.$store.'/data/' . $path;
                $headers = [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Vault-Token' => self::$VAULT_TOKEN
                ];
//                $response=GuzzleClient::request('GET',$baseUri,$headers);
                $response=Http::withoutVerifying()->withHeaders($headers)->get($baseUri);
                $response=json_decode($response,false);
                return $response;
            }catch (\Exception $e){
                throw new Exception($e->getMessage(),500);
            }
        }

        private function setConfig(): void
        {
            self::$VAULT_BASE_ENDPOINT=env('VAULT_SERVER');
            self::$VAULT_AUTH_PATH=env('VAULT_AUTH_METHOD_PATH');
            self::$VAULT_USERNAME=env('VAULT_USERNAME');
            self::$VAULT_PASSWORD=env('VAULT_PASSWORD');
        }

        public static function sealStatus()
        {
            (new self)->setConfig();
            return Http::withoutVerifying()->get(self::$VAULT_BASE_ENDPOINT.'/sys/seal-status')->json();
        }
    }
