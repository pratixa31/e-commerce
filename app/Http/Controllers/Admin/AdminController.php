<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;

class AdminController extends Controller
{   
    public function index(Request $request)
    {
        return view ('dashboard');
    }

    /**
     * Get chart on admin dashboard
     *
     * 
     */
    public function getChart(Request $request)
    {

    }
}
