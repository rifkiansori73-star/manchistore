@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2 px-md-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    <!-- Header / Navigasi Kembali -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Katalog Akun Game
            </h4>
            <p class="text-secondary small mb-0">Perbarui informasi spesifikasi detail, harga, atau foto akun game.</p>
        </div>
        <a href="{{ route('admin.accounts.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill fw-semibold shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Alert Error Validasi -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terjadi Kesalahan Input:</div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Utama Edit -->
    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Kolom Kiri: Informasi Utama & Spesifikasi -->
            <div class="col-xl-8 mb-4">
                
                <!-- Card 1: Informasi Utama & Harga -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-circle-info text-primary me-2"></i>1. Informasi Utama & Harga</h6>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Nama / Judul Akun -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Judul / Nama Akun Game <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $account->name) }}" placeholder="Contoh: Akun Mythic Glory Full Skin" required>
                        </div>

                        <div class="row">
                            <!-- Kode / ID Unik Akun -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark small">Kode / ID Akun</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $account->code) }}" placeholder="Contoh: MC-TWTNVG">
                            </div>

                            <!-- Status Stok -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark small">Status Stok <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="ready" {{ old('status', $account->status) == 'ready' ? 'selected' : '' }}>Ready (Tersedia)</option>
                                    <option value="sold" {{ old('status', $account->status) == 'sold' ? 'selected' : '' }}>Sold (Terjual)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Harga Jual -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark small">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', $account->price) }}" placeholder="150000" required>
                                </div>
                            </div>

                            <!-- Harga Coret (Opsional) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark small">Harga Coret / Normal (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>
                                    <input type="number" name="old_price" class="form-control" value="{{ old('old_price', $account->old_price) }}" placeholder="250000">
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox Featured -->
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured', $account->is_featured) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold small text-dark" for="isFeatured">
                                Tampilkan sebagai Akun Unggulan / Featured di Beranda
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Card 2: Spesifikasi Detail Game -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-gamepad text-primary me-2"></i>2. Spesifikasi Detail Game</h6>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="row">
                            <!-- Rank -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark small">Rank / Tier</label>
                                <input type="text" name="rank" class="form-control" value="{{ old('rank', $account->rank) }}" placeholder="Contoh: Mythic Glory">
                            </div>

                            <!-- Login Via -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark small">Login Via</label>
                                <input type="text" name="login_via" class="form-control" value="{{ old('login_via', $account->login_via) }}" placeholder="Contoh: Moonton">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Jumlah Skin -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-dark small">Jumlah Skin</label>
                                <input type="number" name="skin_count" class="form-control" value="{{ old('skin_count', $account->skin_count) }}" placeholder="120">
                            </div>

                            <!-- Jumlah Hero -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-dark small">Jumlah Hero</label>
                                <input type="number" name="hero_count" class="form-control" value="{{ old('hero_count', $account->hero_count) }}" placeholder="115">
                            </div>

                            <!-- Emblem -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-dark small">Emblem</label>
                                <input type="text" name="emblem" class="form-control" value="{{ old('emblem', $account->emblem) }}" placeholder="Contoh: Max All">
                            </div>
                        </div>

                        <!-- Minus Akun -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Minus Akun (Opsional)</label>
                            <textarea name="minus" class="form-control" rows="2" placeholder="Tuliskan jika ada minus">{{ old('minus', $account->minus) }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Foto & Media Katalog + Tombol Simpan -->
            <div class="col-xl-4 mb-4">
                
                <!-- Card 3: Foto & Media Katalog -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-images text-primary me-2"></i>3. Foto & Media</h6>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Preview Thumbnail Lama jika ada -->
                        @if(!empty($account->image))
                            <div class="mb-3 text-center">
                                <span class="d-block text-muted small mb-1">Thumbnail Saat Ini:</span>
                                <img src="{{ asset('storage/' . $account->image) }}" alt="Thumbnail" class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                        @endif

                        <!-- Thumbnail Utama (image) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Ganti Thumbnail Utama</label>
                            <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                            <div class="form-text text-muted small mt-1">Biarkan kosong jika tidak ingin mengubah foto.</div>
                        </div>

                        <!-- Foto Galeri Tambahan (images[]) -->
                        <div>
                            <label class="form-label fw-bold text-dark small">Tambah Galeri Foto (Opsional)</label>
                            <input type="file" name="images[]" class="form-control form-control-sm" multiple accept="image/*">
                            <div class="form-text text-muted small mt-1">Pilih file tambahan untuk galeri produk.</div>
                        </div>

                    </div>
                </div>

                <!-- Aksi Simpan & Batal -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Perbarui Perubahan
                        </button>
                        <a href="{{ route('admin.accounts.index') }}" class="btn btn-light border py-2 fw-semibold text-secondary">
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>
@endsection