<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $pendingCount = Order::where('status', 'Pending')->count();
        $paidCount = Order::where('status', 'Paid')->count();
        $totalOrders = Order::count();

        $orders = Order::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.orders.index', compact('orders', 'pendingCount', 'paidCount', 'totalOrders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Jika status yang dipilih adalah Canceled
        if ($request->status === 'Canceled') {
            $request->validate([
                'cancel_reason' => 'required|string',
                'cancel_proof'  => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            ], [
                'cancel_reason.required' => 'Alasan pembatalan wajib diisi!',
                'cancel_proof.mimes'      => 'Format bukti file harus berupa JPG, PNG, WEBP, atau PDF.',
                'cancel_proof.max'        => 'Ukuran file maksimal adalah 5 MB.',
            ]);

            $data = [
                'status'        => 'Canceled',
                'cancel_reason' => $request->cancel_reason,
            ];

            // Proses Simpan File Bukti
            if ($request->hasFile('cancel_proof')) {
                // Hapus bukti lama dari storage jika ada
                if ($order->cancel_proof && Storage::disk('public')->exists($order->cancel_proof)) {
                    Storage::disk('public')->delete($order->cancel_proof);
                }
                
                $path = $request->file('cancel_proof')->store('cancel_proofs', 'public');
                $data['cancel_proof'] = $path;
            }

            $order->update($data);

            return back()->with('success', 'Bukti foto & alasan pembatalan berhasil disimpan!');
        }

        // Untuk status selain Canceled
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}