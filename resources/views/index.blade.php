<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tes Kematangan Pisang — Daftar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <header class="header-wave">
    <div class="header-title container">
      <div style="display:flex;gap:1rem;align-items:center">
        <div class="logo-circle">TP</div>
        <div>
          <h3 class="mb-0">Tes Kematangan Pisang</h3>
          <div class="small-muted">Frontend demo CRUD & kamera</div>
        </div>
      </div>
      <div class="d-flex gap-2 align-items-center">
        <a href="{{ route('add') }}" class="btn btn-yellow">Tambah Hasil</a>
        <!-- <a href="{{ route('register') }}" class="btn btn-outline-dark">Register</a>
        <a href="{{ route('login') }}" class="btn btn-outline-dark">Login</a> -->
      </div>
    </div>

    <!-- SVG wave -->
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,30 C300,90 900,-30 1200,30 L1200,60 L0,60 Z" fill="#ffffff" opacity="0.9"></path>
    </svg>
  </header>

  <main class="container">
    <div class="card card-accent p-3">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Hasil Test Kematangan</h5>
        <div class="small-muted">Data diambil dari Database (Laravel Backend)</div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Gambar</th>
              <th>Nama / Tanggal</th>
              <th>Catatan</th>
              <th>Stage</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <!-- diisi script.js -->
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <footer class="footer-wave">
    <div class="container text-center small-muted py-4">© Tes Kematangan Pisang — Frontend Demo</div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
