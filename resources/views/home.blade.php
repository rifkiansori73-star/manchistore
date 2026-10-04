@extends('layouts.app')

@section('content')
<!-- Custom Style Khusus Halaman Home (Neon Gaming Theme) -->
<style>
    .avatar-glow {
        box-shadow: 0 0 25px rgba(0, 210, 255, 0.45);
        border: 3px solid #00d2ff !important;
        transition: transform 0.3s ease;
    }
    .avatar-glow:hover {
        transform: scale(1.04);
    }
    .social-btn {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(0, 210, 255, 0.2);
        color: #e0e0e0;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .social-btn:hover {
        background: #00d2ff;
        color: #0b0e14;
        box-shadow: 0 0 15px rgba(0, 210, 255, 0.6);
        transform: translateY(-3px);
    }
    .store-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #ffffff;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        backdrop-filter: blur(8px);
    }
    .store-card:hover {
        border-color: #00d2ff;
        background: linear-gradient(135deg, rgba(0, 210, 255, 0.12) 0%, rgba(255,255,255,0.03) 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4), 0 0 15px rgba(0, 210, 255, 0.2);
        color: #ffffff;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .trust-badge {
        background: rgba(0, 210, 255, 0.08);
        border: 1px solid rgba(0, 210, 255, 0.2);
        border-radius: 12px;
        padding: 10px;
    }
    .fs-xs {
        font-size: 0.75rem;
    }
</style>

<!-- Header Profile Store -->
<div class="text-center my-4">
    <!-- Logo Profil Berbingkai Glow Cyan -->
    <div class="mb-3 position-relative d-inline-block">
        <img src="{{ asset('img/logo.jpg') }}" alt="Manchistore Logo" class="rounded-circle avatar-glow" style="width: 110px; height: 110px; object-fit: cover;">
    </div>

    <!-- Title / Brand Identitas -->
    <h4 class="fw-bold text-white mb-1 d-flex align-items-center justify-content-center gap-2">
        @MANCHISTORE <i class="fa-solid fa-circle-check text-info fs-6" title="Official Verified Store"></i>
    </h4>
    <div class="text-info small fw-semibold tracking-wide mb-2">manchistore.com</div>

    <!-- Bio Slogan Ringkas -->
    <p class="text-light small mb-2 px-2" style="max-width: 380px; margin: 0 auto; line-height: 1.5;">
        Layanan Joki Game, Jual Beli Akun, & Rekber Terpercaya<br>
        <span class="text-warning fw-semibold">Proses Cepat • 100% Aman • Garansi Anti-Minus</span>
    </p>

    <div class="text-secondary small mb-3">
        <i class="fa-solid fa-hand-point-down text-info me-1"></i> Pilih layanan di bawah ini
    </div>

    <!-- Social Media Icons Row -->
    <div class="d-flex justify-content-center gap-3 mb-4">
        <a href="https://www.instagram.com/joki_manchistore/?utm_source=ig_web_button_share_sheet" target="_blank" rel="noopener noreferrer" class="social-btn" title="Instagram">
            <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="social-btn" title="YouTube">
            <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://vm.tiktok.com/ZS9ATr3rwv36E-YPXex/" target="_blank" rel="noopener noreferrer" class="social-btn" title="TikTok">
            <i class="fa-brands fa-tiktok"></i>
        </a>
        <!-- Tombol WhatsApp yang terhubung otomatis dengan nomor Admin Joki dari Portal Admin -->
        <a href="{{ $jokiUrl ?? 'https://wa.me/6285718447963' }}" target="_blank" rel="noopener noreferrer" class="social-btn" title="WhatsApp Admin Joki">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>

    <!-- Trust Badge Banner -->
    <div class="trust-badge d-flex justify-content-around text-center mb-4">
        <div>
            <div class="fw-bold text-info small"><i class="fa-solid fa-shield-halved me-1"></i>100% Aman</div>
            <div class="text-secondary fs-xs">Garansi Transaksi</div>
        </div>
        <div class="border-end border-secondary opacity-25"></div>
        <div>
            <div class="fw-bold text-warning small"><i class="fa-solid fa-bolt me-1"></i>Fast Process</div>
            <div class="text-secondary fs-xs">Selesai Tepat Waktu</div>
        </div>
        <div class="border-end border-secondary opacity-25"></div>
        <div>
            <div class="fw-bold text-success small"><i class="fa-solid fa-headset me-1"></i>24/7 Support</div>
            <div class="text-secondary fs-xs">Admin Responsif & Ramah</div>
        </div>
    </div>
