<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(){
        return view('product.category');
    }
    function foodBeverage(){

        return view('product.foodBeverage');
    }
    
    function beautyHealth(){

        return view('product.beautyHealth');
    }

    function homeCare(){

        return view('product.homeCare');
    }

    function babyKid(){

        return view('product.babyKid');
    }
}