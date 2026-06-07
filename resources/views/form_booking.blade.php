<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking - {{ $studio->nama_studio }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
                <i class="fa-solid fa-guitar me-2"></i> MNC Studios Booking
            </a>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 650px;">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-success text-white text-center py-4 rounded-top-3">
                <i class="fa-solid fa-calendar-days fa-2x mb-2"></i>
                <h3 class="mb-0 fw-bold">Form Booking Studio</h3>
                <p class="mb-0 text-white-50">{{ $studio->nama_studio }} — {{ $studio->lokasi }}</p>
            </div>

            <div class="card-body p-4">
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div id="jsErrorAlert" class="alert alert-warning d-none shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> <span id="jsErrorMessage"></span>
                </div>

                <form action="{{ url('/booking') }}" method="POST" id="bookingForm">
                    @csrf
                    
                    <input type="hidden" name="studio_id" value="{{ $studio->id }}">

                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" required placeholder="Masukkan nama lengkap Anda">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="waktu_mulai" class="form-label fw-semibold text-dark">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="waktu_selesai" class="form-label fw-semibold text-dark">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keperluan" class="form-label fw-semibold text-dark">Keperluan / Acara</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" rows="3" required placeholder="Contoh: Latihan Band, Rekaman Voice Over, dll">{{ old('keperluan') }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm fw-bold">
                            <i class="fa-solid fa-circle-check me-2"></i>Konfirmasi Booking
                        </button>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const form = document.getElementById('bookingForm');
        const waktuMulaiInput = document.getElementById('waktu_mulai');
        const waktuSelesaiInput = document.getElementById('waktu_selesai');
        const errorAlert = document.getElementById('jsErrorAlert');
        const errorMessage = document.getElementById('jsErrorMessage');

        form.addEventListener('submit', function(event) {
            let mulai = new Date(waktuMulaiInput.value);
            let selesai = new Date(waktuSelesaiInput.value);
            let sekarang = new Date();

            // Sembunyikan alert sebelum validasi ulang
            errorAlert.classList.add('d-none');

            // Logika 1: Mencegah waktu selesai mendahului waktu mulai
            if (selesai <= mulai) {
                event.preventDefault(); 
                errorMessage.textContent = "Waktu Selesai tidak boleh mendahului atau sama dengan Waktu Mulai!";
                errorAlert.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' }); 
                return false;
            }

            // Logika 2: Mencegah pemesanan di waktu masa lalu
            if (mulai < sekarang) {
                event.preventDefault();
                errorMessage.textContent = "Anda tidak bisa memesan studio di waktu masa lalu!";
                errorAlert.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return false;
            }
        });
    </script>
</body>
</html>