<?php


namespace Modules\CoteriePaymentGateway\Billing;


use Modules\CoteriePaymentGateway\Mpesa\Mpesa;

class PaymentGateway
{

    private $provider;
    private $currency='KES';
    private const MPESA='MPESA';
    private const TKASH='TKASH';
    private const EQUITEL='EQUITEL';
    private const AIRTEL='AIRTEL';
    private $charge;
    private $charge_account;
    private $reference;
    private $merchant_account;
    private $description;
    private $company_id;

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
    public function getMerchantAccount()
    {
        return $this->merchant_account;
    }

    /**
     * @param mixed $merchant_account
     */
    public function setMerchantAccount($merchant_account): void
    {
        $this->merchant_account = $merchant_account;
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
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     */
    public function setProvider($provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * @param mixed $charge
     */
    public function setCharge($charge): void
    {
        $this->charge = $charge;
    }

    /**
     * @return mixed
     */
    public function getChargeAccount()
    {
        return $this->charge_account;
    }

    /**
     * @param mixed $charge_account
     */
    public function setChargeAccount($charge_account): void
    {
        $this->charge_account = $charge_account;
    }

    /**
     * @param int $amount : in cents
     *
     *
     * @author isaac
     */
    public function charge(int $amount)
    {
        $this->charge=$amount;
    }

    public function process()
    {
        $transaction=new Transaction();
        if($this->provider==self::MPESA){
            try {
                $mpesa=new Mpesa();
                $mpesa->setStkCallbackUrl(env('STK_CALLBACK_URL'));
                $mpesa->setAmount($this->charge*100);
                $mpesa->setPhoneNumber($this->charge_account);
                $mpesa->setReference($transaction->generate($this->reference,$this->company_id));
                $mpesa->setDescription($this->description);
                $mpesa->setAccount($this->merchant_account);
                return $mpesa->push();
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    public function mpesa()
    {
        $this->provider=self::MPESA;
    }

    public function tkash()
    {
        $this->provider=self::TKASH;
    }

    public function equitel()
    {
        $this->provider=self::EQUITEL;
    }

    public function airtel()
    {
        $this->provider=self::AIRTEL;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id): void
    {
        $this->company_id = $company_id;
    }
}