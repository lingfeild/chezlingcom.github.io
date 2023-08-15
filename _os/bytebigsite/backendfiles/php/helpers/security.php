<?php
function encrypt_user_data($data, $key)
{
    if (isset($data['password'])) {
        $data['password'] = encrypt($data['password'], $key);
    }
    $data['fname']       = encrypt($data['fname'], $key);
    $data['lname']       = encrypt($data['lname'], $key);
    $data['phone']       = encrypt($data['phone'], $key);
    $data['email']       = encrypt($data['email'], $key);
    $data['street']      = encrypt($data['street'], $key);
    $data['city']        = encrypt($data['city'], $key);
    $data['postal_code'] = encrypt($data['postal_code'], $key);
    $data['state']       = encrypt($data['state'], $key);
    $data['country']     = encrypt($data['country'], $key);

    return $data;
}

function create_nonce($duration, $string)
{
    $secretkey = SECRET_KEY;
    $nonce     = ceil(time() / ($duration));
    $key       = md5($nonce . $string . $secretkey);
    $key       = substr($key, -12, 10);
    return $key;
}

function encrypt($string, $key)
{
    return openssl_encrypt($string, ENCRYPTION_METHOD, $key);
}

function decrypt($string, $key)
{
    return openssl_decrypt($string, ENCRYPTION_METHOD, $key);
}

function generate_ref_code($string)
{
    $code = encrypt($string, SECRET_KEY);
    $code = substr($code, -7, 6);
    return $code;
}
