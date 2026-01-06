<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tambah Hasil — Tes Kematangan Pisang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <script src="{{ asset('js/script.js') }}"></script>
</head>
<body data-page="add">
  <header class="header-wave">
    <div class="header-title container">
      <div style="display:flex;gap:1rem;align-items:center">
        <div class="logo-circle">TP</div>
        <div>
          <h3 class="mb-0">Tambah Hasil Test</h3>
          <div class="small-muted">Upload gambar atau ambil lewat kamera</div>
        </div>
      </div>
      <div>
        <a href="{{ route('home') }}" class="btn btn-outline-dark">Kembali</a>
      </div>
    </div>
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,30 C300,90 900,-30 1200,30 L1200,60 L0,60 Z" fill="#ffffff" opacity="0.9"></path>
    </svg>
  </header>

  <main class="form-container">
    <div class="card card-accent p-4">
      <form id="pisangForm" class="row g-3">
        <div class="col-12">
          <label class="form-label">Nama/Pengenal (opsional)</label>
          <input id="name" class="form-control" placeholder="Contoh: Pisang Ambon #1">
        </div>

        <div class="col-md-6">
          <label class="form-label">Upload Gambar</label>
          <input id="imageInput" type="file" accept="image/*" class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">Akses Kamera</label>
          <div class="d-flex gap-2">
            <button id="accessCameraBtn" type="button" class="btn btn-outline-primary">Buka Kamera</button>
            <button id="captureBtn" type="button" class="btn btn-outline-success d-none">Capture (tidak terlihat)</button>
            <small class="align-self-center small-muted">(akan membuka modal untuk preview)</small>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label">Stage Kematangan (Auto-Detect)</label>
          <select id="stage" class="form-select" disabled>
            <option>Akan dideteksi otomatis...</option>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Catatan</label>
          <textarea id="note" rows="4" class="form-control" placeholder="Catatan hasil, aroma, tekstur, dsb."></textarea>
        </div>

        <div class="col-12">
          <img id="imagePreview" src="" alt="Preview" class="d-none mb-3" style="max-width:320px;border-radius:8px;">
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-yellow" type="submit">Simpan</button>
          <a class="btn btn-outline-secondary" href="{{ route('home') }}">Batal</a>
        </div>
      </form>
    </div>
  </main>

  <!-- Camera modal -->
  <div class="modal fade" id="cameraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Arahkan kamera ke pisang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <video id="cameraPreview" playsinline autoplay></video>
        </div>
        <div class="modal-footer">
          <button id="captureBtn" type="button" class="btn btn-primary">Ambil Foto</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script already included in head -->
</body>
</html>