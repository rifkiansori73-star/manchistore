@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold text-dark mb-4">Pengaturan Tampilan Stok Katalog Akun</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form Setting Limit Tampilan Home -->
    <div class="card shadow border-0 mb-4 col-md-6">
        <div class="card-body">
            <form action="{{ route('admin.settings.katalog.limit') }}" method="POST" class="d-flex align-items-center gap-3">
                @csrf
                <label class="fw-bold text-nowrap mb-0">Jumlah Akun Tampil di Web Depan:</label>
                <input type="number" name="limit_katalog_home" class="form-control" value="{{ $limitDisplay }}" min="1" max="20" style="width: 90px;">
                <button type="submit" class="btn btn-sm btn-primary text-nowrap">Simpan Limit</button>
            </form>
        </div>
    </div>

    <!-- Tabel Kelola Tampilan Akun Web Depan -->
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white font-weight-bold">
            <i class="fa-solid fa-list me-2"></i>Daftar Akun Game & Control Web Depan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Thumbnail</th>
                            <th>Judul Akun Game</th>
                            <th>Harga (Rp)</th>
                            <th>Status Stok</th>
                            <th>Tampil di Web Depan?</th>
                            <th>Aksi Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $acc)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $acc->thumbnail) }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                            </td>
                            <td class="fw-bold">{{ $acc->title }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($acc->price, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('admin.settings.katalog.status', $acc->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm {{ $acc->status == 'ready' ? 'border-success text-success' : 'border-danger text-danger' }}">
                                        <option value="ready" {{ $acc->status == 'ready' ? 'selected' : '' }}>READY</option>
                                        <option value="sold" {{ $acc->status == 'sold' ? 'selected' : '' }}>SOLD OUT</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.settings.katalog.toggle', $acc->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $acc->is_featured ? 'btn-success' : 'btn-secondary' }}">
                                        <i class="fa-solid {{ $acc->is_featured ? 'fa-eye' : 'fa-eye-slash' }} me-1"></i>
                                        {{ $acc->is_featured ? 'Ditampilkan' : 'Disembunyikan' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('akun.show', $acc->slug) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Cek
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data akun game.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection