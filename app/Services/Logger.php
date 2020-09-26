<?php

namespace App\Services;

use App\Models\UserActivityLog;

class Logger
{
    /**
     * @param array $data
     */
    public static function write($data = [])
    {
        UserActivityLog::create($data);
    }
}
