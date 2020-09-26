<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @var string
     */
    protected $view;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->view = "";
    }

    /**
     * @param       $view
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderView($view, $data = [])
    {
        return view($this->view . $view, $data);
    }
}
