<?php

/**
 * hash_equals — Timing attack safe string comparison
 * Only present in PHP >= 5.6.0
 */
if (!function_exists('hash_equals')) {
    function hash_equals($a, $b)
    {
        $ret = strlen($a) ^ strlen($b);
        $ret |= array_sum(unpack("C*", $a ^ $b));
        return !$ret;
    }
}

/**
 * @param $data
 * @return string
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
