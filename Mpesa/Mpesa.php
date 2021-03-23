<?php


namespace Modules\CoteriePaymentGateway\Mpesa;

use Modules\CoteriePaymentGateway\Vault\Vault;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Class Mpesa
 *
 * @package App\MPesa
 * @author  isaac
 */
class Mpesa extends HttpClient
{
    /**
     *
     */
    private const BASE_ENDPOINT = 'https://api.safaricom.co.ke';

    private const SANDBOX_BASE_ENDPOINT = 'https://sandbox.safaricom.co.ke';

    /**
     *
     */
    private const AUTH = '/oauth/v1/generate?grant_type=client_credentials';

    /**
     *
     */
    private const REGISTER_C2B_CALLBACKS = '/mpesa/c2b/v1/registerurl';

    /**
     *
     */
    private const STK = '/mpesa/stkpush/v1/processrequest';

    /**
     *
     */
    private const STK_STATUS = '/mpesa/stkpushquery/v1/query';

    /**
     *
     */
    private const TRANSACTION_STATUS = '/mpesa/transactionstatus/v1/query';

    /**
     *
     */
    private const PULL_TRANSACTIONS = '/pulltransactions/v1/query';

    /**
     *
     */
    private const PULL_TRANSACTIONS_REGISTER = '/pulltransactions/v1/register';

    /**
     *
     */
    private const B2C_INITIATE = '/mpesa/b2c/v1/paymentrequest';

    /**
     *
     */
    private const ACCOUNT_BALANCE = '/mpesa/accountbalance/v1/query';

    /**
     *
     */
    private const B2B_INITIATE = '/mpesa/b2b/v1/paymentrequest';

    /**
     *
     */
    private const REVERSAL = '/mpesa/reversal/v1/request';

    /**
     * @var
     * @author isaac
     */
    private $phone_number;
    /**
     * @var
     * @author isaac
     */
    private $stk_callback_url;
    /**
     * @var
     * @author isaac
     */
    private $amount;
    /**
     * @var
     * @author isaac
     */
    private $account;
    /**
     * @var
     * @author isaac
     */
    private $reference;
    /**
     * @var
     * @author isaac
     */
    private $description;
    /**
     * @var
     * @author isaac
     */
    private $validate_callback;
    /**
     * @var
     * @author isaac
     */
    private $confirm_callback;
    /**
     * @var
     * @author isaac
     */
    private $default_response;

    /**
     * @var
     * @author isaac
     */
    private $pull_transactions_callback;
    private $checkoutRequestId;
    private $b2c_queue_timeout_url;
    private $remarks;
    private $occasion;

    /**
     * @return mixed
     */
    public function getOccasion()
    {
        return $this->occasion;
    }

