@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Notifikasi Error Validasi Form -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Gagal Menyimpan Pembatalan:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Indicator Cards Header -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 bg-success text-white shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 fw-bold opacity-75">Total Order</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalOrders }}</h2>
                    </div>
                    <i class="fa-solid fa-box-archive fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 bg-primary text-white shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 fw-bold opacity-75">Paid</h6>
                        <h2 class="mb-0 fw-bold">{{ $paidCount }}</h2>
                    </div>
                    <i class="fa-solid fa-circle-check fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-warning text-dark shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 fw-bold opacity-75">Pending</h6>
                        <h2 class="mb-0 fw-bold">{{ $pendingCount }}</h2>
                    </div>
                    <i class="fa-solid fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Manage Orders -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary fw-bold">Manage Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product / Service</th>
                            <th>Price / Profit</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->service_type }}</strong><br>
                                <small class="text-muted">{{ $order->order_details }}</small><br>
                                <span class="badge bg-secondary mt-1">{{ $order->order_id }}</span>

                                <!-- KOTAK RINCIAN DETAIL PEMBATALAN -->
                                @if($order->status === 'Canceled')
                                    <div class="mt-2 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded small text-danger">
                                        <div class="fw-bold mb-1"><i class="fa-solid fa-circle-xmark me-1"></i>Detail Pembatalan:</div>
                                        <div class="mb-2"><strong>Alasan:</strong> {{ $order->cancel_reason ?? 'Belum ada alasan tertulis' }}</div>
                                        
                                        <div class="d-flex gap-2 align-items-center flex-wrap">
                                            @if($order->cancel_proof)
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger fw-semibold py-1 px-2 fs-12"
                                                        onclick="viewProof('{{ asset('storage/' . $order->cancel_proof) }}', '{{ $order->order_id }}', '{{ addslashes($order->cancel_reason) }}')">
                                                    <i class="fa-solid fa-image me-1"></i>Lihat Bukti Foto / File
                                                </button>
                                            @endif

                                            <!-- Tombol Upload / Edit Bukti & Alasan -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger text-white fw-semibold py-1 px-2 fs-12"
                                                    onclick="openCancelModal('{{ $order->id }}', '{{ addslashes($order->cancel_reason) }}')">
                                                <i class="fa-solid fa-pen-to-square me-1"></i>{{ $order->cancel_reason ? 'Edit Bukti & Alasan' : '+ Upload Bukti & Alasan' }}
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>Rp {{ number_format($order->price, 0, ',', '.') }}</div>
                                <small class="text-success fw-bold">+ Rp {{ number_format($order->profit, 0, ',', '.') }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $order->customer_name }}</span>
                            </td>
                            <td>
                                @if($order->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'Paid')
                                    <span class="badge bg-primary">Paid</span>
                                @elseif($order->status == 'Success')
                                    <span class="badge bg-success">Success</span>
                                @else
                                    <span class="badge bg-danger">Canceled</span>
                                @endif
                            </td>
                            <td>
                                <!-- Form Option Dropdown -->
                                <form id="statusForm-{{ $order->id }}" action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm w-auto" onchange="handleStatusChange(this, '{{ $order->id }}', '{{ $order->status }}')">
                                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Paid" {{ $order->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="Success" {{ $order->status == 'Success' ? 'selected' : '' }}>Success</option>
                                        <option value="Canceled" {{ $order->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada orderan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: Form Input Alasan & Upload Bukti Pembatalan -->
<div class="modal fade" id="cancelModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="cancelModalLabel"><i class="fa-solid fa-triangle-exclamation me-2"></i>Form Pembatalan Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="resetSelect()"></button>
            </div>
            <form id="cancelModalForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="Canceled">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Pembatalan <span class="text-danger">*</span></label>
                        <textarea id="cancel_reason_input" name="cancel_reason" class="form-control" rows="3" placeholder="Contoh: Stok akun habis / Pembayaran tidak valid / Dibatalkan pelanggan" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Foto Bukti / File Lampiran</label>
                        <input type="file" name="cancel_proof" class="form-control" accept="image/*,.pdf">
                        <small class="text-muted">Mendukung file: JPG, PNG, WEBP, PDF (Maksimal 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetSelect()">Batal</button>
                    <button type="submit" class="btn btn-danger fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan Pembatalan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: Preview Bukti Foto Canceled Berukuran Besar -->
<div class="modal fade" id="viewProofModal" tabindex="-1" aria-labelledby="viewProofModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="viewProofModalLabel">
                    <i class="fa-solid fa-file-image me-2 text-danger"></i>Bukti Pembatalan Order <span id="modalOrderId" class="text-warning"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center bg-light p-4">
                <div class="mb-3 text-start p-3 bg-white border rounded shadow-sm">
                    <strong class="text-danger"><i class="fa-solid fa-comment-dots me-1"></i>Alasan Batal:</strong>
                    <div id="modalCancelReason" class="text-dark mt-1 fs-6"></div>
                </div>
                
                <div class="text-center">
                    <img id="modalProofImage" src="" alt="Bukti Batal" class="img-fluid rounded border shadow-sm" style="max-height: 480px; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer bg-white">
                <a id="downloadProofBtn" href="#" target="_blank" class="btn btn-outline-primary fw-semibold">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>Buka Gambar Asli / Tab Baru
                </a>
                <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeSelectElement = null;
    let activeOriginalStatus = '';

    // Buka Modal saat Status diubah dari Dropdown
    function handleStatusChange(selectElement, orderId, currentStatus) {
        if (selectElement.value === 'Canceled') {
            openCancelModal(orderId, '');
            activeSelectElement = selectElement;
            activeOriginalStatus = currentStatus;
        } else {
            document.getElementById('statusForm-' + orderId).submit();
        }
    }

    // Buka Modal secara Manual via Tombol Merah
    function openCancelModal(orderId, currentReason) {
        let actionUrl = "{{ route('admin.orders.updateStatus', ':id') }}".replace(':id', orderId);
        document.getElementById('cancelModalForm').action = actionUrl;
        document.getElementById('cancel_reason_input').value = currentReason || '';
        
        let cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
        cancelModal.show();
    }

    function resetSelect() {
        if (activeSelectElement) {
            activeSelectElement.value = activeOriginalStatus;
        }
    }

    // Tampilkan Modal Gambar Bukti Foto
    function viewProof(imageUrl, orderId, cancelReason) {
        document.getElementById('modalOrderId').innerText = '#' + orderId;
        document.getElementById('modalCancelReason').innerText = cancelReason || 'Tidak ada alasan tertulis';
        document.getElementById('modalProofImage').src = imageUrl;
        document.getElementById('downloadProofBtn').href = imageUrl;

        let proofModal = new bootstrap.Modal(document.getElementById('viewProofModal'));
        proofModal.show();
    }
</script>
@endsection