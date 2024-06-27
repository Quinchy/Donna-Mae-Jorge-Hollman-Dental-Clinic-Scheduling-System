<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function about()
    {
        return view('user.about');
    }

    public function service()
    {
        return view('user.service');
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function login()
    {
        return view('user.login');
    }
}
