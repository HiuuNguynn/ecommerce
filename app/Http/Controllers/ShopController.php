<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        return view('shop',compact('products'));
    }

    public function product_details($product_slg)
    {
        $product = Product::where('slug', $product_slg)->first();
        $rproducts = Product::where('slug', '<>',$product_slg)->get()->take(8);
        return view('details',compact('product','rproducts'));
    }
}
