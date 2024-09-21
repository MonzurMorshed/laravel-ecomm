<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $cacheKey = 'products_listing';

        $data = Cache::remember($cacheKey, 3600, function () {
           return Product::all(); 
        });

        return response()->json($data, 200, $headers);
    }
}