    /**
     * @param mixed $occasion
     */
    public function setOccasion($occasion): void
    {
        $this->occasion = $occasion;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     */
    public function setRemarks($remarks): void
    {
        $this->remarks = $remarks;
    }

    /**
     * @return mixed
     */
    public function getB2cQueueTimeoutUrl()
    {
        return $this->b2c_queue_timeout_url;
    }

    /**
     * @param mixed $b2c_queue_timeout_url
     */
    public function setB2cQueueTimeoutUrl($b2c_queue_timeout_url): void
    {
        $this->b2c_queue_timeout_url = $b2c_queue_timeout_url;
    }

    /**
     * @return mixed
     */
    public function getB2cResultUrl()
    {
        return $this->b2c_result_url;
    }

    /**
     * @param mixed $b2c_result_url
     */
    public function setB2cResultUrl($b2c_result_url): void
    {
        $this->b2c_result_url = $b2c_result_url;
    }
    private $b2c_result_url;

    /**
     * @return mixed
     */
    public function getCheckoutRequestId()
    {
        return $this->checkoutRequestId;
    }

    /**
     * @param mixed $checkoutRequestId
     */
    public function setCheckoutRequestId($checkoutRequestId): void
    {
        $this->checkoutRequestId = $checkoutRequestId;
    }

    /**
     * @return mixed
     */
    public function getPullTransactionsCallback()
    {
        return $this->pull_transactions_callback;
    }

    /**
     * @param mixed $pull_transactions_callback
     */
    public function setPullTransactionsCallback($pull_transactions_callback): void
    {
        $this->pull_transactions_callback = $pull_transactions_callback;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @var
     * @author isaac
     */
    private $startDate;
    /**
     * @var
     * @author isaac
     */
    private $endDate;

    /**
     * Mpesa constructor.
     */
    public function __construct()
    {
        self::baseUrl(self::BASE_ENDPOINT);
    }


    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        // convert amount from cents to shs
        $this->amount = $amount/100;
    }

    /**
     * @return mixed
     */
    public function getDefaultResponse()
    {
        return $this->default_response;
    }

    /**
     * @param mixed $default_response
     */
    public function setDefaultResponse($default_response): void
    {
        $this->default_response = $default_response;
    }

    /**
     * @return mixed
     */
    public function getValidateCallback()
    {
        return $this->validate_callback;
    }

    /**
     * @param mixed $validate_callback
     */
    public function setValidateCallback($validate_callback): void
    {
        $this->validate_callback = $validate_callback;
    }

    /**
     * @return mixed
     */
    public function getConfirmCallback()
    {
        return $this->confirm_callback;
    }

    /**
     * @param mixed $confirm_callback
     */
    public function setConfirmCallback($confirm_callback): void
    {
        $this->confirm_callback = $confirm_callback;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return mixed
     */
    public function getStkCallbackUrl()
    {
        return $this->stk_callback_url;
    }

    /**
     * @param mixed $stk_callback_url
     */
    public function setStkCallbackUrl($stk_callback_url): void
    {
        $this->stk_callback_url = $stk_callback_url;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     *
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     * @throws Exception
     * @author isaac
     */
    public function push()
    {
        $token = json_decode(self::authenticate())->access_token;
        $account = Vault::get('paybills', $this->account)->data->data;
        $headers = [
            "Content-Type" => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        $timestamp = Carbon::now()->format('Ymdhis');
        $password = self::generatePassword($account->shortcode, $account->passkey, $timestamp);
        $callback = $this->stk_callback_url;

        $post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $account->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $this->amount,
            'PartyA' => $this->phone_number,
            'PartyB' => $account->shortcode,
            'PhoneNumber' => '254'.(int) $this->phone_number,
            'CallBackURL' => $callback,
            'AccountReference' => $this->reference,
            'TransactionDesc' => $this->description
        );

        return dd(self::withHeaders($headers)->withoutVerifying()->post(self::SANDBOX_BASE_ENDPOINT . self::STK, $post_data)->json());
    }

    /**
     *
     * @return string
     * @throws Exception
     * @author isaac
     */
    private function authenticate(): string
    {
        $credentials = Vault::get('paybills', $this->account);
        if ($credentials) {
            $credentials = $credentials->data->data;
        }
        try {
            $secret = base64_encode($credentials->consumer_key . ':' . $credentials->consumer_secret);
            $headers = [
                'Authorization' => 'Basic ' . $secret
            ];
            return self::withHeaders($headers)->withoutVerifying()->get(self::SANDBOX_BASE_ENDPOINT.self::AUTH)->body();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $shortcode
     * @param $passkey
     * @param $timestamp
     *
     * @return string
     * @author isaac
     */
    private function generatePassword($shortcode, $passkey, $timestamp): string
    {
        return base64_encode($shortcode . $passkey . $timestamp);
    }

    /**
     *
     * @author isaac
     */
    public function b2c()
    {
        try {
            $token = json_decode($this->authenticate())->access_token;
            $account = Vault::get('paybills', $this->account)->data->data;

            $headers = [
                "Content-Type" => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];

            $security_credential = null;
            if (isset($account->security_credential) && $account->security_credential !== "") {
                $security_credential = $account->security_credential;
            } else {
                $security_credential = self::encrypt($account->initiator, 'mpesa_test');
            }

            $post_data = array(
                //Fill in the request parameters with valid values
                'InitiatorName' => $account->initiator,
                'SecurityCredential' => $security_credential,
                'CommandID' => $account->command_id,
                'Amount' => $this->amount,
                'PartyA' => $account->paybill,
                'PartyB' => $this->phone_number,
                'Remarks' => $this->remarks,
                'QueueTimeOutURL' =>$this->b2c_queue_timeout_url,
                'ResultURL' => $this->b2c_result_url,
                'Occasion' => $this->occasion
            );


            return self::withoutVerifying()->withHeaders($headers)->post(self::B2C_INITIATE,$post_data);
        } catch (Exception $e) {
        }
    }

    /**
     * @param string $unencrypted
     * @param        $certificatePath
     * @param int    $padding
     * @param string $driver
     *
     * @return string
     * @throws Exception
     * @author isaac
     */
    private function encrypt(string $unencrypted, $certificatePath, $padding = OPENSSL_PKCS1_PADDING, $driver = 'vault'): string
    {
        $encrypted = false;
        if ($driver == 'vault') {
            $key = Vault::get('certificates', $certificatePath)->data->data->cert;
            openssl_public_encrypt($unencrypted, $encrypted, $key, $padding);
            return base64_encode($encrypted);
        }
    }

    /**
     * @author isaac
     */
    public function B2B()
    {

    }

    /**
     *
     * @return mixed
     * @throws Exception
     * @author isaac
     */
    public function validateSTK()
    {
        $token = json_decode($this->authenticate())->access_token;
        $account = Vault::get('paybills', $this->account)->data->data;
        $headers = [
            "Content-Type" => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        $timestamp = Carbon::now()->format('Ymdhis');
        $password = self::generatePassword($account->shortcode, $account->passkey, $timestamp);

        $post_data = array(
            //Fill in the request parameters with valid values
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $this->checkoutRequestId,
            'BusinessShortCode' => $account->shortcode
        );

        return self::withoutVerifying()->withHeaders($headers)->post(self::STK_STATUS, $post_data);
    }

    /**
     *
     * @return mixed
     * @throws Exception
     * @author isaac
     */
    public function register()
    {
        $token = json_decode($this->authenticate())->access_token;
        $account = Vault::get('paybills', $this->account)->data->data;
        $headers = [
            "Content-Type" => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $post_data = array(
            "ConfirmationURL" => $this->confirm_callback,
            "ValidationURL" => $this->validate_callback,
            'ResponseType' => $this->default_response,
            'ShortCode' => $account->short_code
        );

        return self::withHeaders($headers)->withoutVerifying()->post(self::REGISTER_C2B_CALLBACKS, $post_data);
    }

    /**
     *
     * @author isaac
     */
    public function pullTransactions()
    {
        // TODO Verify and validate with production urls/ paybill
        try {
            $startDate=$this->startDate;
            $endDate=$this->endDate;
            if ($startDate == null) {
                $startDate = Carbon::now()->startOfDay();
            }
            if ($endDate == null) {
                $startDate = Carbon::now()->endOfDay();
            }
            $token = json_decode($this->authenticate())->access_token;

            $account = Vault::get('paybills', $this->account)->data->data;

            $headers = [
                "Content-Type" => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];
            $payload = [
                'ShortCode' => $account->shortcode,
                'StartDate' => $startDate,
                'EndDate' => $endDate,
                'OffSetValue' => '0'
            ];
            return self::withoutVerifying()->withHeaders($headers)->post(self::PULL_TRANSACTIONS, $payload);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *
     * @throws Exception
     * @author isaac
     */
    public function registerPullRequest()
    {
        // TODO Verify and validate with production urls/ paybill
        try {
            $token = json_decode($this->authenticate())->access_token;

            $account = Vault::get('paybills', $this->account)->data->data;
            $headers = [
                "Content-Type" => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];
            $payload = [
                'ShortCode' => $account->shortcode,
                'RequestType' => 'Pull',
                'NominatedNumber' => $account->nominated,
                'CallBackURL' => env('APP_URL') . '/api/payments/pulltransactions'
            ];
            return self::withoutVerifying()->withHeaders($headers)->post(self::PULL_TRANSACTIONS_REGISTER, $payload);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
