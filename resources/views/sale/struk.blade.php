<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Mono', monospace;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 65%;
            margin: 20px auto;
            padding: 10px;
            border: 2px solid #D3D3D3;
        }
        .header, .footer {
            text-align: center;
        }
        .struk {
            margin-top: 30px;
            text-align: left;
        }
        .line {
            border-top: 1px solid #D3D3D3;
            margin: 10px 0;
        }
        .menu-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
        }
        .payment-method {
            margin-top: 10px;
            font-weight: bold;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button.print-btn {
            background-color: #007bff;
        }
        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>{{ $restaurant_name }}</h2>
            <p>{{ $restaurant_address }}</p>
            <p>{{ $restaurant_number }}</p>
            <div class="line"></div>
            <p class="right-align">Dilayani oleh: {{ $name }}</p>
            <p class="right-align">{{ now()->format('d M Y H:i:s') }} WIB</p>
        </div>

        <div class="struk">
            <h4>Menu</h4>
            <div class="line"></div>
            @foreach($itemsData as $item)
                <div class="menu-item">
                    <span>{{ $item['name'] }}</span>
                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="menu-item">
                    <span>{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                </div>
                <div class="line"></div>
            @endforeach

            <div class="total">
                <div class="menu-item">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                <div class="menu-item">
                    <span>PAJAK (10%)</span>
                    <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                </div>
                <div class="menu-item">
                    <span>JUMLAH TOTAL</span>
                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="payment-method">
                <span>METODE PEMBAYARAN: </span>
                <span>{{ $paymentMethod }}</span>
            </div>
        </div>

        <div class="button-container">
            <button class="print-btn" onclick="window.print();">Print</button>
            <br><br>
            <a href="{{ route('sale.payment.success') }}">
                <button>Selesai</button>
            </a>
        </div>
    </div>

</body>
</html>