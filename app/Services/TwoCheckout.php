<?php

namespace App\Services;

class TwoCheckout{


    public static array $signParams = [
        'return-url',
        'return-type',
        'expiration',
        'order-ext-ref',
        'customer-ref',
        'customer-ext-ref',
        'currency',
        'prod',
        'price',
        'qty',
        'tangible',
        'type',
        'opt',
        'description',
        'recurrence',
        'duration',
        'renewal-price',
        'item-ext-ref'
    ];

    protected $config = [];

    public function __construct($config){

        $this->config = $config;
    }


    public function sign($params){

        $params = \Arr::only($params, static::$signParams);

        $key = $this->config['buy_link_secrect_word'];

        ksort($params);
        $serializedString = '';

        foreach ($params as $value) {
            $serializedString .= strlen($value) . $value;
        }

        return bin2hex(hash_hmac('sha256', $serializedString, $key, true));
    }
}