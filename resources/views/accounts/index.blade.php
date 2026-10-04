@extends('layouts.market')

@section('content')
<style>
    /* Styling & Variabel Tema Marketplace */
    :root {
        --card-bg-start: #162238;
        --card-bg-end: #0f1728;
        --border-color: #20335e;
    }

    /* Konsistensi Logo Store Presisi dengan .mc-logo */
    .mc-logo {
        width: 65px;
        height: 65px;
        min-width: 65px;
        min-height: 65px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #0b1320;
        box-shadow: 0 0 20px rgba(0, 210, 255, 0.45);
        border: 2px solid #00d2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    
    .mc-logo:hover {
        transform: scale(1.05);
    }

    .mc-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    /* Google-Like Clean Search Bar Minimalis */
    .google-search-container {
        position: relative;
        display: flex;
        align-items: center;
        background: rgba(11, 19, 32, 0.6);
        border: 1px solid rgba(0, 210, 255, 0.25);
        border-radius: 50px;
        padding: 4px 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 220px;
    }

    .google-search-container:focus-within {
        width: 280px;
        background: rgba(11, 19, 32, 0.95);
        border-color: #00d2ff;
        box-shadow: 0 0 15px rgba(0, 210, 255, 0.25);
    }

    .google-search-input {
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        font-size: 0.82rem;
        padding: 4px 8px;
        box-shadow: none !important;
        width: 100%;
    }

    .google-search-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .google-search-btn {
        background: transparent;
        border: none;
        color: #00d2ff;
        padding: 2px 6px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .google-search-btn:hover {
        transform: scale(1.1);
    }

    .pointgamers-card {
        background: linear-gradient(180deg, var(--card-bg-start) 0%, var(--card-bg-end) 100%);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .pointgamers-card:hover {
        border-color: #00d2ff;
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 210, 255, 0.15);
    }

    .badge-new {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #000;
        font-weight: 800;
        font-size: 0.68rem;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 0.5px;
    }

    .badge-nego {
        background: rgba(255, 152, 0, 0.15);
        color: #ffb74d;
        border: 1px solid rgba(255, 152, 0, 0.3);
        font-weight: 700;
        font-size: 0.68rem;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .price-tag {
        font-size: 1.35rem;
        font-weight: 800;
        color: #ffeb3b;
        letter-spacing: -0.5px;
    }

    .spec-box {
        background: rgba(8, 12, 20, 0.6);
        border-top: 1px solid var(--border-color);
        padding: 12px 14px;
    }

    .spec-item {
        text-align: center;
    }

    .spec-val {
        font-size: 0.82rem;
        font-weight: 700;
        color: #ffffff;
    }

    /* Kustomisasi Header Banner */
    .market-header-banner {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #415a77 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
    }

    @media (max-width: 768px) {
        .market-header-banner {
            padding: 1.25rem !important;
        }
        .google-search-container {
            width: 170px;
        }
        .google-search-container:focus-within {
            width: 100%;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    
    <!-- Top Bar / Navigasi Header Clean & Modern -->
    <div class="market-header-banner shadow-lg mb-4 p-3 p-md-4 text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            
            <!-- Bagian Kiri: Logo & Identitas Toko -->
            <div class="d-flex align-items-center gap-3">
                <div class="mc-logo">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo ManchiStore"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/300/0b1320/00d2ff?text=MANCHI';">
                </div>
                
                <div>
                    <h4 class="fw-bold m-0 text-white d-flex align-items-center gap-2" style="font-size: 1.15rem;">
                        @MANCHISTORE <i class="fa-solid fa-circle-check text-info fs-6" title="Verified Store"></i>
                    </h4>
                    <p class="text-light text-opacity-75 small mb-0 mt-1 d-none d-sm-block">manchistore.com • Pusat jual beli akun game terpercaya, aman & bergaransi.</p>
                </div>
            </div>

            <!-- Bagian Kanan: Google-Style Search Bar Minimalis & Badge Keamanan -->
            <div class="d-flex align-items-center flex-wrap gap-2 ms-auto justify-content-end">
                
                <!-- Search Bar Ala Google -->
                <div class="google-search-container shadow-sm">
                    <form action="{{ route('akun.index') }}" method="GET" class="d-flex align-items-center w-100">
                        <button type="submit" class="google-search-btn" title="Cari">
                            <i class="fa-solid fa-magnifying-glass" style="font-size: 0.8rem;"></i>
                        </button>
                        <input type="text" name="keyword" class="google-search-input" placeholder="Cari akun..." value="{{ request('keyword') }}">
                        
                        @if(request('keyword'))
                            <a href="{{ route('akun.index') }}" class="text-secondary text-decoration-none px-1" title="Reset Pencarian">
                                <i class="fa-solid fa-xmark" style="font-size: 0.85rem;"></i>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Badge Keamanan -->
                <span class="badge bg-dark bg-opacity-50 text-light px-3 py-2 border border-light border-opacity-10 rounded-pill d-none.lg-flex align-items-center gap-1" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-shield-halved text-warning"></i> <span class="d-none d-xl-inline">100% Aman</span>
                </span>
            </div>

        </div>
    </div>

    <!-- Grid Katalog Akun Style PointGamers -->
    @if($accounts->count() > 0)
        <div class="row g-3 g-md-4">
            @foreach($accounts as $acc)
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="pointgamers-card h-100 d-flex flex-column position-relative shadow-sm">
                    
                    <!-- Banner Atas Card -->
                    <div class="d-flex justify-content-between align-items-center px-2.5 py-2 bg-dark bg-opacity-80 border-bottom border-secondary border-opacity-10">
                        <span class="badge-new">NEW</span>
                        <span class="badge bg-secondary bg-opacity-25 text-info fw-bold px-2 py-1" style="font-size: 0.65rem;">
                            {{ $acc->code ?? 'ID: ' . $acc->id }}
                        </span>
                    </div>

                    <!-- Poster / Screenshot Utama Akun -->
                    <div class="position-relative bg-black" style="height: 180px; overflow: hidden;">
                        @php
                            $imgPath = $acc->thumbnail ?? $acc->image ?? '';
                        @endphp
                        <img src="{{ $imgPath ? asset('storage/' . $imgPath) : 'https://via.placeholder.com/400x250/121824/00d2ff?text=ManchiStore' }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.4s ease;" alt="{{ $acc->name }}" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        
                        <span class="position-absolute bottom-0 start-0 m-2 badge bg-success bg-opacity-90 backdrop-blur shadow-sm px-2 py-1" style="font-size: 0.6rem;">
                            <i class="fa-solid fa-circle text-white me-1" style="font-size: 0.4rem;"></i> {{ ucfirst($acc->status ?? 'Ready') }}
                        </span>
                    </div>

                    <!-- Informasi Harga & Judul -->
                    <div class="p-2 p-md-3 text-center">
                        <div class="mb-1">
                            <span class="badge-nego">BISA NEGO</span>
                        </div>
                        <div class="price-tag mb-1" style="font-size: 1.15rem;">
                            Rp {{ number_format($acc->price ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="text-truncate text-light small mb-1 px-1 fw-semibold opacity-75" style="font-size: 0.8rem;" title="{{ $acc->name }}">
                            {{ $acc->name }}
                        </div>
                    </div>

                    <!-- Kotak Spesifikasi Bawah (Clean Grid) -->
                    <div class="spec-box mt-auto">
                        <div class="row g-1 text-center mb-2 mb-md-3">
                            <div class="col-3 spec-item border-end border-secondary border-opacity-10">
                                <div class="text-muted text-uppercase" style="font-size: 0.52rem; letter-spacing: 0.5px;">Skin</div>
                                <div class="spec-val text-info mt-1" style="font-size: 0.75rem;">{{ $acc->skin_count ?? '-' }}</div>
                            </div>
                            <div class="col-3 spec-item border-end border-secondary border-opacity-10">
                                <div class="text-muted text-uppercase" style="font-size: 0.52rem; letter-spacing: 0.5px;">Hero</div>
                                <div class="spec-val text-success mt-1" style="font-size: 0.75rem;">{{ $acc->hero_count ?? '-' }}</div>
                            </div>
                            <div class="col-3 spec-item border-end border-secondary border-opacity-10">
                                <div class="text-muted text-uppercase" style="font-size: 0.52rem; letter-spacing: 0.5px;">Rank</div>
                                <div class="spec-val text-warning text-truncate px-1 mt-1" style="font-size: 0.75rem;" title="{{ $acc->rank ?? 'Epic' }}">{{ $acc->rank ?? 'Epic' }}</div>
                            </div>
                            <div class="col-3 spec-item">
                                <div class="text-muted text-uppercase" style="font-size: 0.52rem; letter-spacing: 0.5px;">Emblem</div>
                                <div class="spec-val text-light mt-1" style="font-size: 0.75rem;">{{ $acc->emblem ?? 'MAX' }}</div>
                            </div>
                        </div>

                        <!-- Tombol Aksi Detail -->
                        <a href="{{ route('akun.show', $acc->slug ?? $acc->id) }}" class="btn btn-primary btn-sm w-100 fw-bold py-1.5 py-md-2 shadow-sm rounded-2 text-white d-flex align-items-center justify-content-center gap-1" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border: none; font-size: 0.73rem;">
                            <i class="fa-solid fa-eye"></i> DETAIL AKUN
                        </a>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 mt-md-5">
            {{ $accounts->withQueryString()->links() }}
        </div>
    @else
        <!-- Empty State (Clean UI) -->
        <div class="text-center py-5 my-4 bg-dark border border-secondary border-opacity-25 rounded-4 p-4 p-md-5 shadow-sm">
            <div class="mb-3 text-secondary opacity-50">
                <i class="fa-solid fa-folder-open display-3"></i>
            </div>
            <h4 class="fw-bold text-white fs-5 fs-md-4">Stok Akun Game Sedang Kosong</h4>
            <p class="text-secondary small mb-4 mx-auto" style="max-width: 400px;">
                @if(request('keyword'))
                    Tidak ada akun game yang cocok dengan kata kunci pencarian <b>"{{ request('keyword') }}"</b>. Coba kata kunci lain.
                @else
                    Stok akun pilihan belum tersedia saat ini di etalase. Silakan hubungi admin untuk konfirmasi ketersediaan.
                @endif
            </p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                @if(request('keyword'))
                    <a href="{{ route('akun.index') }}" class="btn btn-outline-light rounded-pill px-4 py-2 text-sm fw-semibold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Reset Pencarian
                    </a>
                @endif
                <a href="{{ $waAdminUrl ?? '#' }}" target="_blank" class="btn btn-success fw-bold rounded-pill px-4 py-2 text-sm shadow-sm">
                    <i class="fa-brands fa-whatsapp me-2"></i>Tanya Admin Via WhatsApp
                </a>
            </div>
        </div>
    @endif
</div>
@endsection