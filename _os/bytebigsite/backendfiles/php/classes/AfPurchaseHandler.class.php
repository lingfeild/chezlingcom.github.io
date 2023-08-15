<?php

class AfPurchaseHandler extends PurchaseHandler
{
    private $__af_user_handler;
    protected $__nat_user_handler;
    private $__curl_request;
    private $__post_data;
    public function __construct($post_data)
    {
        $this->__post_data = $post_data;
    }

    /**************************************************************************************/

    public function set_af_user_handler($af_user_handler)
    {
        $this->__af_user_handler = $af_user_handler;
    }

    public function set_nat_user_handler($nat_user_handler)
    {
        $this->__nat_user_handler = $nat_user_handler;
    }

    public function set_curl_request($curl_request)
    {
        $this->__curl_request = $curl_request;
    }

    public function set_post_data($post_data)
    {
        $this->__post_data = $post_data;
    }

    /**************************************************************************************/

    public function create_return_url()
    {
        $post_array = $this->__verify_post();
        if (isset($post_array['error'])) {
            return $post_array['error'];
        }

        if (!$this->__evaluate_create_user($post_array)) {
            return "Error Evaluating User";
        }

        $post_array['order_id'] = $this->__initiate_order($post_array);
        return $this->__create_return_url($post_array);
    }

    private function __verify_post()
    {
        $post = $this->__post_data;

        if (!isset($post['p'])) {
            $post_array['error'] = "Did Not Receive Post";
            return $post_array;
        }
        $post           = $post['p'];
        $decoded_post   = base64_decode($post);
        $decrypted_post = decrypt($decoded_post, OPERATOR_KEY);
        $post_array     = json_decode($decrypted_post, true);

        $keys = array(
            'btc_address',
            'btc_rate',
            'btc_rate_currency',
            'margin',
            'player_id',
            'fname',
            'lname',
            'street',
            'city',
            'postal_code',
            'state',
            'country',
            'email',
            'phone',
            'callback_url',
            'reference_id',
        );

        foreach ($keys as $key) {
            if (!isset($post_array[$key])) {
                $post_array['error'] = "Missing Parameters";
                return $post_array;
            }
        }
        return $post_array;
    }

    private function __evaluate_create_user($post_array)
    {
        if ($this->__af_user_handler->exists_user($post_array['player_id'])) {
            $post_array['visits'] = $this->__af_user_handler->get_visits($post_array['player_id']);
            return $this->__af_user_handler->update_user($post_array);
        } else {
            $post_array['tier_choice'] = 3;
            $post_array['is_vip']      = true;
            $post_array['password']    = randomize_pw();
            $post_array['user_id']     = $this->__nat_user_handler->create_username($post_array['fname'], $post_array['lname'], $post_array['tier_choice']);
            $post_array['active']      = true;
            if (!$this->__nat_user_handler->create_user($post_array)) {
                return false;
            }
            if (!$this->__af_user_handler->create_user($post_array)) {
                return false;
            }
            return true;
        }
    }

