<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking Saya - MNC Studios Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .studio-card {
            border: none;
            border-radius: 10px;
        }
        .btn-success-custom {
            background-color: #198754;
            border: none;
        }
        .btn-success-custom:hover {
            background-color: #146c43;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-guitar me-2"></i> MNC Studios Booking
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('booking.my') }}" class="nav-link text-white fw-semibold me-3">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Booking
                        </a>

                        <a href="{{ route('dashboard') }}" class="btn btn-light fw-bold text-success px-4 shadow-sm me-2">
                            <i class="fa-solid fa-gauge me-1"></i> Dashboard
                        </a>

                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning fw-bold text-dark px-3 shadow-sm me-2">
                                <i class="fa-solid fa-gauge me-1"></i> Panel Admin
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger fw-bold px-3 shadow-sm">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Log Out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2 px-3">Log in</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Riwayat Booking Saya</h2>
                <p class="text-muted m-0">Pantau dan kelola jadwal peminjaman studio Anda di sini.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-success btn-success-custom fw-bold shadow-sm px-4">
                <i class="fa-solid fa-plus me-1"></i> Booking Studio Lagi
            </a>
        </div>

        <div class="row g-4">
            @forelse($bookings as $booking)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm studio-card">
                    
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                        <h6 class="m-0 fw-bold text-uppercase tracking-wider">
                            <i class="fa-solid fa-sliders me-1 text-success"></i> {{ $booking->studio->nama_studio ?? 'Studio' }}
                        </h6>
                        
                        @if($booking->status == 'pending')
                            <span class="badge bg-warning text-dark fw-bold px-2.5 py-1.5 rounded">
                                <i class="fa-solid fa-clock me-1"></i> Pending
                            </span>
                        @elseif($booking->status == 'approved')
                            <span class="badge bg-success fw-bold px-2.5 py-1.5 rounded">
                                <i class="fa-solid fa-circle-check me-1"></i> Disetujui
                            </span>
                        @elseif($booking->status == 'rejected')
                            <span class="badge bg-danger fw-bold px-2.5 py-1.5 rounded">
                                <i class="fa-solid fa-circle-xmark me-1"></i> Ditolak
                            </span>
                        @else
                            <span class="badge bg-secondary fw-bold px-2.5 py-1.5 rounded">
                                {{ ucfirst($booking->status) }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body bg-white text-dark small d-flex flex-column">
                        <div class="mb-2">
                            <label class="fw-bold text-muted text-uppercase d-block mb-0" style="font-size: 11px;">Nama Peminjam</label>
                            <span class="fs-6 text-dark">{{ $booking->nama_peminjam }}</span>
                        </div>
                        
                        <div class="mb-2">
                            <label class="fw-bold text-muted text-uppercase d-block mb-0" style="font-size: 11px;">Jadwal Mulai</label>
                            <span class="text-dark"><i class="fa-regular fa-clock text-muted me-1"></i> {{ $booking->waktu_mulai }}</span>
                        </div>

                        <div class="mb-2">
                            <label class="fw-bold text-muted text-uppercase d-block mb-0" style="font-size: 11px;">Jadwal Selesai</label>
                            <span class="text-dark"><i class="fa-regular fa-clock text-muted me-1"></i> {{ $booking->waktu_selesai }}</span>
                        </div>

                        <div class="mb-3 flex-grow-1">
                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 11px;">Keperluan / Acara</label>
                            <div class="p-2 border-start border-success border-3 bg-light rounded rounded-start-0 text-break">
                                {{ $booking->keperluan }}
                            </div>
                        </div>
                        
                        @if($booking->status == 'pending')
                            <hr class="text-black-50 my-2">
                            <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 fw-bold btn-sm shadow-sm py-2">
                                    <i class="fa-solid fa-trash me-1"></i> Batalkan Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted my-5">
                <i class="fa-regular fa-folder-open fa-3x mb-3"></i>
                <h5>Kamu belum memiliki riwayat booking studio.</h5>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>