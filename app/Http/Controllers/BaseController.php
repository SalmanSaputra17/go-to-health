<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
	protected $view;

    public function __construct()
    {
    	$this->view = "";
    }

    public function renderView($view, $data = [])
    {
    	return view($this->view . $view, $data);
    }
}
