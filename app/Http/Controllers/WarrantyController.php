<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function index()
    {
        return view('warranty.index');
    }
} 