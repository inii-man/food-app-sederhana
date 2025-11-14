<?php

namespace App\Http\Controllers;

use App\Models\FoodMenu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Jika merchant/admin, tampilkan semua pesanan. Jika customer, hanya pesanan mereka
        if (Auth::user()->hasRole('merchant') || Auth::user()->hasRole('admin')) {
            $orders = Order::with(['orderItems.foodMenu', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $orders = Order::where('user_id', Auth::id())
                ->with(['orderItems.foodMenu', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $foodItems = FoodMenu::all(); // Ambil semua item menu
        return view('orders.menu', compact('foodItems'));
    }

    public function store(Request $request)
    {
        // Filter out items with quantity 0 or less
        $items = array_filter($request->items ?? [], function ($item) {
            return isset($item['quantity']) && $item['quantity'] > 0;
        });

        // Validasi inputan
        $request->merge(['items' => $items]);

        $request->validate([
            'address' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.food_menu_id' => 'required|exists:food_menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Anda harus memilih setidaknya satu item makanan.',
            'items.min' => 'Anda harus memilih setidaknya satu item makanan.',
            'address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        // Simpan pesanan
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $request->total_price,
            'status' => 'pending',
            'address' => $request->address
        ]);

        // Simpan item pesanan
        foreach ($items as $item) {
            $order->orderItems()->create([
                'food_menu_id' => $item['food_menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Redirect ke halaman detail pesanan
        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order)
    {
        // Merchant/admin bisa lihat semua pesanan, customer hanya pesanan mereka sendiri
        if (!Auth::user()->hasRole('merchant') && !Auth::user()->hasRole('admin')) {
            // Jika bukan merchant/admin, pastikan hanya user yang membuat pesanan yang bisa melihatnya
            if ($order->user_id != Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk melihat pesanan ini.');
            }
        }

        return view('orders.show', compact('order'));
    }

    // Merchant: View all orders
    public function merchantIndex()
    {
        // Ambil semua pesanan untuk merchant
        $orders = Order::with(['orderItems.foodMenu', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.merchant-index', compact('orders'));
    }

    // Merchant: Update order status
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
