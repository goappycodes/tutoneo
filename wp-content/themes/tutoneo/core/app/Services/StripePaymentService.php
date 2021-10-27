<?php

namespace App\Services;

use App\Config\Config;

class StripePaymentService
{
    private $stripe;
    private $_p_key;
    private $_s_key;

    private $address_line1;
    private $address_line2;
    private $city;
    private $country;
    private $postal_code;
    private $state;
    private $customer_description;
    private $email;
    private $name;
    private $phone;
    private $success_url;
    private $cancel_url;
    private $currency;
    private $amount;
    private $line_item_name;

    private $customer;
    private $session;

    public function __construct()
    {
        if (Config::PAYMENT_MODE == 'live') {
            $this->_p_key = Config::STRIPE_LIVE_PUBLISH_KEY;
            $this->_s_key = Config::STRIPE_LIVE_SECRET_KEY;
        } else {
            $this->_p_key = Config::STRIPE_TEST_PUBLISH_KEY;
            $this->_s_key = Config::STRIPE_TEST_SECRET_KEY;
        }

        $this->stripe = new \Stripe\StripeClient($this->_s_key);
    }

    public function get_publishable_key()
    {
        return $this->_p_key;
    }

    public function set_address_line1($value)
    {
        $this->address_line1 = $value;
    }

    public function set_address_line2($value)
    {
        $this->address_line2 = $value;
    }

    public function set_city($value)
    {
        $this->city = $value;
    }

    public function set_country($value)
    {
        $this->country = $value;
    }

    public function set_postal_code($value)
    {
        $this->postal_code = $value;
    }

    public function set_state($value)
    {
        $this->state = $value;
    }

    public function set_customer_description($value)
    {
        $this->customer_description = $value;
    }

    public function set_email($value)
    {
        $this->email = $value;
    }

    public function set_name($value)
    {
        $this->name = $value;
    }

    public function set_phone($value)
    {
        $this->phone = $value;
    }

    public function create_customer()
    {
        $this->customer = $this->stripe->customers->create([
            'address' => [
                'line1'       => $this->address_line1,
                'city'        => $this->city,
                'country'     => $this->country,
                'line2'       => $this->address_line2,
                'postal_code' => $this->postal_code,
                'state'       => $this->state,
            ],
            'description'     => $this->customer_description,
            'email'           => $this->email,
            'name'            => $this->name,
            'phone'           => $this->phone,
        ]);

        return $this->customer;
    }

    public function set_customer($customer_id)
    {
        $this->customer = $this->stripe->customers->retrieve($customer_id, []);
    }

    public function get_customer()
    {
        return $this->customer;
    }

    public function set_success_url($value)
    {
        $this->success_url = $value;
    }

    public function set_cancel_url($value)
    {
        $this->cancel_url = $value;
    }

    public function set_currencey($value)
    {
        $this->currency = $value;
    }

    public function set_amount($amount)
    {
        $this->amount = round($amount, 2) * 100;
    }

    public function set_line_item_name($value)
    {
        $this->line_item_name = $value;
    }

    public function create_session()
    {
        $this->session = $this->stripe->checkout->sessions->create([
            'customer' => $this->get_customer(),
            'success_url' => $this->success_url,
            'cancel_url' => $this->cancel_url,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $this->currency,
                        'product_data' => [
                            'name' => $this->line_item_name,
                        ],
                        'unit_amount' => $this->amount,
                    ],
                    'quantity' => 1,
                ]
            ],
        ]);

        return $this->session;
    }

    public function set_session($session_id)
    {
        $this->session = $this->stripe->checkout->sessions->retrieve(
            $session_id,
            []
        );
    }

    public function get_session()
    {
        return $this->session;
    }

    public function create_refund($payment_intent_id, $amount)
    {
        return $this->stripe->refunds->create([
            'payment_intent' => $payment_intent_id,
            'amount' => $amount,
            'reason' => 'requested_by_customer'
        ]);
    }
}
