@extends('layouts.market')

@section('content')
<style>
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .detail-card {
        background: linear-gradient(145deg, #121a29 0%, #090e18 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    
    /* Tombol Kembali Minimalis & Elegan */
    .btn-back-catalog {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 16px;
        border-radius: 50rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }
    .btn-back-catalog:hover {
        background: rgba(56, 189, 248, 0.12);
        border-color: rgba(56, 189, 248, 0.3);
        color: #38bdf8;
        transform: translateX(-3px);
    }

    /* Carousel Gambar Profesional */
    .carousel-image-wrapper {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: #020617;
        height: 420px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    @media (max-width: 768px) {
        .carousel-image-wrapper {
            height: 300px;
        }
    }
    .carousel-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain; 
        background-color: #020617;
    }
    
    .badge-status-ready {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    .badge-status-sold {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    .price-tag {
        font-size: 2.2rem;
        font-weight: 800;
        color: #38bdf8;
        letter-spacing: -0.5px;
    }
    @media (max-width: 576px) {
        .price-tag {
            font-size: 1.65rem;
        }
    }
    .old-price {
        font-size: 1.05rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    /* Perbaikan Card Spesifikasi agar Tidak Terpotong (Multi-line Support) */
    .spec-box {
        background: rgba(255, 255, 255, 0.025);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        padding: 12px 10px;
        text-align: center;
        transition: all 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .spec-box:hover {
        background: rgba(56, 189, 248, 0.04);
        border-color: rgba(56, 189, 248, 0.25);
    }
    .spec-title {
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .spec-val {
        font-size: 0.95rem;
        font-weight: 700;
        color: #f8fafc;
        line-height: 1.25;
        /* Memastikan teks panjang turun ke bawah alih-alih terpotong */
        white-space: normal;
        word-break: break-word;
    }
    
    .section-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    
    /* Tombol Aksi WhatsApp Modern */
    .btn-buy-wa {
        background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 16px;
        border-radius: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.25);
        font-size: 0.95rem;
    }
    .btn-buy-wa:hover {
        background: linear-gradient(135deg, #16a34a 0%, #166534 100%);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }
    .btn-nego-wa {
        background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 16px;
        border-radius: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25);
        font-size: 0.95rem;
    }
    .btn-nego-wa:hover {
        background: linear-gradient(135deg, #d97706 0%, #92400e 100%);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }
</style>

<div class="container-fluid detail-container px-3 px-md-4 py-4">
    
    <!-- Header Navigasi Kembali -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('akun.index') }}" class="btn-back-catalog shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Katalog
        </a>
        <div class="text-muted small d-none d-sm-block">
            <span class="text-info fw-semibold">ManChi Store</span> &bull; Detail Akun Game
        </div>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Slider Foto Utama & Galeri -->
        <div class="col-lg-5">
            <div class="detail-card p-3 mb-2">
                
                <div id="accountImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                    
                    @php
                        $hasThumbnail = !empty($account->image);
                        $hasGallery = !empty($account->images) && is_array($account->images) && count($account->images) > 0;
                        $totalSlides = ($hasThumbnail ? 1 : 0) + ($hasGallery ? count($account->images) : 0);
                    @endphp

                    @if($totalSlides > 1)
                        <div class="carousel-indicators">
                            @if($hasThumbnail)
                                <button type="button" data-bs-target="#accountImagesCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            @endif
                            @if($hasGallery)
                                @foreach($account->images as $idx => $galImg)
                                    <button type="button" data-bs-target="#accountImagesCarousel" data-bs-slide-to="{{ ($hasThumbnail ? 1 : 0) + $idx }}" aria-label="Slide {{ ($hasThumbnail ? 1 : 0) + $idx + 1 }}"></button>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <div class="carousel-image-wrapper">
                        <div class="carousel-inner h-100">
                            @if($hasThumbnail)
                                <div class="carousel-item active h-100">
                                    <img src="{{ asset('storage/' . $account->image) }}" class="d-block w-100 h-100" alt="{{ $account->name }}">
                                </div>
                            @endif

                            @if($hasGallery)
                                @foreach($account->images as $idx => $galImg)
                                    <div class="carousel-item h-100 {{ !$hasThumbnail && $idx == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $galImg) }}" class="d-block w-100 h-100" alt="Galeri Screenshot">
                                    </div>
                                @endforeach
                            @endif

                            @if(!$hasThumbnail && !$hasGallery)
                                <div class="carousel-item active h-100">
                                    <img src="https://via.placeholder.com/600x400/121824/38bdf8?text=ManchiStore" class="d-block w-100 h-100" alt="Default">
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($totalSlides > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#accountImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark bg-opacity-70 rounded-circle p-3 shadow" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#accountImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark bg-opacity-70 rounded-circle p-3 shadow" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif

                </div>

            </div>
            
            <div class="text-center text-muted small px-2">
                <i class="fa-solid fa-circle-info me-1 text-info"></i> Geser atau klik panah untuk melihat galeri screenshot akun.
            </div>
        </div>

        <!-- Kolom Kanan: Informasi Detail Akun -->
        <div class="col-lg-7">
            <div class="detail-card p-3 p-md-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <!-- Badge Status & ID -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $status = strtolower($account->status ?? 'ready');
                                $isReady = in_array($status, ['ready', 'tersedia']);
                            @endphp
                            <span class="badge {{ $isReady ? 'badge-status-ready' : 'badge-status-sold' }} px-3 py-1.5 rounded-pill fw-bold shadow-sm">
                                <i class="fa-solid {{ $isReady ? 'fa-check-circle' : 'fa-ban' }} me-1"></i> 
                                {{ ucfirst($account->status ?? 'Ready') }}
                            </span>
                            
                            @if(!empty($account->is_featured))
                                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold shadow-sm">
                                    <i class="fa-solid fa-star me-1"></i> Unggulan
                                </span>
                            @endif
                        </div>
                        <div>
                            <span class="badge bg-dark border border-secondary text-info px-3 py-1.5 rounded-pill fw-bold font-monospace">
                                <i class="fa-solid fa-fingerprint me-1"></i> ID: {{ $account->code ?? $account->id }}
                            </span>
                        </div>
                    </div>

                    <!-- Judul Akun -->
                    <h1 class="fw-bold text-white mb-3 fs-4 fs-md-3" style="letter-spacing: 0.2px; line-height: 1.35;">
                        {{ $account->name }}
                    </h1>

                    <!-- Box Harga -->
                    <div class="bg-black bg-opacity-40 p-3 rounded-3 border border-secondary border-opacity-25 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="text-muted small fw-bold text-uppercase mb-1" style="font-size: 0.68rem;">Harga Penawaran</div>
                            <div class="d-flex align-items-baseline gap-3 flex-wrap">
                                <span class="price-tag">Rp {{ number_format($account->price ?? 0, 0, ',', '.') }}</span>
                                @if(isset($account->old_price) && $account->old_price > $account->price)
                                    <span class="old-price">Rp {{ number_format($account->old_price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Spesifikasi Game (Diperbaiki agar teks panjang wrap ke bawah, tidak terpotong) -->
                    <div class="section-title">Spesifikasi Detail</div>
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-md-3">
                            <div class="spec-box">
                                <div class="spec-title"><i class="fa-solid fa-trophy text-warning me-1"></i> Rank</div>
                                <div class="spec-val text-warning" title="{{ $account->rank ?? '-' }}">{{ $account->rank ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="spec-box">
                                <div class="spec-title"><i class="fa-solid fa-shield-halved text-info me-1"></i> Login Via</div>
                                <div class="spec-val text-info" title="{{ $account->login_via ?? '-' }}">{{ $account->login_via ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="spec-box">
                                <div class="spec-title"><i class="fa-solid fa-shirt text-danger me-1"></i> Skin</div>
                                <div class="spec-val text-white">{{ $account->skin_count ?? '0' }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="spec-box">
                                <div class="spec-title"><i class="fa-solid fa-user-ninja text-success me-1"></i> Hero</div>
                                <div class="spec-val text-white">{{ $account->hero_count ?? '0' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Emblem -->
                    @if(!empty($account->emblem))
                        <div class="mb-3">
                            <div class="section-title">Emblem</div>
                            <div class="text-light bg-dark bg-opacity-60 px-3 py-2.5 rounded-3 border border-secondary border-opacity-25 small" style="word-break: break-word;">
                                <i class="fa-solid fa-medal text-warning me-2"></i> {{ $account->emblem }}
                            </div>
                        </div>
                    @endif

                    <!-- Deskripsi / Catatan -->
                    <div class="mb-4">
                        <div class="section-title">Deskripsi & Catatan</div>
                        <div class="text-light bg-dark bg-opacity-60 p-3 rounded-3 border border-secondary border-opacity-25 small" style="white-space: pre-line; line-height: 1.6; max-height: 140px; overflow-y: auto;">
                            {{ $account->description ?? $account->minus ?? 'Akun aman, data lengkap siap amankan, bergaransi toko.' }}
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi WhatsApp (Nego & Beli) -->
                @php
                    $rawAdminAkun = isset($adminWaAkun) ? $adminWaAkun : (\App\Models\Setting::where('key', 'wa_admin_akun')->value('value') ?? '6285718447963');
                    $cleanAdminAkun = preg_replace('/\D+/', '', trim($rawAdminAkun));
                    if (str_starts_with($cleanAdminAkun, '0')) {
                        $cleanAdminAkun = '62' . substr($cleanAdminAkun, 1);
                    } elseif (!str_starts_with($cleanAdminAkun, '62') && strlen($cleanAdminAkun) >= 10) {
                        $cleanAdminAkun = '62' . $cleanAdminAkun;
                    }

                    $accName = $account->name ?? 'Akun Game';
                    $accCode = $account->code ?? $account->id;
                    $accPrice = number_format($account->price ?? 0, 0, ',', '.');

                    $pesanBeli = "Halo Admin ManChi, saya tertarik untuk membeli akun ini:\n\n- Kode Akun: {$accCode}\n- Nama Akun: {$accName}\n- Harga: Rp {$accPrice}\n\nMohon info ketersediaan stok dan proses transaksi selanjutnya ya.";
                    $pesanNego = "Halo Admin ManChi, saya ingin menanyakan penawaran / negosiasi harga untuk akun berikut:\n\n- Kode Akun: {$accCode}\n- Nama Akun: {$accName}\n- Harga Normal: Rp {$accPrice}\n\nApakah bisa kurang, Kak?";

                    $urlBeli = "https://wa.me/{$cleanAdminAkun}?text=" . urlencode($pesanBeli);
                    $urlNego = "https://wa.me/{$cleanAdminAkun}?text=" . urlencode($pesanNego);
                @endphp

                <div class="row g-2 mt-auto pt-3 border-top border-secondary border-opacity-25">
                    <div class="col-6">
                        <a href="{{ $urlNego }}" target="_blank" class="btn btn-nego-wa w-100 shadow-sm d-flex align-items-center justify-content-center text-truncate">
                            <i class="fa-solid fa-handshake me-2 fs-6"></i> <span>Nego Harga</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ $urlBeli }}" target="_blank" class="btn btn-buy-wa w-100 shadow-sm d-flex align-items-center justify-content-center text-truncate">
                            <i class="fa-brands fa-whatsapp me-2 fs-5"></i> <span>Beli Sekarang</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection