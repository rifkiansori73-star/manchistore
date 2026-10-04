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

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 font-weight-bold text-primary fw-bold">Setting Tarif Joki (Per Bintang / Point)</h6>
            
            <div class="d-flex gap-2">
                @if($rates->isEmpty())
                    <form action="{{ route('admin.joki.seed') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>Generate Tarif Default
                        </button>
                    </form>
                @endif
                <button type="button" class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addRateModal">
                    <i class="fa-solid fa-plus me-1"></i>Tambah Tarif Rank
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.joki.update') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tipe Joki</th>
                                <th>Nama Rank / Tier</th>
                                <th>Harga Per Bintang / Point (Rp)</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rates as $rate)
                            <tr>
                                <td>
                                    @if($rate->type === 'gendong')
                                        <span class="badge bg-primary px-2 py-1">Joki Gendong</span>
                                    @else
                                        <span class="badge bg-info text-dark px-2 py-1">Regular Joki</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" 
                                           name="rates[{{ $rate->id }}][rank_name]" 
                                           class="form-control form-control-sm fw-bold w-auto" 
                                           value="{{ $rate->rank_name }}" required>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm" style="max-width: 250px;">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               name="rates[{{ $rate->id }}][price_per_star]" 
                                               class="form-control" 
                                               value="{{ (int)$rate->price_per_star }}" 
                                               required>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteRate('{{ route('admin.joki.destroy', $rate->id) }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="fa-solid fa-folder-open fa-2x opacity-50"></i></div>
                                    <div>Belum ada data tarif di database.</div>
                                    <small class="text-secondary">Klik tombol <strong>"Generate Tarif Default"</strong> di atas untuk membuat data otomatis.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($rates->count() > 0)
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-success fw-bold px-4">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan Tarif
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH TARIF BARU -->
<div class="modal fade" id="addRateModal" tabindex="-1" aria-labelledby="addRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="addRateModalLabel"><i class="fa-solid fa-plus me-2"></i>Tambah Tarif Rank Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.joki.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe Joki <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="biasa">Regular Joki (Biasa)</option>
                            <option value="gendong">Joki Gendong / Mabar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Rank / Tier <span class="text-danger">*</span></label>
                        <input type="text" name="rank_name" class="form-control" placeholder="Contoh: Epic, Legend, Mythic" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga Per Bintang / Point (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price_per_star" class="form-control" placeholder="Contoh: 5000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FORM HIDDEN UNTUK DELETE -->
<form id="deleteRateForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteRate(url) {
        if (confirm('Apakah Anda yakin ingin menghapus tarif rank ini?')) {
            let form = document.getElementById('deleteRateForm');
            form.action = url;
            form.submit();
        }
    }
</script>
@endsection