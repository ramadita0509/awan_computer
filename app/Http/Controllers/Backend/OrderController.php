<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('backend.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])
            ->findOrFail($id);

        return view('backend.order-detail', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'tracking_number' => 'required_if:status,shipped|nullable|string|max:100',
            'courier_name' => 'required_if:status,shipped|nullable|string|max:100',
            'shipped_date' => 'nullable|date',
        ]);

        $order = Order::findOrFail($id);

        $updateData = [
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ];

        // If status is shipped, require tracking number and courier name
        if ($request->status === 'shipped') {
            if (!$request->tracking_number || !$request->courier_name) {
                return redirect()->back()->withErrors([
                    'tracking_number' => 'No. Resi dan Nama Jasa Pengiriman wajib diisi saat status Shipped.',
                ]);
            }
            $updateData['tracking_number'] = $request->tracking_number;
            $updateData['courier_name'] = $request->courier_name;
            $updateData['shipped_date'] = $request->shipped_date ?? now();
        }

        $order->update($updateData);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
