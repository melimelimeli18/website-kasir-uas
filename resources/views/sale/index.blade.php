<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Pilih Item Penjualan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Styles for card, badge, etc. (sama seperti sebelumnya) */
        .selectable-card {
            cursor: pointer;
            position: relative;
            border: 2px solid transparent;
            transition: 0.3s;
        }
        .selectable-card:hover,
        .selectable-card.selected {
            border-color: #0d6efd;
            background-color: #e9f3ff;
        }
        .item-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .badge-amount {
            position: absolute;
            top: 8px;
            right: 8px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            z-index: 10;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Halaman Penjualan</h2>

    <form id="transactionForm" method="POST" action="{{ route('sale.checkout') }}"> 
        @csrf
        <div class="row g-3">
            @foreach($items as $item)
            <div class="col-md-4">
                <div class="card selectable-card"
                    data-id="{{ $item->id }}"
                    data-name="{{ $item->name }}"
                    data-price="{{ $item->price }}">
                    @if($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="item-img me-3" />
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                            style="width:60px; height:60px; border-radius:0.5rem;">
                            No Photo
                        </div>
                    @endif
                    <div class="p-2">
                        <h6>{{ $item->name }}</h6>
                        <p class="mb-0">Rp {{ number_format($item->price,0,',','.') }}</p>
                    </div>
                    <div class="badge-amount d-none" id="badge-amount-{{ $item->id }}">0</div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Hidden inputs untuk items dan quantity -->
        <div id="hiddenInputsContainer"></div>

        <div class="mt-3 d-flex justify-content-between align-items-center">
            <div id="alert-no-items" class="alert alert-warning m-0">Tambahkan item terlebih dahulu</div>
            <button type="submit" class="btn btn-success d-none" id="btn-process">
                Proses Transaksi Rp <span id="total-price">0</span>
            </button>
        </div>
    </form>

</div>

<!-- Modal jumlah item (sama seperti sebelumnya) -->
<div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 35%;">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="quantityModalLabel">Jumlah Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p id="modalItemName" class="fw-bold fs-5"></p>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <button type="button" class="btn btn-outline-primary" id="btnMinus">
                        <!-- SVG minus icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="2" viewBox="0 0 14 2" fill="none">
                            <path d="M13 1.99805H1C0.734784 1.99805 0.48043 1.89269 0.292893 1.70515C0.105357 1.51762 0 1.26326 0 0.998047C0 0.73283 0.105357 0.478477 0.292893 0.29094C0.48043 0.103404 0.734784 -0.00195312 1 -0.00195312H13C13.2652 -0.00195312 13.5196 0.103404 13.7071 0.29094C13.8946 0.478477 14 0.73283 14 0.998047C14 1.26326 13.8946 1.51762 13.7071 1.70515C13.5196 1.89269 13.2652 1.99805 13 1.99805Z" fill="black"/>
                        </svg>
                    </button>
                    <input type="text" id="quantityInput" class="form-control text-center" value="1" style="width: 60px;" readonly />
                    <button type="button" class="btn btn-outline-primary" id="btnPlus">
                        <!-- SVG plus icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19 12.998H13V18.998H11V12.998H5V10.998H11V4.99805H13V10.998H19V12.998Z" fill="black"/>
                        </svg>
                    </button>
                </div>
                <p>Harga per item: <span id="modalItemPrice"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancel" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnAdd" class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const cards = document.querySelectorAll('.selectable-card');
    const modal = new bootstrap.Modal(document.getElementById('quantityModal'));
    const modalItemName = document.getElementById('modalItemName');
    const modalItemPrice = document.getElementById('modalItemPrice');
    const quantityInput = document.getElementById('quantityInput');
    const btnPlus = document.getElementById('btnPlus');
    const btnMinus = document.getElementById('btnMinus');
    const btnAdd = document.getElementById('btnAdd');
    const btnCancel = document.getElementById('btnCancel');
    const badgeAmounts = {};

    let selectedItemId = null;
    let selectedItemName = '';
    let selectedItemPrice = 0;
    let quantity = 1;

    const selectedItems = {};  // object id -> quantity

    function updateTransactionArea() {
        const totalPrice = Object.entries(selectedItems).reduce((total, [id, qty]) => {
            const price = parseFloat(document.querySelector(`.selectable-card[data-id="${id}"]`).dataset.price);
            return total + price * qty;
        }, 0);

        const alertNoItems = document.getElementById('alert-no-items');
        const btnProcess = document.getElementById('btn-process');
        const totalPriceSpan = document.getElementById('total-price');

        if (Object.keys(selectedItems).length === 0) {
            alertNoItems.classList.remove('d-none');
            btnProcess.classList.add('d-none');
        } else {
            alertNoItems.classList.add('d-none');
            btnProcess.classList.remove('d-none');
            totalPriceSpan.textContent = totalPrice.toLocaleString('id-ID');
        }
    }

    function updateHiddenInputs() {
        const container = document.getElementById('hiddenInputsContainer');
        container.innerHTML = ''; // kosongkan dulu

        // Mengirimkan data items dan quantity
        for (const [id, qty] of Object.entries(selectedItems)) {
            // input item id
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'items[]';  // Menyimpan item ke dalam array
            inputId.value = id;
            container.appendChild(inputId);

            // input qty
            const inputQty = document.createElement('input');
            inputQty.type = 'hidden';
            inputQty.name = `quantity[${id}]`;  // Mengirimkan quantity dengan ID item
            inputQty.value = qty;
            container.appendChild(inputQty);
        }
    }


    cards.forEach(card => {
        card.addEventListener('click', () => {
            selectedItemId = card.dataset.id;
            selectedItemName = card.dataset.name;
            selectedItemPrice = card.dataset.price;
            quantity = selectedItems[selectedItemId] || 1;

            modalItemName.textContent = selectedItemName;
            modalItemPrice.textContent = 'Rp ' + Number(selectedItemPrice).toLocaleString('id-ID');
            quantityInput.value = quantity;

            modal.show();
        });
    });

    btnPlus.addEventListener('click', () => {
        quantity++;
        quantityInput.value = quantity;
    });

    btnMinus.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
        }
    });

    btnCancel.addEventListener('click', () => {
        selectedItemId = null;
        selectedItemName = '';
        selectedItemPrice = 0;
        quantity = 1;
    });

    btnAdd.addEventListener('click', () => {
        if (!selectedItemId) {
            alert('Pilih item terlebih dahulu!');
            return;
        }
        selectedItems[selectedItemId] = quantity;

        const badge = document.getElementById(`badge-amount-${selectedItemId}`);
        badge.textContent = quantity;
        badge.classList.remove('d-none');

        updateHiddenInputs();
        updateTransactionArea();

        modal.hide();
    });
    
</script>
</body>
</html>
