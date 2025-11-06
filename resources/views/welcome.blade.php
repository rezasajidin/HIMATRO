<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMATRO - Himpunan Mahasiswa Teknik Elektro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d1b2a, #1b263b);
            color: white;
            min-height: 100vh;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .hero {
            text-align: center;
            padding: 120px 20px;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            color: #cfd8dc;
        }

        .btn-login {
            background-color: #f9a825;
            color: #000;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 30px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #ffca28;
            transform: scale(1.05);
        }

        footer {
            text-align: center;
            padding: 20px 0;
            color: #b0bec5;
            background-color: rgba(0, 0, 0, 0.3);
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">HIMATRO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#activities">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-login ms-2">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>HIMPUNAN MAHASISWA TEKNIK ELEKTRO</h1>
            <p>Tempat Berkumpulnya Mahasiswa Teknik Elektro yang Berprestasi, Inovatif, dan Solid.</p>
            <a href="{{ route('login') }}" class="btn btn-login mt-4">Masuk ke Sistem</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light text-dark">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Tentang HIMATRO</h2>
            <p class="lead mx-auto" style="max-width: 700px;">
                HIMATRO adalah wadah resmi bagi mahasiswa Teknik Elektro untuk mengembangkan potensi akademik, sosial, dan profesional. 
                Kami berkomitmen untuk membangun solidaritas antar mahasiswa serta mendukung kemajuan teknologi yang bermanfaat bagi masyarakat.
            </p>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="activities" class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Kegiatan Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card bg-dark text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Workshop & Seminar</h5>
                            <p class="card-text">Meningkatkan kemampuan teknis melalui pelatihan dan seminar teknologi terbaru.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-dark text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Kegiatan Sosial</h5>
                            <p class="card-text">Aktif dalam pengabdian masyarakat dan kegiatan sosial untuk dampak positif nyata.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-dark text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Kompetisi & Prestasi</h5>
                            <p class="card-text">Berpartisipasi dan berprestasi dalam berbagai kompetisi tingkat nasional dan internasional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>© {{ date('Y') }} Himpunan Mahasiswa Teknik Elektro - All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
