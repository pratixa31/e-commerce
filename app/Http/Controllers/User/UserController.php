<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Orders;

class UserController extends Controller
{   
    public function index()
    {
        return view('dashboard');
    }

    public function getProducts(Request $request)
    {   
        $perPage = 10;
        $productCategories = ProductCategory::all();

        $category = $request->input('category');
        $tag = trim($request->input('tag'));
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');

        $query = Product::query();

        // Apply filters
        if ($category) {
            $query->where('product_category_id', $category);
        }

         if (!empty($minPrice) && !empty($maxPrice)) {
            // Filter by price range
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        if(!empty($tag)) {
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag_name', 'like', '%' . $tag . '%');
            });
        }

        $products = $query->paginate($perPage);
        
        if ($request->ajax()) {
            return response()->json($products);
        }

        $cart = session()->get('cart');
        
        if ($cart == null){
            $cart = [];
        }

        return view('products.index',compact('perPage','products','productCategories'))->with('cart', $cart);
    }

    public function getOrders(Request $request)
    {
        $orders = Orders::where('user_id',auth()->user()->id)->get();

        return view('orders.index',compact('orders'));   
    }


    public function addToCart(Request $request)
    {   
        if($request->quantity && $request->productId) {
        
        $product = Product::find($productId);

        session()->put('cart', $request->post('cart'));

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
        ]);

        return redirect()->back()->with('success', 'Product added to cart.');
        }
    }
}
