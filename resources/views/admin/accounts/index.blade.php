@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    <!-- Header Halaman & Tombol Tambah di Kanan Atas -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Katalog Stok Game</h4>
            <p class="text-muted small mb-0">Kelola daftar akun game yang tersedia untuk dijual di platform.</p>
        </div>
        <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary fw-bold px-3 py-2 shadow-sm rounded-3 small">
            <i class="fa-solid fa-plus me-1"></i> Tambah Akun Baru
        </a>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert Error Validasi (jika ada) -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terjadi Kesalahan:</div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card Tabel Full-Width -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="py-3 px-4">Akun & Kode</th>
                            <th class="py-3">Spesifikasi (Rank / Hero / Skin)</th>
                            <th class="py-3">Harga</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts ?? [] as $account)
                        <tr>
                            <!-- Kolom Akun & Thumbnail -->
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if($account->image)
                                        <img src="{{ asset('storage/' . $account->image) }}" class="rounded-3 object-fit-cover border shadow-sm" style="width: 45px; height: 45px;" alt="Thumb">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border" style="width: 45px; height: 45px;">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark small text-truncate" style="max-width: 220px;">{{ $account->name }}</div>
                                        <div class="text-muted" style="font-size: 11px;">Kode: <span class="badge bg-light text-dark border">{{ $account->code ?? '-' }}</span></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Spesifikasi Detail -->
                            <td class="py-3">
                                <div class="small fw-bold text-dark"><i class="fa-solid fa-shield-halved text-primary me-1"></i> {{ $account->rank ?? '-' }}</div>
                                <div class="text-muted" style="font-size: 11px;">
                                    Skin: {{ $account->skin_count ?? 0 }} | Hero: {{ $account->hero_count ?? 0 }} | Login: {{ $account->login_via ?? '-' }}
                                </div>
                            </td>

                            <!-- Kolom Harga -->
                            <td class="py-3">
                                <div class="fw-bold text-primary small">Rp {{ number_format($account->price, 0, ',', '.') }}</div>
                                @if($account->old_price)
                                    <div class="text-muted text-decoration-line-through" style="font-size: 11px;">Rp {{ number_format($account->old_price, 0, ',', '.') }}</div>
                                @endif
                            </td>

                            <!-- Kolom Status -->
                            <td class="text-center py-3">
                                @if($account->status == 'ready')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill small fw-semibold">Ready</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill small fw-semibold">Sold</span>
                                @endif
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="text-end px-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.accounts.edit', $account->id) }}" class="btn btn-light btn-sm border text-primary px-3 rounded-3" title="Edit Akun">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun game ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm border text-danger px-2 rounded-3" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">
                                <div class="mb-2"><i class="fa-solid fa-gamepad fa-3x text-secondary opacity-50"></i></div>
                                <div class="fw-bold">Belum ada data stok akun game.</div>
                                <p class="text-muted small">Silakan klik tombol "Tambah Akun Baru" di kanan atas untuk memasukkan data.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination Footer -->
        @if(isset($accounts) && method_exists($accounts, 'links') && $accounts->hasPages())
            <div class="card-footer bg-white py-3 px-4 border-top">
                {{ $accounts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection