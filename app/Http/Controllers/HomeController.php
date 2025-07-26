<?

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Trả về view chính (ví dụ home.blade.php), có include header trong đó
        return view('home');
    }
}
