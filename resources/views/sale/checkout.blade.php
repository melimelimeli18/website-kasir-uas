@php
    // Ambil data dari session
    $checkoutData = session('checkout_data');
    $itemsData = $checkoutData['itemsData'] ?? [];
    $totalPrice = $checkoutData['totalPrice'] ?? 0;
    $tax = $checkoutData['tax'] ?? 0;
    $grandTotal = $checkoutData['grandTotal'] ?? 0;
    $items = $checkoutData['items'] ?? [];
    $quantities = $checkoutData['quantities'] ?? [];
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Checkout Penjualan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Halaman Checkout</h2>

        <form action="{{ route('sale.submit') }}" method="POST">
            @csrf

            <h4>Detail Item</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemsData as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            <!-- Hidden inputs untuk kirim ulang data ke controller -->
                            <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item['id'] }}">
                            <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p>Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            <p>Pajak (10%): Rp {{ number_format($tax, 0, ',', '.') }}</p>
            <p><strong>Grand Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></p>


            <!-- Kirim data total harga ke controller -->
            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            <input type="hidden" name="tax" value="{{ $tax }}">
            <input type="hidden" name="grand_total" value="{{ $grandTotal }}">

            <div class="mb-3">
                <label for="customer_name" class="form-label">Nama Pelanggan</label>
                <input type="text" name="customer_name" class="form-control" id="customer_name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label><br>
                <input type="radio" name="gender" value="Laki-laki" required> Laki-laki
                <input type="radio" name="gender" value="Perempuan"> Perempuan
            </div>

            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label><br>
                <input type="radio" name="payment_method" value="qris" required> QRIS<br>
                <input type="radio" name="payment_method" value="bca"> Virtual Account BCA<br>
                <input type="radio" name="payment_method" value="bri"> Virtual Account BRI
            </div>

            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
    </form>
</div>
</body>
</html>
