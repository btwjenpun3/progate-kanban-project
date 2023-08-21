<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        $message= 'Ini adalah pengiriman data melalui method with, Selamat datang ke Laravel!';
        return view('welcome')->with('message', $message);
    }
}
