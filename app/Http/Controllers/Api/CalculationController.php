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
    /**
     * @var \App\Services\IBM
     */
    private $IBMService;

    /**
     * @var \App\Services\DayCalory
     */
    private $dayCaloryService;

    /**
     * @var \App\Services\FoodCalory
     */
    private $foodCaloryService;

    /**
     * CalculationController constructor.
     *
     * @param \App\Services\IBM        $IBM
     * @param \App\Services\DayCalory  $dayCalory
     * @param \App\Services\FoodCalory $foodCalory
     */
    public function __construct(IBM $IBM, DayCalory $dayCalory, FoodCalory $foodCalory)
    {
        $this->IBMService = $IBM;
        $this->dayCaloryService = $dayCalory;
        $this->foodCaloryService = $foodCalory;
    }

    /**
     * @param \App\Http\Requests\Api\IBMRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateIBM(IBMRequest $request)
    {
        try {
            $result = $this->IBMService->setHeight($request->height)->setWeight($request->weight)->calculate();

            return response()->json([
                'status' => 'SUCCESS',
                'result' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @param \App\Http\Requests\Api\DayCaloryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateDayCalory(DayCaloryRequest $request)
    {
        try {
            $result = $this->dayCaloryService->setHeight($request->height)->setWeight($request->weight)->setGender($request->gender)->setDateOfBirth($request->date_of_birth)->setActivityLevel($request->activity_level)->calculate();

            return response()->json([
                'status' => 'SUCCESS',
                'result' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @param \App\Http\Requests\Api\FoodCaloryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateFoodCalory(FoodCaloryRequest $request)
    {
        try {
            $result = $this->foodCaloryService->setFoods($request->foods)->calculate();

            return response()->json([
                'status' => 'SUCCESS',
                'result' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
