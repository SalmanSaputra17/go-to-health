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
    	\DB::beginTransaction();

    	try {
    		Logger::write([
	    		'user_id' => $request->user_id,
	    		'activity' => $request->activity,
	    		'type' => $request->type,
	    		'ip' => $request->ip,
	    	]);

	    	\DB::commit();

	    	return response()->json([
	    		'status' => 'SUCCESS',
	    		'message' => 'Success create user log.'
	    	], 201);
    	} catch(\Exception $e) {
    		\DB::rollback();

    		return response()->json([
	    		'status' => 'FAILED',
	    		'message' => $e->getMessage(),
	    	], 500);
    	}
    }
}
