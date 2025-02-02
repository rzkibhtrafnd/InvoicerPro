<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems.product'])->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;
        foreach ($request->products as $product) {
            $productData = Product::find($product['product_id']);
            $totalPrice += $productData->harga * $product['quantity'];
        }

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_price' => $totalPrice,
        ]);

        foreach ($request->products as $product) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => Product::find($product['product_id'])->harga,
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['orderItems.product'])->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $totalPrice = 0;

        // Update order details
        $order->customer_id = $request->customer_id;
        $order->save();

        // Delete old order items
        $order->orderItems()->delete();

        // Add updated order items
        foreach ($request->products as $product) {
            $productData = Product::find($product['product_id']);
            $totalPrice += $productData->harga * $product['quantity'];

            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $productData->harga,
            ]);
        }

        // Update total price
        $order->total_price = $totalPrice;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
