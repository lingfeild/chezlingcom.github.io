<?php

class NatPurchaseHandler extends PurchaseHandler
{
    private $__curl_request;
    protected $__nat_user_handler;
    private $__userid;
    public function __construct($userid)
    {
        $this->__userid = $userid;
    }

    /**************************************************************************************/

    public function set_nat_user_handler($nat_user_handler)
    {
        $this->__nat_user_handler = $nat_user_handler;
    }

    public function set_curl_request($curl_request)
    {
        $this->__curl_request = $curl_request;
    }

    public function set_userid($userid)
    {
        $this->__userid = $userid;
    }

    /**************************************************************************************/

    public function setup_purchase()
    {
        if (!$this->__nat_user_handler->is_valid($this->__userid)) {
            return false;
        }

        $user_data             = $this->__nat_user_handler->get_user_data($this->__userid);
        $user_data['order_id'] = $this->__initiate_order($user_data);

        return (json_encode($user_data));
    }

    private function __initiate_order($user_data)
    {
        $exchange_rate = $this->__get_exchange_rate();

        $margin = 1.3;
        if ($user_data['is_vip'] == true) {
            $margin = 1.1;
        }
        $exchange_rate = round($exchange_rate * $margin, 2);

        $essential_data = array(
            'essential_data' => array(
                'payout_exchange_rate'   => $exchange_rate,
                'payout_currency_code'   => PAYOUT_CURRENCY,
                'purchase_currency_code' => PURCHASE_CURRENCY,
                'userid'                 => $user_data['userid'],
                'firstname'              => $user_data['firstname'],
                'lastname'               => $user_data['lastname'],
                'mobile'                 => $user_data['mobile'],
                'street'                 => $user_data['address'],
                'email_address'          => $user_data['email_address'],
                'city'                   => $user_data['city'],
                'zip'                    => $user_data['postal_code'],
                'state'                  => $user_data['state'],
                'country'                => $user_data['country'],
                'playerid'               => $user_data['playerid'],
            ),
        );

        $order_id = $this->__create_order($essential_data);
        return $order_id;
    }

    private function __get_exchange_rate()
    {
        $curlOptions = array(
            CURLOPT_POST       => 1,
            CURLOPT_POSTFIELDS => "",
        );

        $this->__curl_request->initiateCurl("GetExchangeRate", SITE_URL . "/getexchangerate.php", $curlOptions);
        $responseArray = $this->__curl_request->executeCurl(false);
        $response      = $responseArray['curl_response'];

        $response = json_decode($response, true);

        return $response[PURCHASE_CURRENCY];
    }

    private function __create_order($essential_data)
    {
        $essential_data = http_build_query($essential_data);

        $curlOptions = array(
            CURLOPT_POST       => 1,
            CURLOPT_POSTFIELDS => $essential_data,
        );

        $this->__curl_request->initiateCurl("InitiateOrder", SITE_URL . "/controller/initiator.php", $curlOptions);
        $responseArray = $this->__curl_request->executeCurl(false);
        $response      = $responseArray['curl_response'];

        return $response;
    }

    /**************************************************************************************/
}