</div>

<!-- List Card Utama Micro-Store -->
<div class="mt-2 mb-4">

    <!-- Card 1: Order Joki Biasa / Joki Rank (Admin 1 - Joki) -->
    <a href="{{ route('joki.order', ['type' => 'biasa']) }}" class="store-card">
        <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div class="flex-grow-1">
            <div class="fw-bold text-white mb-0">Order Jasa Joki Game</div>
            <div class="text-secondary small">Joki rank MLBB / Game fast process via Admin Joki</div>
        </div>
        <div class="text-end ms-2">
            <span class="badge bg-warning text-dark small mb-1 d-block">PROMO</span>
            <i class="fa-solid fa-chevron-right text-secondary small"></i>
        </div>
    </a>

    <!-- Card 2: Jasa Joki Gendong / Mabar Bareng Pro Player (Admin 1 - Joki) -->
    <a href="{{ route('joki.order', ['type' => 'gendong']) }}" class="store-card">
        <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
            <i class="fa-solid fa-users-rays"></i>
        </div>
        <div class="flex-grow-1">
            <div class="fw-bold text-white mb-0">Jasa Joki Gendong / Mabar</div>
            <div class="text-secondary small">Mabar bareng pro player, push rank santai & terarah</div>
        </div>
        <div class="text-end ms-2">
            <span class="badge bg-primary text-white small mb-1 d-block">POPULER</span>
            <i class="fa-solid fa-chevron-right text-secondary small"></i>
        </div>
    </a>

    <!-- Card 3: Katalog Stok Akun Game (Halaman Katalog Akun / Market) -->
    <a href="{{ route('akun.index') }}" class="store-card">
        <div class="icon-box bg-info bg-opacity-10 text-info me-3">
            <i class="fa-solid fa-store"></i>
        </div>
        <div class="flex-grow-1">
            <div class="fw-bold text-white mb-0">Katalog Stok Akun Game</div>
            <div class="text-secondary small">Lihat stok akun game pilihan & spesifikasi lengkap</div>
        </div>
        <div class="text-end ms-2">
            <span class="badge bg-info text-dark small mb-1 d-block">Cek Katalog</span>
            <i class="fa-solid fa-chevron-right text-secondary small"></i>
        </div>
    </a>

    <!-- Card 4: Jual Akun Game Kamu (Direct WA Ke Admin 2 - Akun) -->
    <a href="{{ $jualUrl ?? 'https://wa.me/6285718447963' }}" target="_blank" rel="noopener noreferrer" class="store-card">
        <div class="icon-box bg-danger bg-opacity-10 text-danger me-3">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
        <div class="flex-grow-1">
            <div class="fw-bold text-white mb-0">Jual Akun Game Kamu</div>
            <div class="text-secondary small">Tawarkan akun milikmu ke Admin Akun dengan harga bersaing</div>
        </div>
        <div class="text-end ms-2">
            <i class="fa-solid fa-chevron-right text-secondary small"></i>
        </div>
    </a>

    <!-- Card 5: Testimoni & TikTok Official -->
    <a href="{{ $tiktokUrl ?? 'https://tiktok.com' }}" target="_blank" rel="noopener noreferrer" class="store-card">
        <div class="icon-box bg-light bg-opacity-10 text-white me-3">
            <i class="fa-brands fa-tiktok"></i>
        </div>
        <div class="flex-grow-1">
            <div class="fw-bold text-white mb-0">Testimoni & TikTok Official</div>
            <div class="text-secondary small">Cek garansi, hasil pengerjaan & promo di TikTok</div>
        </div>
        <div class="text-end ms-2">
            <i class="fa-solid fa-chevron-right text-secondary small"></i>
        </div>
    </a>

</div>
@endsection