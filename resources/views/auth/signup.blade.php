<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Sign Up</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('signup') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="restaurant_name" class="form-label">Nama Resto</label>
            <input type="text" name="restaurant_name" id="restaurant_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="restaurant_number" class="form-label">Nomor Resto</label>
            <input type="number" name="restaurant_number" id="restaurant_number" class="form-control" required step="1">
            @error('restaurant_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="restaurant_address" class="form-label">Alamat Resto</label>
            <textarea name="restaurant_address" id="restaurant_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="restaurant_photo" class="form-label">Foto Resto</label>
            <input type="file" name="restaurant_photo" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (at least 8 charather)</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Sign Up</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Sudah punya akun?</a>
    </form>
</div>
</body>
</html>