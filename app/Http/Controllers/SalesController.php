<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    function index(){
        return view('sales.sales');
    }
}
