<?php

class LekirpayWooCommerceAPI
{
    private $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function setConnect($connect)
    {
        $this->connect = $connect;
    }

    public function getToken($tokenParameter){
        return $this->connect->getToken($tokenParameter);
    }
	
	public function sentPaymentSecure($token, $lekirSignature, $paymentParameter){
        return $this->connect->sentPaymentSecure($token, $lekirSignature, $paymentParameter);
    }

    public function sentPayment($token, $paymentParameter){
        return $this->connect->sentPayment($token, $paymentParameter);
    }

    public function getPaymentStatus($token, $payment_id){
        return $this->connect->getPaymentStatus($token, $payment_id);
    }
}
