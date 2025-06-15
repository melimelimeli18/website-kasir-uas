<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Edit Menu</h2>

    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="photo" class="form-label">Foto Menu</label><br>
            @if($item->photo)
                <img src="{{ asset('storage/' . $item->photo) }}" alt="Foto Menu" style="height: 150px; object-fit: cover; margin-bottom: 10px;">
            @endif
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $item->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $item->price) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $item->stock) }}" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
