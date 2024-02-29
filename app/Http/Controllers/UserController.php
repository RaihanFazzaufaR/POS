<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index($id, $name){
        return view('user.user')
        ->with('id', $id)
        ->with('name', $name);
    }
}
