<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNC Studio Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .studio-card {
            transition: transform 0.3s ease, shadow 0.3s ease;
            border: none;
        }
        .studio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        }
        .search-container {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <i class="fa-solid fa-guitar me-2"></i> MNC Studios Booking
            </a>
            
            <div class="ms-auto">
                @if (Route::has('login'))
                    <div class="d-flex align-items-center gap-2">
                        @auth
                            <a href="{{ route('booking.my') }}" class="nav-link text-white fw-semibold me-3">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Booking
                            </a>

                            <a href="{{ url('/dashboard') }}" class="btn btn-light fw-bold text-success px-4 shadow-sm">
                                <i class="fa-solid fa-gauge me-1"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2 px-3">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-warning px-3 shadow-sm text-dark fw-bold">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
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

        <div class="search-container mb-5 text-center">
            <h2 class="fw-bold text-dark mb-3">Cari & Booking Studio Room</h2>
            <div class="input-group input-group-lg shadow-sm rounded">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" id="searchStudio" class="form-control border-start-0 ps-0" placeholder="Ketik nama studio atau lokasi...">
            </div>
        </div>

        <div class="row g-4" id="studioContainer">
            @foreach($studios as $s)
            <div class="col-12 col-md-6 col-lg-4 studio-item">
                <div class="card h-100 shadow-sm studio-card">
                    <div class="text-white d-flex align-items-center justify-content-center p-5 text-center rounded-top" style="height: 180px; background: linear-gradient(135deg, #198754 0%, #0d5231 100%);">
                        <div>
                            <i class="fa-solid fa-sliders fa-3x mb-2 text-white-50"></i>
                            <h5 class="m-0 text-uppercase tracking-wider">MNC Room</h5>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title fw-bold text-dark studio-name">{{ $s->nama_studio }}</h4>
                        <p class="card-text text-muted flex-grow-1 studio-location">
                            <i class="fa-solid fa-map-marker-alt text-danger me-2"></i>{{ $s->lokasi }}
                        </p>
                        
                        <hr class="text-black-50 my-3">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded">
                                <i class="fa-solid fa-circle text-success me-1 small"></i> Ready
                            </span>
                            <a href="{{ route('booking.form', $s->id) }}" class="btn btn-success px-4 shadow-sm">
                                Booking <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div id="notFoundMessage" class="text-center text-muted my-5 d-none">
            <i class="fa-regular fa-folder-open fa-3x mb-3"></i>
            <h5>Studio yang kamu cari tidak ditemukan...</h5>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('searchStudio').addEventListener('input', function() {
            let keyword = this.value.toLowerCase().trim();
            let studioItems = document.querySelectorAll('.studio-item');
            let anyFound = false;

            studioItems.forEach(function(item) {
                let name = item.querySelector('.studio-name').textContent.toLowerCase();
                let location = item.querySelector('.studio-location').textContent.toLowerCase();

                if (name.includes(keyword) || location.includes(keyword)) {
                    item.classList.remove('d-none');
                    anyFound = true;
                } else {
                    item.classList.add('d-none');
                }
            });

            let notFoundElement = document.getElementById('notFoundMessage');
            if (anyFound) {
                notFoundElement.classList.add('d-none');
            } else {
                notFoundElement.classList.remove('d-none');
            }
        });
    </script>
</body>
</html>