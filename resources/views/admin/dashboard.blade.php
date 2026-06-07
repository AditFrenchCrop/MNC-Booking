<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MNC Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #0d5231;
        }
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            font-weight: bold;
        }
        .filter-tab .nav-link {
            color: #495057;
            font-weight: 500;
        }
        .filter-tab .nav-link.active {
            color: #198754 !important;
            background: transparent;
            border-bottom: 3px solid #198754;
            border-radius: 0;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar text-white collapse p-3">
                <div class="d-flex align-items-center mb-4 px-2">
                    <i class="fa-solid fa-shield-halved fa-2x me-2 text-warning"></i>
                    <span class="fs-5 fw-bold text-uppercase tracking-wider">MNC Admin</span>
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto gap-1">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white active">
                            <i class="fa-solid fa-chart-line me-2"></i> Booking Requests
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-white opacity-75">
                            <i class="fa-solid fa-users me-2"></i> Manajemen User
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.studios.index') }}" class="nav-link text-white opacity-75">
                            <i class="fa-solid fa-building me-2"></i> Master Studio
                        </a>
                    </li>
                </ul>
                <hr class="mt-5">
                <div class="px-2">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light w-100">
                        <i class="fa-solid fa-arrow-left me-1"></i> Ke Main Web
                    </a>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <div>
                        <h1 class="h2 fw-bold text-dark">Daftar Permohonan Booking</h1>
                        <p class="text-muted">Kelola persetujuan peminjaman studio ruangan MNC di sini.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-2">
                        <ul class="nav filter-tab" id="statusFilterTabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-status="all">Semua Request</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="pending">Menunggu (Pending)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="approved">Disetujui</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="rejected">Ditolak</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="bookingRequestsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="ps-4">Nama Peminjam</th>
                                    <th scope="col">Studio</th>
                                    <th scope="col">Waktu Mulai</th>
                                    <th scope="col">Waktu Selesai</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center pe-4" style="width: 240px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr class="booking-row" data-row-status="{{ $booking->status ?? 'pending' }}">
                                        <td class="ps-4 fw-semibold text-dark">{{ $booking->nama_peminjam }}</td>
                                        <td>{{ $booking->studio->nama_studio ?? 'Studio Tidak Ditemukan' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('Y-m-d H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if(($booking->status ?? 'pending') == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif(($booking->status ?? '') == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-4">
                                            @if(($booking->status ?? 'pending') == 'pending')
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <form action="{{ route('admin.booking.approve', $booking->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm fw-semibold">
                                                            <i class="fa-solid fa-check me-1"></i>Approve
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('admin.booking.reject', $booking->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm fw-semibold">
                                                            <i class="fa-solid fa-xmark me-1"></i>Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted small italic">Selesai Diproses</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                            Belum ada data permohonan booking masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const filterLinks = document.querySelectorAll('#statusFilterTabs .nav-link');
        
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                filterLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                const targetStatus = this.getAttribute('data-status');
                const rows = document.querySelectorAll('.booking-row');

                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-row-status');
                    if (targetStatus === 'all' || rowStatus === targetStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>