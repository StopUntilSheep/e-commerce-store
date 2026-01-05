<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseController
{
    public function index()
    {
        return $this->renderWithLayoutData('Cart', [], [
            'with_categories' => true,
            'with_brands' => false,
            'with_featured' => false,
            'with_new_arrivals' => false,
        ]);
    }

    public function add(AddToCartRequest $request, Product $product, ProductVariant $productVariant)
    {
        $cartItem = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'session_id' => session()->id(),
            'product_id' => $product->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1,
            'price_snapshot' => $product->price,
            'expires_at' => Carbon::now()->addDays(90),
        ]);

        $cartItem->save();
        
        return back()->with('success', 'Item added to cart!');
    }
}
