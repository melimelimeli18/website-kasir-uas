<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Akun</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Restoran -->
            <div class="mb-3">
                <label for="restaurant_name" class="form-label">Nama Restoran</label>
                <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value="{{ old('restaurant_name', $user->restaurant_name) }}" required>
            </div>

            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="restaurant_number" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="restaurant_number" name="restaurant_number" value="{{ old('restaurant_number', $user->restaurant_number) }}" required>
            </div>

            <!-- Alamat Restoran -->
            <div class="mb-3">
                <label for="restaurant_address" class="form-label">Alamat Restoran</label>
                <input type="text" class="form-control" id="restaurant_address" name="restaurant_address" value="{{ old('restaurant_address', $user->restaurant_address) }}" required>
            </div>

            <!-- Foto Restoran -->
            <div class="mb-3">
                <label for="restaurant_photo" class="form-label">Foto Restoran</label>
                @if ($user->restaurant_photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $user->restaurant_photo) }}" alt="Restaurant Photo" width="100">
                    </div>
                @endif
                <input type="file" class="form-control" id="restaurant_photo" name="restaurant_photo">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>

        <a href="{{ route('app.home') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
