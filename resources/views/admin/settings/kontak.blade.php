@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <!-- Header Page -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Setting WhatsApp Admin</h4>
            <p class="text-secondary small mb-0">Kelola nomor komunikasi WhatsApp resmi untuk layanan joki dan jual beli akun game.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check text-success fs-5 me-2"></i>
                <div class="small fw-medium">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Konfigurasi Nomor Kontak</h6>
                        <span class="text-secondary" style="font-size: 0.78rem;">Format nomor menggunakan awalan internasional (Contoh: 62...)</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.kontak.update') }}" method="POST">
                        @csrf
                        
                        <!-- Admin 1: Admin Joki -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold text-dark mb-0">Admin 1 (Admin Joki)</label>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1" style="font-size: 0.7rem;">Khusus Layanan Joki</span>
                            </div>
                            <input type="text" name="wa_admin_joki" class="form-control bg-light py-2.5 px-3" value="{{ old('wa_admin_joki', $waAdminJoki) }}" placeholder="6285718447963" required style="font-size: 0.95rem;">
                            <div class="form-text text-secondary mt-1" style="font-size: 0.78rem;">
                                Digunakan otomatis pada tombol Card <b>Order Jasa Joki Game</b> & <b>Jasa Joki Gendong</b>.
                            </div>
                        </div>

                        <hr class="text-secondary opacity-25 my-4">

                        <!-- Admin 2: Admin Jual Beli Akun -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold text-dark mb-0">Admin 2 (Admin Jual Beli Akun)</label>
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1" style="font-size: 0.7rem;">Khusus Katalog & Akun</span>
                            </div>
                            <input type="text" name="wa_admin_akun" class="form-control bg-light py-2.5 px-3" value="{{ old('wa_admin_akun', $waAdminAkun) }}" placeholder="6281234567890" required style="font-size: 0.95rem;">
                            <div class="form-text text-secondary mt-1" style="font-size: 0.78rem;">
                                Digunakan otomatis pada tombol Card <b>Katalog Stok Akun Game</b> & <b>Jual Akun Game Kamu</b>.
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-2">
                            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background-color: #4f46e5; border-color: #4f46e5;">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection