<?php

namespace App\Http\Controllers\SiteUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{    
    public function getUserOrder(Request $request)
    {
        $user = $request->user();

        // Mengambil pesanan milik pengguna saat ini
        $orders = Order::with(['orderItems.product', 'address'])
            ->where('site_user_id', $user->id)
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders, 200);
    }

    public function showUserOrder(Request $request, $id)
    {
        $user = $request->user();

        // Mengambil pesanan dengan relasi, milik pengguna saat ini
        $order = Order::with(['orderItems.product', 'address', 'shipment'])
            ->where('id', $id)
            ->where('site_user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        return response()->json($order, 200);
    }
}
