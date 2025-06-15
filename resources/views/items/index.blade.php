<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Menu</h2>
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>
    <a href="{{ route('app.home') }}" class="btn btn-secondary mb-3">Home</a>


    @if($items->isEmpty())
        <div class="alert alert-info">Menu masih kosong.</div>
    @else
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                Tidak ada foto
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">
                                Harga: Rp {{ number_format($item->price, 0, ',', '.') }}<br />
                                Stock: {{ number_format($item->stock, 0, ',', '.') }}<br />
                            </p>

                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>
</body>
</html>
