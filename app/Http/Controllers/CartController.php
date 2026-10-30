<?php

namespace App\Http\Controllers;

use App\Contracts\IOrderService;
use App\Http\Requests\CheckoutRequest;
use App\Models\Marketplace\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly IOrderService $orderService,
    ) {}

    public function index()
    {
        $cart = session('nanhacare_cart', []);
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::with('images')->findOrFail($request->product_id);
        $cart = session('nanhacare_cart', []);

        $key = array_search($request->product_id, array_column($cart, 'product_id'));

        if ($key !== false) {
            $cart[$key]['qty'] += $request->qty;
        } else {
            $cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'qty' => $request->qty,
                'image' => $product->images->where('is_primary', true)->first()?->path ?? $product->images->first()?->path,
            ];
        }

        session(['nanhacare_cart' => $cart]);

        return back()->with('success', 'Added to cart');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);

        $cart = collect(session('nanhacare_cart', []))
            ->filter(fn ($i) => $i['product_id'] != $request->product_id)
            ->values()
            ->toArray();

        session(['nanhacare_cart' => $cart]);

        return back()->with('success', 'Item removed');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session('nanhacare_cart', []);

        foreach ($cart as &$item) {
            if ($item['product_id'] == $request->product_id) {
                $item['qty'] = $request->qty;
            }
        }

        session(['nanhacare_cart' => $cart]);

        return back();
    }

    public function checkout()
    {
        $cart = session('nanhacare_cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Your cart is empty');
        }

        $total = collect($cart)->sum(fn ($i) => $i['price'] * $i['qty']);

        return view('cart.checkout', compact('cart', 'total'));
    }

    public function placeOrder(CheckoutRequest $request)
    {
        $cart = session('nanhacare_cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Cart is empty');
        }

        $validated = $request->validated();

        $this->orderService->create([
            'items' => $cart,
            'shipping_address' => [
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'province' => $validated['province'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ],
            'payment_method' => $validated['payment_method'],
        ], auth()->id());

        session()->forget('nanhacare_cart');

        return redirect('/dashboard/parent/orders')->with('success', 'Order placed successfully!');
    }
}
