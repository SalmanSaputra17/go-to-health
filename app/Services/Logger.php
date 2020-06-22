<?php

namespace App\Services;

use App\Models\UserActivityLog;

class Logger
{
	public static function write($data = [])
	{
		UserActivityLog::create($data);
	}	
}