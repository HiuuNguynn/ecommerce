<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $oder = $request->query('order') ? $request->query('order') : -1;
        $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        return view('shop',compact('products', 'size'));
    }

    public function product_details($product_slg)
    {
        $product = Product::where('slug', $product_slg)->first();
        $rproducts = Product::where('slug', '<>',$product_slg)->get()->take(8);
        return view('details',compact('product','rproducts'));
    }
}
