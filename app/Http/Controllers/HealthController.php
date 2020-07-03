<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function index(){
        $today = new \DateTime();
        return json_encode([$today->format('Y-m-d h:i:s')]);
    }
}
