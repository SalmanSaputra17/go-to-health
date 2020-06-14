<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\FoodRepositoryInterface;

class FoodController extends Controller
{
	private $repository;

    public function __construct(FoodRepositoryInterface $repository)
    {
    	$this->repository = $repository;
    }

    public function index()
    {
    	try {
    		$result = $this->repository->all();

    		return response()->json([
	    		'status' => 'SUCCESS',
	    		'data' => $result
	    	], 200);
    	} catch(\Exception $e) {
    		return response()->json([
	    		'status' => 'FAILED',
	    		'message' => $e->getMessage(), 
	    	], 500);
    	}
    }
}
