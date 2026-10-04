<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function storeOrder(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nickname'     => 'required|string',
            'no_hp'        => 'required|string',
            'rank_awal'    => 'required|string',
            'star_awal'    => 'required',
            'rank_tujuan'  => 'required|string',
            'star_tujuan'  => 'required',
        ]);

        // 2. Buat ID Order Unik (Contoh: MC-9X1B2A)
        $orderId = 'MC-' . strtoupper(Str::random(6));

        // Format Teks Satuan
        $unitAwal = str_contains($request->rank_awal, 'Mythic') ? 'Point' : 'Bintang';
        $unitTujuan = str_contains($request->rank_tujuan, 'Mythic') ? 'Point' : 'Bintang';

        $serviceType = $request->input('service_type', 'Joki Game');
        $reqHero = $request->input('request_hero') ?: '-';
        $catatan = $request->input('catatan') ?: '-';
        $price = (float) $request->input('price', 0);

        // Format Rincian Pesanan
        $orderDetails = "Rank: {$request->rank_awal} ({$request->star_awal} {$unitAwal}) -> {$request->rank_tujuan} ({$request->star_tujuan} {$unitTujuan}) | Req Hero: {$reqHero} | Catatan: {$catatan}";

        // 3. Simpan Pesanan ke Database (Otomatis Tampil di Admin Panel)
        $order = Order::create([
            'order_id'      => $orderId,
            'customer_name' => "{$request->nickname} ({$request->no_hp})",
            'service_type'  => $serviceType,
            'order_details' => $orderDetails,
            'price'         => $price,
            'profit'        => 0,
            'status'        => 'Pending',
        ]);

        // 4. Susun Pesan WhatsApp Format Rapi
        $adminWa = '6285718447963';

        $waText = implode("\n", [
            "FORM ORDER {$order->service_type} - MANCHISTORE",
            "----------------------------------------",
            "Data Customer",
            "• Kode Order: {$order->order_id}",
            "• Username MLBB: {$request->nickname}",
            "• No. WA: {$request->no_hp}",
            "",
            "Target Order",
            "• Rank Awal: {$request->rank_awal} ({$request->star_awal} {$unitAwal})",
            "• Rank Tujuan: {$request->rank_tujuan} ({$request->star_tujuan} {$unitTujuan})",
            "",
            "Request & Catatan",
            "• Req Hero: {$reqHero}",
            "• Catatan: {$catatan}",
            "",
            "Total Biaya: Rp " . number_format($price, 0, ',', '.'),
            "----------------------------------------",
            "Hallo ManChi, ini detail orderan saya tolong diproses ya."
        ]);

        // Clean hidden unicode chars & encode URL
        $waTextClean = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}\x{00A0}]/u', ' ', $waText);
        $waUrl = "https://wa.me/{$adminWa}?text=" . rawurlencode($waTextClean);

        // Respon JSON untuk AJAX / Fetch
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status'   => 'success',
                'wa_url'   => $waUrl,
                'order_id' => $orderId
            ]);
        }

        // Fallback untuk HTTP Submit
        return redirect()->away($waUrl);
    }
}