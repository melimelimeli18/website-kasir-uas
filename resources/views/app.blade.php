<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Styling for the header and the card layout */
        .card-body {
            text-align: center;
            padding: 20px;
        }
        .menu-card {
            cursor: pointer;
            text-decoration: none;
            color: #000;
        }
        .card-icon {
            font-size: 36px;
            margin-bottom: 15px;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .header-logo {
            width: 80px;
            height: 80px;
        }
        .header-container {
            margin-top: 56px;
            margin-bottom: 23px;
        }
        .menu-container {
            margin-top: 30px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        /* For the edit button */
        .edit-button {
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 20px;
            margin-right: 20px;
        }
        .menu-cards-container {
            display: flex;
            justify-content: space-around;
        }
        .menu-card-container {
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex align-items-center mb-4 header-container" style="position: relative;">
            <div class="me-3">
                <img src="{{ asset('storage/' . Auth::user()->restaurant_photo) }}" alt="Logo Restoran" class="rounded-circle header-logo">
            </div>
            <div>
                <!-- Menampilkan Nama Restoran dan Info -->
                <h4 class="mb-0">{{ Auth::user()->restaurant_name }}</h4>
                <small>No Telp: {{ Auth::user()->restaurant_number }}</small><br>
                <small>{{ Auth::user()->restaurant_address }}</small>
            </div>
            <!-- Tombol Edit Akun di pojok kanan -->
            <div class="edit-button">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Akun</a>
            </div>
        </div>

        <!-- Menampilkan Selamat Datang -->
        <h2 class="mb-3">Selamat datang di Home, {{ Auth::user()->restaurant_name }}!</h2>

        <!-- Menu Cards -->
        <div class="menu-cards-container">
            <div class="menu-card-container">
                <a href="{{ route('sale.index') }}" class="card text-decoration-none text-dark shadow menu-card">
                    <div class="card-body">
                        <i class="fas fa-cash-register fa-2x card-icon"></i>
                        <h5 class="card-title">Sale</h5>
                    </div>
                </a>
            </div>
            <div class="menu-card-container">
                <a href="{{ route('transactions.index') }}" class="card text-decoration-none text-dark shadow menu-card">
                    <div class="card-body">
                        <i class="fas fa-history fa-2x card-icon"></i>
                        <h5 class="card-title">Riwayat Transaksi</h5>
                    </div>
                </a>
            </div>
            <div class="menu-card-container">
                <a href="{{ route('items.index') }}" class="card text-decoration-none text-dark shadow menu-card">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-2x card-icon"></i>
                        <h5 class="card-title">Item</h5>
                    </div>
                </a>
            </div>
        </div>

        <!-- Logout Button at the Bottom -->
        <div class="footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf   
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
