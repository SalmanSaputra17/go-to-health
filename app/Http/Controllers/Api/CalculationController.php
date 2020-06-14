<?php

namespace App\Http\Controllers\Api;

use App\Services\IBM;
use App\Services\DayCalory;
use App\Services\FoodCalory;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\IBMRequest;
use App\Http\Requests\Api\DayCaloryRequest;
use App\Http\Requests\Api\FoodCaloryRequest;
use App\Http\Controllers\Controller;

class CalculationController extends Controller
{
	private $IBMService;
	private $dayCaloryService;
	private $foodCaloryService;

	public function __construct(IBM $IBM, DayCalory $dayCalory, FoodCalory $foodCalory)
	{
		$this->IBMService = $IBM;
		$this->dayCaloryService = $dayCalory;
		$this->foodCaloryService = $foodCalory;
	}

    public function calculateIBM(IBMRequest $request)
    {
    	try {
    		$result = $this->IBMService->setHeight($request->height)
    			->setWeight($request->weight)
    			->calculate();

    		return response()->json([
    			'status' => 'SUCCESS',
    			'result' => $result,
    		], 200);
    	} catch(\Exception $e) {
    		return response()->json([
    			'status' => 'FAILED',
    			'message' => $e->getMessage(),
    		], 500);
    	}
    }

    public function calculateDayCalory(DayCaloryRequest $request)
    {
    	try {
    		$result = $this->dayCaloryService->setHeight($request->height)
    			->setWeight($request->weight)
    			->setGender($request->gender)
    			->setDateOfBirth($request->date_of_birth)
    			->setActivityLevel($request->activity_level)
    			->calculate();

			return response()->json([
    			'status' => 'SUCCESS',
    			'result' => $result,
    		], 200);    		
    	} catch(\Exception $e) {
    		return response()->json([
    			'status' => 'FAILED',
    			'message' => $e->getMessage(),
    		], 500);
    	}
    }

    public function calculateFoodCalory(FoodCaloryRequest $request)
    {
    	try {
    		$result = $this->foodCaloryService->setFoods($request->foods)->calculate();

    		return response()->json([
    			'status' => 'SUCCESS',
    			'result' => $result,
    		], 200);
    	} catch(\Exception $e) {
    		return response()->json([
    			'status' => 'FAILED',
    			'message' => $e->getMessage(),
    		], 500);
    	}
    }
}
