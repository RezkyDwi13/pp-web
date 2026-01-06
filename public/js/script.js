/* app.js - Refactored to use Laravel Backend */

const API_Base = ''; // Current origin

/* Utility: Escape HTML */
function escapeHtml(s) {
  if (!s) return '';
  return String(s).replace(/[&<>"']/g, function (m) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m];
  });
}

/* ------------------ For index.html: render table ------------------ */
function renderTable() {
  const container = document.getElementById('table-body');
  if (!container) return;

  container.innerHTML = '<tr><td colspan="5" class="text-center">Loading...</td></tr>';

  fetch(`${API_Base}/history`)
    .then(res => res.json())
    .then(list => {
      container.innerHTML = '';
      if (list.length === 0) {
        container.innerHTML = `<tr><td colspan="5" class="text-center small-muted">Belum ada hasil test. Tambah data terlebih dahulu.</td></tr>`;
        return;
      }
      list.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td><img src="${item.image_path}" alt="img" class="thumb" style="width:80px;height:80px;object-fit:cover;border-radius:8px;"></td>
          <td>
            <strong>${escapeHtml(item.name || 'Pisang')}</strong><br>
            <span class="small-muted">${new Date(item.created_at).toLocaleString()}</span>
          </td>
          <td>${escapeHtml(item.note || '')}</td>
          <td><span class="badge bg-info text-dark">${escapeHtml(item.result || 'Unknown')}</span> <br> <small>${(item.confidence * 100).toFixed(1)}%</small></td>
          <td style="min-width:160px">
            <!-- Edit/Delete not implemented in Backend yet. -->
             <span class="text-muted small">View Only</span>
          </td>
        `;
        container.appendChild(tr);
      });
    })
    .catch(err => {
      console.error(err);
      container.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>`;
    });
}

/* ------------------ For add/edit pages: form handling ------------------ */
function initForm(pageType = 'add') {
  const form = document.getElementById('pisangForm');
  if (!form) return;

  const fileInput = document.getElementById('imageInput');
  const previewImg = document.getElementById('imagePreview');
  const accessCamBtn = document.getElementById('accessCameraBtn');
  const captureBtn = document.getElementById('captureBtn');
  const video = document.getElementById('cameraPreview');
  let stream = null;
  let capturedBlob = null; // Store blob for upload

  // image input preview
  fileInput && fileInput.addEventListener('change', (ev) => {
    const f = ev.target.files[0];
    if (!f) return;
    const reader = new FileReader();
    reader.onload = () => {
      previewImg.src = reader.result;
      previewImg.classList.remove('d-none');
    };
    reader.readAsDataURL(f);
    capturedBlob = null; // Clear captured if file selected
  });

  // open camera modal / start stream
  accessCamBtn && accessCamBtn.addEventListener('click', async () => {
    const modal = new bootstrap.Modal(document.getElementById('cameraModal'));
    modal.show();
    try {
      stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
      video.srcObject = stream;
      await video.play();
    } catch (err) {
      console.error('Camera error', err);
      alert('Tidak bisa mengakses kamera. Cek izin atau gunakan upload gambar.');
    }
  });

  // capture snapshot
  captureBtn && captureBtn.addEventListener('click', () => {
    if (!video || !video.videoWidth) { alert('Video belum siap'); return; }
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert to blob for upload
    canvas.toBlob(blob => {
      capturedBlob = blob;
      const url = URL.createObjectURL(blob);
      previewImg.src = url;
      previewImg.classList.remove('d-none');

      // Clear file input
      if (fileInput) fileInput.value = '';
    }, 'image/jpeg', 0.9);

    // stop stream and close modal
    if (stream) {
      stream.getTracks().forEach(t => t.stop());
      stream = null;
    }
    const camModalEl = document.getElementById('cameraModal');
    const camModal = bootstrap.Modal.getInstance(camModalEl);
    camModal.hide();
  });

  // When camera modal closed, stop stream if active
  const camModalEl = document.getElementById('cameraModal');
  if (camModalEl) {
    camModalEl.addEventListener('hidden.bs.modal', () => {
      if (stream) {
        stream.getTracks().forEach(t => t.stop());
        stream = null;
      }
    });
  }

  // Submit form
  form.addEventListener('submit', async (ev) => {
    ev.preventDefault();
    const name = document.getElementById('name').value.trim();
    const note = document.getElementById('note').value.trim();

    const formData = new FormData();
    formData.append('name', name);
    formData.append('note', note);

    // Determine image source: file input or captured blob
    if (fileInput && fileInput.files[0]) {
      formData.append('image', fileInput.files[0]);
    } else if (capturedBlob) {
      formData.append('image', capturedBlob, 'capture.jpg');
    } else {
      alert('Pilih gambar atau ambil foto terlebih dahulu!');
      return;
    }

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const oldText = submitBtn.innerText;
    submitBtn.innerText = 'Memproses...';
    submitBtn.disabled = true;

    try {
      const res = await fetch(`${API_Base}/classify`, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });
      const data = await res.json();

      if (data.success) {
        alert(`Hasil: ${data.data.result} (${(data.data.confidence * 100).toFixed(0)}%)`);
        location.href = '/'; // Corrected redirect to root
      } else {
        alert('Gagal: ' + (data.message || 'Error details unknown'));
      }
    } catch (err) {
      console.error(err);
      alert('Terjadi kesalahan koneksi.');
    } finally {
      submitBtn.innerText = oldText;
      submitBtn.disabled = false;
    }
  });
}

function initAuthForms() {
  // Placeholder
}

/* On index ready, render */
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('table-body')) renderTable();
  if (document.getElementById('pisangForm')) {
    const mode = document.body.dataset.page || 'add';
    initForm(mode);
  }
  // initAuthForms();
});