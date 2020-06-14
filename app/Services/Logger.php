<?php

namespace App\Services;

use App\Models\UserActivityLog;

class Logger
{
	public static function write($data = [])
	{
		UserActivityLog::create([
			'user_id' => $data['user_id'],
			'activity' => $data['activity'],
			'type' => $data['type'],
			'ip' => $data['ip'],
		]);
	}	
}