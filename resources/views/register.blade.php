<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register — Tes Kematangan Pisang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <header class="header-wave">
    <div class="header-title container">
      <div style="display:flex;gap:1rem;align-items:center">
        <div class="logo-circle">TP</div>
        <div>
          <h3 class="mb-0">Daftar Akun</h3>
          <div class="small-muted">Hanya tampilan frontend (simulasi)</div>
        </div>
      </div>
      <div>
        <a href="{{ route('home') }}" class="btn btn-outline-dark">Home</a>
      </div>
    </div>
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,30 C300,90 900,-30 1200,30 L1200,60 L0,60 Z" fill="#ffffff" opacity="0.9"></path>
    </svg>
  </header>

  <main class="form-container">
    <div class="card card-accent p-4">
      <form id="registerForm" class="row g-3">
        <div class="col-12">
          <label class="form-label">Nama Lengkap</label>
          <input required class="form-control" id="reg_name" placeholder="Nama lengkap">
        </div>
        <div class="col-12">
          <label class="form-label">Email</label>
          <input required type="email" id="reg_email" class="form-control" placeholder="email@domain.com">
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input required type="password" id="reg_pass" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Konfirmasi Password</label>
          <input required type="password" id="reg_pass2" class="form-control">
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-yellow" type="submit">Daftar</button>
          <a class="btn btn-outline-secondary" href="{{ route('login') }}">Sudah punya akun?</a>
        </div>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>