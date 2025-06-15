<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sale;

class SaleController extends Controller
{
    public function checkoutPage(){
        return view ('sale.checkout');
    }

    public function index()
    {
        $items = Item::all();
        return view('sale.index', compact('items'));
    }
public function checkoutProcess(Request $request)
{
$request->validate([
        'items' => 'required|array',
        'items.*' => 'required|integer|exists:items,id',
        'quantity' => 'required|array',
        'quantity.*' => 'required|integer|min:1',
    ]);

    $items = $request->input('items');
    $quantities = $request->input('quantity');

    $totalPrice = 0;
    $itemsData = [];

    foreach ($items as $itemId) {
        // Gunakan item ID sebagai key, bukan index
        if (isset($quantities[$itemId])) {
            $item = Item::find($itemId);
            $qty = $quantities[$itemId];  // Gunakan item ID sebagai key
            $subtotal = $item->price * $qty;
            $totalPrice += $subtotal;

            $itemsData[] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,    
                'quantity' => $qty,
                'subtotal' => $subtotal
            ];
        } else {
            return redirect()->back()->withErrors(['quantity' => 'Quantity for item ID ' . $itemId . ' is missing']);
        }
    }

    // Hitung pajak dan grand total
    $tax = $totalPrice * 0.1;
    $grandTotal = $totalPrice + $tax;

    // Menyimpan semua data terkait checkout ke session
    session([
        'checkout_data' => [
            'itemsData' => $itemsData,
            'totalPrice' => $totalPrice,
            'tax' => $tax,
            'grandTotal' => $grandTotal,
            'items' => $items,  // Menyimpan data items
            'quantities' => $quantities  // Menyimpan data quantity
        ]
    ]);

    return redirect()->route('sale.checkout');  // Redirect ke halaman checkout
}

public function submit(Request $request)
{
    // Ambil data checkout dari session
    $checkoutData = session('checkout_data', []);

    // Validasi data tambahan dari halaman checkout
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'payment_method' => 'required|string',
    ]);

    // Gabungkan data checkout dari session dengan data tambahan dari halaman checkout
    $allData = array_merge($checkoutData, $request->only(['customer_name', 'payment_method']));

    // Tambahkan sale_date ke data
    $allData['sale_date'] = now();  // Atur tanggal penjualan menjadi waktu saat ini

    // Format data items menjadi JSON jika perlu
    $allData['items'] = json_encode($allData['itemsData']);  // Menyimpan items sebagai JSON

    Sale::create([
        'customer_name' => $allData['customer_name'],
        'sale_date' => $allData['sale_date'],
        'items' => $allData['items'],
        'total_price' => $allData['totalPrice'],
        'tax' => $allData['tax'],
        'grand_total' => $allData['grandTotal'],
        'payment_method' => $allData['payment_method'],
    ]);

    session()->forget('checkout_data');
    return redirect()->route('sale.struk');
}



    public function showCheckoutPage()
    {
        $checkoutData = session('checkout_data', []);

        return view('sale.checkout', [
            'itemsData' => $checkoutData['itemsData'] ?? [],
            'totalPrice' => $checkoutData['totalPrice'] ?? 0,
            'tax' => $checkoutData['tax'] ?? 0,
            'grandTotal' => $checkoutData['grandTotal'] ?? 0
        ]);
    }

public function generateReceipt()
{
    // Ambil data transaksi terakhir dari database
    $sale = Sale::latest()->first();  // Mengambil transaksi terakhir yang disimpan

    // Ambil informasi user (restoran) dari model User
    $user = auth()->user();  // Ambil user yang sedang login

    // Tampilkan halaman struk dengan data yang diperlukan
    return view('sale.struk', [
        'itemsData' => json_decode($sale->items, true), // Decode JSON ke array
        'totalPrice' => $sale->total_price,
        'tax' => $sale->tax,
        'grandTotal' => $sale->grand_total,
        'paymentMethod' => $sale->payment_method,
        'customerName' => $sale->customer_name,
        'restaurant_name' => $user->restaurant_name,
        'restaurant_address' => $user->restaurant_address,
        'restaurant_number' => $user->restaurant_number,
        'name' => $user->name,  // Nama pelayan
    ]);
}


}
