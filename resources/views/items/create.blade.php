<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Menu Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Menu Baru</h2>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="photo" class="form-label">Foto Menu</label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" min="0" required>
        </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" id="stock" class="form-control" min="0" required>
    </div>

        <button type="submit" class="btn btn-success">Tambah Menu</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
