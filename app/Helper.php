<?php

use Illuminate\Support\Facades\Crypt;

function reformatDateToReadable($date)
{
	return date('d M Y H:i:s', strtotime($date));
}

function encryptStringValue($value)
{
	return Crypt::encryptString($value);
}

function decryptStringValue($value)
{
	return Crypt::decryptString($value);
}