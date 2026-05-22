<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MNC Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">MNC Studios Admin Portal</a>
            <span class="navbar-text text-white">
                Halo, {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})
            </span>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Daftar Pengajuan Booking Studio</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Studio</th>
                                <th>Peminjam</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Keperluan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $b)
                            <tr>
                                <td>{{ $b->nama_studio }}</td>
                                <td>{{ $b->nama_peminjam }}</td>
                                <td>{{ $b->waktu_mulai }}</td>
                                <td>{{ $b->waktu_selesai }}</td>
                                <td>{{ $b->keperluan }}</td>
                                <td>
                                    <form action="{{ route('admin.approve', $b->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success me-1">Approve</button>
                                    </form>
                                    
                                    <form action="{{ route('admin.reject', $b->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pengajuan booking saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>