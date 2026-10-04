@extends('layouts.app')

@section('content')
<style>
    .order-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid {{ $type === 'gendong' ? '#a855f7' : '#00d2ff' }};
        border-radius: 16px;
        backdrop-filter: blur(10px);
    }
    .avatar-glow {
        box-shadow: 0 0 20px {{ $type === 'gendong' ? 'rgba(168, 85, 247, 0.5)' : 'rgba(0, 210, 255, 0.5)' }};
        border: 2px solid {{ $type === 'gendong' ? '#a855f7' : '#00d2ff' }} !important;
    }
    .form-control, .form-select {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: {{ $type === 'gendong' ? '#a855f7' : '#00d2ff' }} !important;
        box-shadow: 0 0 10px {{ $type === 'gendong' ? 'rgba(168, 85, 247, 0.4)' : 'rgba(0, 210, 255, 0.4)' }} !important;
    }
    .form-select option {
        background-color: #121824;
        color: #fff;
    }

    /* Menghilangkan tombol panah naik/turun (spinner) pada input number */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div class="container my-4" style="max-width: 600px;">
    <div class="order-card p-4 text-white">
        
        <!-- Header Dynamic dengan Logo Utama Manchi Store -->
        <div class="text-center mb-4">
            <div class="mb-2">
                <img src="{{ asset('img/logo.jpg') }}" alt="Manchi Store Logo" class="rounded-circle avatar-glow" style="width: 65px; height: 65px; object-fit: cover;">
            </div>
            @if($type === 'gendong')
                <span class="badge bg-primary text-white mb-2 px-3 py-1" style="background-color: #a855f7 !important;">JOKI GENDONG / MABAR MODE</span>
                <h4 class="fw-bold text-white mb-1">Form Order Joki Gendong</h4>
                <p class="text-light opacity-75 small">Main bareng Pro Player, akun tetap aman di tanganmu</p>
            @else
                <span class="badge bg-warning text-dark mb-2 px-3 py-1">REGULAR JOKI</span>
                <h4 class="fw-bold text-info mb-1">Form Order Joki Rank</h4>
                <p class="text-secondary small">Serahkan akun ke penjoki, diproses cepat & bergaransi</p>
            @endif
        </div>

        <form id="jokiForm" onsubmit="event.preventDefault(); sendToWhatsapp();">
            <!-- 1. Data Diri Customer -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold text-light">Username / Nickname MLBB</label>
                    <input type="text" id="nickname" class="form-control" placeholder="Contoh: ManChi Pro" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold text-light">Nomor WhatsApp Active</label>
                    <input type="text" inputmode="numeric" id="no_hp" class="form-control" placeholder="085712345678" required>
                </div>
            </div>

            <hr class="border-secondary opacity-25 my-2">

            <!-- 2. Pilihan Target Rank Awal -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold text-light">Rank Saat Ini</label>
                    <select id="rank_awal" class="form-select" onchange="updateStarOptions('awal'); calculatePrice();" required>
                        <optgroup label="Warrior">
                            <option value="Warrior III">Warrior III</option>
                            <option value="Warrior II">Warrior II</option>
                            <option value="Warrior I">Warrior I</option>
                        </optgroup>
                        <optgroup label="Elite">
                            <option value="Elite III">Elite III</option>
                            <option value="Elite II">Elite II</option>
                            <option value="Elite I">Elite I</option>
                        </optgroup>
                        <optgroup label="Master">
                            <option value="Master IV">Master IV</option>
                            <option value="Master III">Master III</option>
                            <option value="Master II">Master II</option>
                            <option value="Master I">Master I</option>
                        </optgroup>
                        <optgroup label="Grandmaster">
                            <option value="Grandmaster V">Grandmaster V</option>
                            <option value="Grandmaster IV">Grandmaster IV</option>
                            <option value="Grandmaster III">Grandmaster III</option>
                            <option value="Grandmaster II">Grandmaster II</option>
                            <option value="Grandmaster I">Grandmaster I</option>
                        </optgroup>
                        <optgroup label="Epic">
                            <option value="Epic V">Epic V</option>
                            <option value="Epic IV">Epic IV</option>
                            <option value="Epic III">Epic III</option>
                            <option value="Epic II">Epic II</option>
                            <option value="Epic I">Epic I</option>
                        </optgroup>
                        <optgroup label="Legend">
                            <option value="Legend V">Legend V</option>
                            <option value="Legend IV">Legend IV</option>
                            <option value="Legend III">Legend III</option>
                            <option value="Legend II">Legend II</option>
                            <option value="Legend I">Legend I</option>
                        </optgroup>
                        <optgroup label="Mythic">
                            <option value="Mythic">Mythic</option>
                            <option value="Mythic Honor">Mythic Honor</option>
                            <option value="Mythic Glory">Mythic Glory</option>
                            <option value="Mythic Immortal">Mythic Immortal</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold text-light">Bintang / Point Awal</label>
                    <div id="container_star_awal">
                        <select id="star_awal" class="form-select" onchange="calculatePrice()" required></select>
                    </div>
                </div>
            </div>

            <!-- Pilihan Target Rank Tujuan -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold text-light">Rank Tujuan</label>
                    <select id="rank_tujuan" class="form-select" onchange="updateStarOptions('tujuan'); calculatePrice();" required>
                        <optgroup label="Warrior">
                            <option value="Warrior III">Warrior III</option>
                            <option value="Warrior II">Warrior II</option>
                            <option value="Warrior I">Warrior I</option>
                        </optgroup>
                        <optgroup label="Elite">
                            <option value="Elite III">Elite III</option>
                            <option value="Elite II">Elite II</option>
                            <option value="Elite I">Elite I</option>
                        </optgroup>
                        <optgroup label="Master">
                            <option value="Master IV">Master IV</option>
                            <option value="Master III">Master III</option>
                            <option value="Master II">Master II</option>
                            <option value="Master I">Master I</option>
                        </optgroup>
                        <optgroup label="Grandmaster">
                            <option value="Grandmaster V">Grandmaster V</option>
                            <option value="Grandmaster IV">Grandmaster IV</option>
                            <option value="Grandmaster III">Grandmaster III</option>
                            <option value="Grandmaster II">Grandmaster II</option>
                            <option value="Grandmaster I">Grandmaster I</option>
                        </optgroup>
                        <optgroup label="Epic">
                            <option value="Epic V">Epic V</option>
                            <option value="Epic IV">Epic IV</option>
                            <option value="Epic III">Epic III</option>
                            <option value="Epic II">Epic II</option>
                            <option value="Epic I">Epic I</option>
                        </optgroup>
                        <optgroup label="Legend">
                            <option value="Legend V">Legend V</option>
                            <option value="Legend IV" selected>Legend IV</option>
                            <option value="Legend III">Legend III</option>
                            <option value="Legend II">Legend II</option>
                            <option value="Legend I">Legend I</option>
                        </optgroup>
                        <optgroup label="Mythic">
                            <option value="Mythic">Mythic</option>
                            <option value="Mythic Honor">Mythic Honor</option>
                            <option value="Mythic Glory">Mythic Glory</option>
                            <option value="Mythic Immortal">Mythic Immortal</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold text-light">Bintang / Point Tujuan</label>
                    <div id="container_star_tujuan">
                        <select id="star_tujuan" class="form-select" onchange="calculatePrice()" required></select>
                    </div>
                </div>
            </div>

            <!-- 3. Request Hero & Catatan -->
            <div class="mb-3">
                <label class="form-label small fw-semibold text-light">Request Hero (Opsional)</label>
                <input type="text" id="request_hero" class="form-control" placeholder="Contoh: Ling, Yi Shun shin, Fanny">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold text-light">Catatan / Jam Main Request</label>
                <textarea id="catatan" class="form-control" rows="2" placeholder="Contoh: Main jam 8 malam ke atas"></textarea>
            </div>

            <!-- Total Estimasi Harga -->
            <div class="p-3 mb-4 rounded bg-dark border text-center {{ $type === 'gendong' ? 'border-primary' : 'border-info' }}">
                <div class="small text-secondary">Estimasi Total Biaya:</div>
                <div id="total_price_display" class="fs-4 fw-bold text-warning">Rp 0</div>
            </div>

            <!-- Tombol Kirim WA -->
            <button type="submit" id="btnSubmit" class="btn {{ $type === 'gendong' ? 'btn-primary' : 'btn-info' }} w-100 fw-bold py-2 text-dark" style="{{ $type === 'gendong' ? 'background-color: #a855f7 !important; border-color: #a855f7 !important; color: #fff !important;' : '' }}">
                <i class="fa-brands fa-whatsapp me-2"></i>Order Sekarang via WhatsApp
            </button>
        </form>

    </div>
