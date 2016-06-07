<?php

/**
 * Created by PhpStorm.
 * User: guillaumevandecasteele
 * Date: 07/06/16
 * Time: 07:59
 */
class PaymentEngine
{
    private $paymentOptions = array("Bancontact" => 0, "VISA"  => 1, "Mastercard" => 2, "American Express" => 3, "PayPal" => 4);
    
    public function getPaymentOptions() {
        return $this->paymentOptions;
    }
    
    public function executePayment($paymentOption, $amount) {
        if (!isset($this->paymentOptions[$paymentOption])) {
            return false;
        }
        elseif ($amount <= 0) {
            return false;
        }
        else {
            //TODO - Insert payment functionality here
            return true;
        }
    }
}