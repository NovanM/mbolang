<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookTicket($id)
    {
        $destinasi = Destinasi::findOrFail($id);

        return view('destinasi.pesan-tiket', compact('destinasi'));
    }

    public function checkout($id)
    {
        $destinasi = Destinasi::findOrFail($id);
        
        // Get data from session or query parameters
        $quantity = request('quantity', 5);
        $date = request('date', now()->format('Y-m-d'));
        $total = $destinasi->harga_tiket * $quantity;

        return view('destinasi.checkout', compact('destinasi', 'quantity', 'date', 'total'));
    }

    public function processPayment($id, Request $request)
    {
        $destinasi = Destinasi::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'negara' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // Generate unique order ID
        $orderId = 'ORDER-' . $destinasi->id_destinasi . '-' . time();
        $grossAmount = $destinasi->harga_tiket * $request->quantity;

        // Prepare transaction details
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        // Item details
        $itemDetails = [
            [
                'id' => $destinasi->id_destinasi,
                'price' => $destinasi->harga_tiket,
                'quantity' => $request->quantity,
                'name' => 'Tiket ' . $destinasi->nama_destinasi,
            ]
        ];

        // Customer details
        $customerDetails = [
            'first_name' => $request->nama,
            'email' => $request->email,
            'phone' => $request->negara, // Using negara field as additional info
        ];

        // Transaction data
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Get Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($transactionData);
            
            // Return snap token to frontend
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->order_id;
        $destinasiId = $request->destinasi_id;
        $quantity = $request->quantity;
        $date = $request->date;
        $destinasiName = $request->destinasi_name;
        
        return view('destinasi.payment-success', compact('orderId', 'destinasiId', 'quantity', 'date', 'destinasiName'));
    }
}
