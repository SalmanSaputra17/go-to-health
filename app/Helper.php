<?php

use Illuminate\Support\Facades\Crypt;

/**
 * @param $date
 * @return false|string
 */
function reformatDateToReadable($date)
{
    return date('d M Y H:i:s', strtotime($date));
}

/**
 * @param $value
 * @return string
 */
function encryptStringValue($value)
{
    return Crypt::encryptString($value);
}

/**
 * @param $value
 * @return string
 */
function decryptStringValue($value)
{
    return Crypt::decryptString($value);
}
