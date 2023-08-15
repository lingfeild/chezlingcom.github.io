<?php

function randomize_pw()
{
    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        . '0123456789');
    shuffle($seed);
    $password = '';
    foreach (array_rand($seed, 8) as $k) {
        $password .= $seed[$k];
    }

    return $password;
}

function validate_user_data($user_data, $user_key, $honeypot, $files, $is_new_user)
{
    $key = create_nonce(300, "");

    if (trim($key) != trim($user_key)) {
        return false;
    }
    foreach ($user_data as $data) {
        if ($data === "") {
            return false;
        }
    }
    if ($honeypot != "") {
        return false;
    }
    if (!verify_files_not_empty($user_data, $files, $is_new_user)) {
        return false;
    }
    if (!verify_file_extensions($files)) {
        return false;
    }

    return true;
}

function assemble_user_data($nat_user_handler, $user_data)
{
    $firstname    = trim($user_data['firstname']);
    $lastname     = trim($user_data['lastname']);
    $mobile_phone = trim($user_data['mobile_phone']);
    $address      = trim($user_data['address']);
    $city         = trim($user_data['city']);
    $postal_code  = trim($user_data['postal_code']);
    $country      = trim($user_data['country']);
    $is_vip       = $user_data['is_vip'];
    $is_active    = $user_data['active'];

    switch ($country) {
        case 'AU':
            $state = trim($user_data['state_AUS']);
            break;
        case 'BR':
            $state = trim($user_data['state_row']);
            break;
        case 'CA':
            $state = trim($user_data['state_CAN']);
            break;
        case 'CN':
            $state = trim($user_data['state_row']);
            break;
        case 'JP':
            $state = trim($user_data['state_row']);
            break;
        case 'MX':
            $state = trim($user_data['state_row']);
            break;
        case 'US':
            $state = trim($user_data['state_US']);
            break;
    }

    $user_email  = trim($user_data['email']);
    $tier_choice = trim($user_data['tier_choice']);

    $user_id = $nat_user_handler->create_username($firstname, $lastname, $tier_choice);

    if (isset($user_data['passwordd'])) {
        $password = trim($user_data['passwordd']);
    } else {
        $password = randomize_pw();
    }

    $user_data_array = array(
        'user_id'     => $user_id,
        'password'    => $password,
        'fname'       => $firstname,
        'lname'       => $lastname,
        'phone'       => $mobile_phone,
        'email'       => $user_email,
        'street'      => $address,
        'city'        => $city,
        'postal_code' => $postal_code,
        'state'       => $state,
        'country'     => $country,
        'tier_choice' => $tier_choice,
        'is_vip'      => $is_vip,
        'active'      => $is_active,
    );

    return $user_data_array;
};
