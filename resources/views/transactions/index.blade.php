<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Riwayat Transaksi</h2> 
    
    <!-- Periksa apakah ada data transaksi -->
    @if($sales->isEmpty())
        <p>Tidak ada transaksi.</p>
    @else
        @foreach($sales as $sale)
            <div class="card mb-3" style="width: 100%;">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div><strong>Pembeli:</strong> {{ $sale->customer_name }}</div>
                    <div><strong>Waktu:</strong> {{ $sale->sale_date }}</div>
                    <div><strong>Harga:</strong> Rp{{ number_format($sale->grand_total, 0, ',', '.') }}</div>
                    <div><strong>Metode Pembayaran:</strong> {{ ucfirst($sale->payment_method) }}</div>
                </div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('app.home') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
</div>
</body>
</html>
