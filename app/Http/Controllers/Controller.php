<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Helpers\JwtIssuer;
use App\Helpers\generateDefaultPassword;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Response, JwtIssuer, generateDefaultPassword;
}
