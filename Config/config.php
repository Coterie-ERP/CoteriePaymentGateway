<?php

return [
    /**
     * Represent all transaction amounts in cents
     */
    'convert_to_cents'=>true,

    'environment'=>'sandbox',

    /**
     * *************************************************************
     *  Credential storage engine
     *
     *  The engine that will be used to store the credentials for the
     *  payment providers for the different users.
     *
     * *************************************************************
     *
     * Available Storage Engines include :
     *      Vault : Encrypted storage engine hosted in a different server accessible only via a private network (Provided by Hashicorp)
     *      Database (Coming Soon)
     *      File (Coming Soon)
     */
    'credential_storage'=>'vault',

    'cache_token'=>true,

    'default_currency'=>'KES',

    'archive_transactions'=>true,

    'archive_frequency'=> 365,

    'archive_period'=>'days',

    'retrieve_transactions'=>true,

    'retrieve_transaction_frequency'=>24,

    'endpoints'=>[
        'mpesa'=>[
            'environment'=>'sandbox',
            'base_endpoints'=>[
                'sandbox'=>'https://sandbox.safaricom.co.ke',
                'production'=>'https://api.safaricom.co.ke'
            ],
            'authentication'=>'/oauth/v1/generate?grant_type=client_credentials',
            'register_callback'=>'/mpesa/c2b/v1/registerurl',
            'stk'=>[
                'initiate'=>'/mpesa/stkpush/v1/processrequest',
                'query_status'=>'/mpesa/stkpushquery/v1/query'
            ],
            'transaction_status'=>'/mpesa/transactionstatus/v1/query',
            'pull_transactions'=>[
                'register_url'=>'/pulltransactions/v1/register',
                'query_transactions'=>'/pulltransactions/v1/query'
            ],
            'b2c_initiate'=>'/mpesa/b2c/v1/paymentrequest',
            'b2b_initiate'=>'/mpesa/b2b/v1/paymentrequest',
            'account_balance'=>'/mpesa/accountbalance/v1/query',
            'reversal'=>'/mpesa/reversal/v1/request',
        ],

        'tkash'=>[

        ],

        'equitel'=>[],

        'airtel'=>[]
    ],

    'drivers'=>[
        'vault'=>[],

        'cache'=>[],

        'database'=>[]
    ]
];
