<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking Saya - MNC Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
                <i class="fa-solid fa-guitar me-2"></i> MNC Studios Booking
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white fw-semibold" href="{{ url('/') }}">
                    <i class="fa-solid fa-house me-1"></i> Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Riwayat Booking Saya</h2>
                <p class="text-muted mb-0">Pantau dan kelola jadwal peminjaman studio Anda di sini.</p>
            </div>
            <a href="{{ url('/') }}" class="btn btn-success shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Booking Studio Lagi
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="card border-0 shadow-sm text-center py-5 rounded-3">
                <div class="card-body">
                    <i class="fa-solid fa-calendar-xmark text-muted fa-4x mb-3"></i>
                    <h4 class="fw-bold text-secondary">Belum Ada Booking</h4>
                    <p class="text-muted">Anda belum melakukan pemesanan studio musik apa pun saat ini.</p>
                    <a href="{{ url('/') }}" class="btn btn-outline-success mt-2">Cari Studio Sekarang</a>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($bookings as $booking)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-truncate">
                                    <i class="fa-solid fa-sliders me-2 text-success"></i>{{ $booking->studio->nama_studio }}
                                </span>
                                <span class="badge bg-success">Aktif</span>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.75rem;">Nama Peminjam</small>
                                    <span class="fw-semibold text-dark">{{ $booking->nama_peminjam }}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.75rem;">Jadwal Mulai</small>
                                    <span class="text-dark"><i class="fa-regular fa-clock me-2 text-muted"></i>{{ $booking->waktu_mulai }}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.75rem;">Jadwal Selesai</small>
                                    <span class="text-dark"><i class="fa-regular fa-clock me-2 text-muted"></i>{{ $booking->waktu_selesai }}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.75rem;">Keperluan / Acara</small>
                                    <p class="text-dark small mb-0 bg-light p-2 rounded-2 border-start border-success border-3">{{ $booking->keperluan }}</p>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 p-3 d-grid">
                                <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold">
                                        <i class="fa-solid fa-trash-can me-2"></i>Batalkan Booking
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>