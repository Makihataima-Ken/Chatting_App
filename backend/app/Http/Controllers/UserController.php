<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{   
    /**
     * gets users except yourself
     */
    public function index(){
        $user=User::where('id','=!'.auth()->user()->id->get());
        return $this->success($user);
    }
}