</div>

<script>
    // Data rate per bintang dari Database (disinkronkan dengan key database)
    const dbRates = @json($rankRates);

    // Konfigurasi Rentang Bintang / Point per Tier & Offset Kumulatif Total
    const tierConfig = {
        'Warrior III': { minStars: 1, maxStars: 3, offset: 0,   mainRank: 'Warrior' },
        'Warrior II':  { minStars: 1, maxStars: 3, offset: 3,   mainRank: 'Warrior' },
        'Warrior I':   { minStars: 1, maxStars: 3, offset: 6,   mainRank: 'Warrior' },

        'Elite III':   { minStars: 1, maxStars: 4, offset: 9,   mainRank: 'Elite' },
        'Elite II':    { minStars: 1, maxStars: 4, offset: 13,  mainRank: 'Elite' },
        'Elite I':     { minStars: 1, maxStars: 4, offset: 17,  mainRank: 'Elite' },

        'Master IV':   { minStars: 1, maxStars: 4, offset: 21,  mainRank: 'Master' },
        'Master III':  { minStars: 1, maxStars: 4, offset: 25,  mainRank: 'Master' },
        'Master II':   { minStars: 1, maxStars: 4, offset: 29,  mainRank: 'Master' },
        'Master I':    { minStars: 1, maxStars: 4, offset: 33,  mainRank: 'Master' },

        'Grandmaster V':   { minStars: 1, maxStars: 5, offset: 37, mainRank: 'Grandmaster' },
        'Grandmaster IV':  { minStars: 1, maxStars: 5, offset: 42, mainRank: 'Grandmaster' },
        'Grandmaster III': { minStars: 1, maxStars: 5, offset: 47, mainRank: 'Grandmaster' },
        'Grandmaster II':  { minStars: 1, maxStars: 5, offset: 52, mainRank: 'Grandmaster' },
        'Grandmaster I':   { minStars: 1, maxStars: 5, offset: 57, mainRank: 'Grandmaster' },

        'Epic V':   { minStars: 1, maxStars: 5, offset: 62,  mainRank: 'Epic' },
        'Epic IV':  { minStars: 1, maxStars: 5, offset: 67,  mainRank: 'Epic' },
        'Epic III': { minStars: 1, maxStars: 5, offset: 72,  mainRank: 'Epic' },
        'Epic II':  { minStars: 1, maxStars: 5, offset: 77,  mainRank: 'Epic' },
        'Epic I':   { minStars: 1, maxStars: 5, offset: 82,  mainRank: 'Epic' },

        'Legend V':   { minStars: 1, maxStars: 5, offset: 87,  mainRank: 'Legend' },
        'Legend IV':  { minStars: 1, maxStars: 5, offset: 92,  mainRank: 'Legend' },
        'Legend III': { minStars: 1, maxSatrs: 5, offset: 97,  mainRank: 'Legend' },
        'Legend II':  { minStars: 1, maxStars: 5, offset: 102, mainRank: 'Legend' },
        'Legend I':   { minStars: 1, maxStars: 5, offset: 107, mainRank: 'Legend' },

        'Mythic':          { minStars: 1,   maxStars: 24, offset: 112, mainRank: 'Mythic' },
        'Mythic Honor':    { minStars: 25,  maxStars: 49, offset: 112, mainRank: 'Mythic Honor' },
        'Mythic Glory':    { minStars: 50,  maxStars: 99, offset: 112, mainRank: 'Mythic Glory' },
        'Mythic Immortal': { minStars: 100, maxStars: null, offset: 112, mainRank: 'Mythic Immortal' }
    };

    function updateStarOptions(type) {
        let selectedTier = document.getElementById('rank_' + type).value;
        let config = tierConfig[selectedTier];
        let container = document.getElementById('container_star_' + type);

        if (!config) return;

        if (selectedTier === 'Mythic Immortal') {
            container.innerHTML = `
                <input type="number" id="star_${type}" class="form-control" 
                       min="100" value="100" placeholder="Masukkan Point (min 100)" 
                       oninput="calculatePrice()" required>
            `;
        } else {
            let unit = config.mainRank.includes('Mythic') ? 'Point' : 'Bintang';
            let optionsHTML = '';

            for (let i = config.minStars; i <= config.maxStars; i++) {
                // Format diubah menjadi: Bintang 1, Point 1, dst.
                optionsHTML += `<option value="${i}">${unit} ${i}</option>`;
            }

            container.innerHTML = `
                <select id="star_${type}" class="form-select" onchange="calculatePrice()" required>
                    ${optionsHTML}
                </select>
            `;
        }
    }

    function getPriceForCumulativeStar(starIndex) {
        // Mengambil langsung dari variabel dbRates yang dikirim controller, dengan fallback aman
        if (starIndex < 9)   return dbRates['Warrior']         ?? dbRates['Warrior III']         ?? 1000;
        if (starIndex < 21)  return dbRates['Elite']           ?? dbRates['Elite III']           ?? 1500;
        if (starIndex < 37)  return dbRates['Master']          ?? dbRates['Master IV']           ?? 2000;
        if (starIndex < 62)  return dbRates['Grandmaster']     ?? dbRates['Grandmaster V']       ?? 3000;
        if (starIndex < 87)  return dbRates['Epic']            ?? dbRates['Epic V']              ?? 4000;
        if (starIndex < 112) return dbRates['Legend']          ?? dbRates['Legend V']            ?? 5000;
        if (starIndex < 136) return dbRates['Mythic']          ?? 8000;
        if (starIndex < 161) return dbRates['Mythic Honor']    ?? 10000;
        if (starIndex < 212) return dbRates['Mythic Glory']    ?? 13000;
        return dbRates['Mythic Immortal'] ?? 18000;
    }

    function calculatePrice() {
        let rankAwal = document.getElementById('rank_awal').value;
        let rankTujuan = document.getElementById('rank_tujuan').value;

        let starAwalInput = document.getElementById('star_awal');
        let starTujuanInput = document.getElementById('star_tujuan');

        let starAwal = parseInt(starAwalInput ? starAwalInput.value : 1) || 1;
        let starTujuan = parseInt(starTujuanInput ? starTujuanInput.value : 1) || 1;

        let configAwal = tierConfig[rankAwal];
        let configTujuan = tierConfig[rankTujuan];

        if (!configAwal || !configTujuan) return 0;

        let startCumulative = 0;
        if (configAwal.mainRank.includes('Mythic')) {
            startCumulative = configAwal.offset + starAwal - 1;
        } else {
            startCumulative = configAwal.offset + (starAwal - 1);
        }

        let endCumulative = 0;
        if (configTujuan.mainRank.includes('Mythic')) {
            endCumulative = configTujuan.offset + starTujuan - 1;
        } else {
            endCumulative = configTujuan.offset + (starTujuan - 1);
        }

        let totalPrice = 0;

        if (endCumulative > startCumulative) {
            for (let i = startCumulative; i < endCumulative; i++) {
                totalPrice += getPriceForCumulativeStar(i);
            }
        }

        document.getElementById('total_price_display').innerText = "Rp " + totalPrice.toLocaleString('id-ID');
        return totalPrice;
    }

    async function sendToWhatsapp() {
        let nickname = document.getElementById('nickname').value;
        let noHp = document.getElementById('no_hp').value;
        let rankAwal = document.getElementById('rank_awal').value;
        let starAwalElement = document.getElementById('star_awal');
        let rankTujuan = document.getElementById('rank_tujuan').value;
        let starTujuanElement = document.getElementById('star_tujuan');

        let starAwal = starAwalElement ? starAwalElement.value : '';
        let starTujuan = starTujuanElement ? starTujuanElement.value : '';

        if (!nickname || !noHp) {
            alert('Mohon isi Username MLBB dan Nomor WhatsApp terlebih dahulu!');
            return;
        }

        if (!starAwal || !starTujuan) {
            alert('Mohon lengkapi Point/Bintang terlebih dahulu!');
            return;
        }

        let totalPrice = calculatePrice();
        let reqHero = document.getElementById('request_hero').value || '-';
        let catatan = document.getElementById('catatan').value || '-';

        let btn = document.getElementById('btnSubmit');
        let originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses Pesanan...';

        try {
            let response = await fetch("{{ route('checkout.order') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    service_type: "{{ $type === 'gendong' ? 'JOKI GENDONG / MABAR' : 'JOKI RANK BIASA' }}",
                    nickname: nickname,
                    no_hp: noHp,
                    rank_awal: rankAwal,
                    star_awal: starAwal,
                    rank_tujuan: rankTujuan,
                    star_tujuan: starTujuan,
                    price: totalPrice,
                    request_hero: reqHero,
                    catatan: catatan
                })
            });

            let result = await response.json();

            if (response.ok && result.wa_url) {
                window.location.href = result.wa_url;
            } else {
                alert('Gagal memproses pesanan: ' + (result.message || 'Silakan cek kembali inputan Anda.'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan atau server.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateStarOptions('awal');
        updateStarOptions('tujuan');
        calculatePrice();
    });
</script>
@endsection