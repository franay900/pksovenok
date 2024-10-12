<?php

namespace App\Http\Controllers;

use App\Services\Period\Service;
use App\Http\Controllers\Controller;



class BaseController extends Controller {

    public $service;
    
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}