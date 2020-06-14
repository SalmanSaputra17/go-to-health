<?php

namespace App\Http\Controllers\Api;

use App\Services\Logger;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\LogRequest;
use App\Http\Controllers\Controller;

class WebhookController extends Controller
{
    public function createLog(LogRequest $request)
    {
    	Logger::write([
    		'user_id' => $request->user_id,
    		'activity' => $request->activity,
    		'type' => $request->type,
    		'ip' => $request->ip,
    	]);
    }
}