    private function __initiate_order($post_array)
    {
        $essential_data = array(
            'essential_data' => array(
                'payout_instrument_number' => $post_array['btc_address'],
                'purchase_fees'            => $post_array['margin'],
                'payout_exchange_rate'     => $post_array['btc_rate'],
                'callback_url'             => $post_array['callback_url'],
                'reference_id'             => $post_array['reference_id'],
                'payout_currency_code'     => PAYOUT_CURRENCY,
                'purchase_currency_code'   => $post_array['btc_rate_currency'],
                'firstname'                => $post_array['fname'],
                'lastname'                 => $post_array['lname'],
                'mobile'                   => $post_array['phone'],
                'street'                   => $post_array['street'],
                'email_address'            => $post_array['email'],
                'city'                     => $post_array['city'],
                'zip'                      => $post_array['postal_code'],
                'state'                    => $post_array['state'],
                'country'                  => $post_array['country'],
            ),
        );

        $order_id = $this->__create_order($essential_data);
        return $order_id;
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

    private function __create_return_url($post_array)
    {
        $key = create_nonce(900, $post_array['player_id']);

        $data_to_pass = array(
            'player_id'         => $post_array['player_id'],
            'btc_rate'          => $post_array['btc_rate'],
            'margin'            => $post_array['margin'],
            'btc_rate_currency' => $post_array['btc_rate_currency'],
            'key'               => $key,
            'order_id'          => $post_array['order_id'],
            'callback_url'      => $post_array['callback_url'],
            'reference_id'      => $post_array['reference_id'],
        );
        if (isset($post_array['bname'])) {
            $data_to_pass['bname'] = $post_array['bname'];
        }

        $data_to_pass = json_encode($data_to_pass);
        $data_to_pass = encrypt($data_to_pass, SECRET_KEY);
        $data_to_pass = base64_encode($data_to_pass);

        $return_url = SITE_URL . "/VIP.php?p=" . $data_to_pass;

        return $return_url;
    }

    /**************************************************************************************/

    /**************************************************************************************/

    public function setup_purchase()
    {
        $post      = $this->__post_data;
        $json_data = $this->__validate_post($post);

        if (isset($json_data['error'])) {
            return false;
        }

        $player_info = $this->__af_user_handler->get_user_data($json_data['player_id']);

        $nat_user_limits = $this->__nat_user_handler->get_user_data($player_info['userid']);
        $player_info = $this->__merge_nat_limit_data($player_info, $nat_user_limits);

        $player_info = $this->__get_passed_info($json_data, $player_info);
        $player_info['payout_currency_code'] = PAYOUT_CURRENCY;
        return (json_encode($player_info));
    }

    private function __validate_post($post)
    {
        if (!isset($post['p'])) {
            $json['error'] = "Post Error";
            return $json;
        } else {
            $post           = $post['p'];
            $post_decoded   = base64_decode($post);
            $post_decrypted = decrypt($post_decoded, SECRET_KEY);
            $json           = json_decode($post_decrypted, true);

            if (!$this->__validate_json($json)) {
                $json['error'] = "Json Error";
                return $json;
            }

            $key = create_nonce(900, $json['player_id']);
            if ($key != $json['key']) {
                $json['error'] = "Key Error";
                return $json;
            }
        }
        return $json;
    }

    private function __validate_json($json)
    {
        if (!isset($json['player_id']) || !isset($json['btc_rate']) || !isset($json['btc_rate_currency']) || !isset($json['key']) || !isset($json['order_id']) || !isset($json['margin']) || !isset($json['callback_url']) || !isset($json['reference_id'])) {
            return false;
        }
        return true;
    }

    private function __get_passed_info($json_data, $player_info)
    {
        $player_info['btc_rate']          = $json_data['btc_rate'];
        $player_info['order_id']          = $json_data['order_id'];
        $player_info['reference_id']      = $json_data['reference_id'];
        $player_info['margin']            = $json_data['margin'];
        $player_info['key']               = create_nonce(900, $player_info['playerid']);
        $player_info['btc_rate_currency'] = $json_data['btc_rate_currency'];

        if (isset($json_data['bname'])) {
            $player_info['bname'] = $json_data['bname'];
        } else {
            $player_info['bname'] = "";
        }

        return $player_info;
    }

    private function __merge_nat_limit_data($player_info, $nat_user_limits)
    {
        $player_info['remaining_daily_limit'] = $nat_user_limits['remaining_daily_limit'];
        $player_info['remaining_monthly_limit'] = $nat_user_limits['remaining_monthly_limit'];
        $player_info['transaction_limit'] = $nat_user_limits['transaction_limit'];
        $player_info['min_date'] = $nat_user_limits['min_date'];
        $player_info['tier'] = $nat_user_limits['tier'];

        return $player_info;
    }

    /**************************************************************************************/

    /**************************************************************************************/

    public function process_result()
    {
        $post          = $this->__post_data;
        $callback_data = $this->__handle_response($post['data'], $post['reference_id']);
        $this->__send_callback($callback_data, $post['callback_url']);
        $this->__send_signup_email($post['player_id']);
    }

    private function __handle_response($response_data, $reference_id)
    {
        if (sizeof($response_data) == 6) {
            $status_code    = "CC:" . $response_data[3] . " BTC:" . $response_data[0];
            $status_msg     = "CC:" . $response_data[4] . " BTC:" . $response_data[1];
            $transaction_id = "CC:" . $response_data[5] . " BTC:" . $response_data[2];
        } else {
            $status_code    = "CC:" . $response_data[0];
            $status_msg     = "CC:" . $response_data[1];
            $transaction_id = "CC:" . $response_data[2];
        }

        $callback_fields = array(
            'status_code'    => $status_code,
            'status_msg'     => $status_msg,
            'transaction_id' => $transaction_id,
            'reference_id'   => $reference_id,
        );

        return (json_encode($callback_fields));
    }

    private function __send_callback($callback_data, $callback_url)
    {
        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($callback_data),
        );

        $curlOptions = array(
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST       => 1,
            CURLOPT_POSTFIELDS => $callback_data,
        );
        $this->__curl_request->initiateCurl("SendCallback", $callback_url, $curlOptions);
        $this->__curl_request->executeCurl(false);
        return;
    }

    private function __send_signup_email($playerid)
    {
        $emailed_data = $this->__af_user_handler->get_emailed_data($playerid);
        if ($emailed_data['was_emailed'] == true) {
            return;
        }

        $nat_password = $this->__nat_user_handler->get_password($emailed_data['userid']);

        ob_start();
        include __DIR__ . "/../../../templates/new_user_af_email.php";
        // The template files hold HTML templates, with PHP variables (ex: $userid, $new_tier)
        // This pulls the file in and cleaning the Object Buffer treats it like a string.
        // See backend/change_tier.php for example
        $email_text = ob_get_clean();

        $subject = "Your " . SITE_NAME . " Login Information";
        send_email($emailed_data['user_email'], $subject, $email_text);

        $this->__af_user_handler->set_emailed($playerid);
        return;
    }

    /**************************************************************************************/

    /**************************************************************************************/

    public function create_cch_return_url($cch_url, $bcm_url)
    {
        if (!filter_var($cch_url, FILTER_VALIDATE_URL)) {
            return $bcm_url;
        }
        $return_url = encrypt($bcm_url, SECRET_KEY);
        $return_url = base64_encode($return_url);
        $return_url = $cch_url . '?cch=' . $return_url;
        return $return_url;
    }

}
