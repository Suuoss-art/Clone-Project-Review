<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard HOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap, Font & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <form id="formTambahProject">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Personel Dynamic JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let personelCount = 3;

      document.getElementById('addPersonelBtn').addEventListener('click', function () {
        const container = document.getElementById('personelContainer');
        const index = personelCount++;
        
        const row = document.createElement('div');
        row.className = 'row g-2 mb-3 personel-row';
        row.innerHTML = `
          <div class="col-md-6">
            <label class="form-label">Personel ${index + 1}</label>
            <input type="text" name="personel[${index}][nama]" class="form-control rounded-3">
          </div>
          <div class="col-md-6">
            <label class="form-label">Sebagai:</label>
            <select name="personel[${index}][role]" class="form-select rounded-3">
              <option value="">Pilih peran</option>
              <option>Analis</option>
              <option>Programer web</option>
              <option>Programer mobile</option>
              <option>Tester</option>
              <option>Desainer</option>
              <option>Front-end</option>
            </select>
          </div>
        `;
        container.appendChild(row);
      });
    });
  </script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    let personelCount = 3;

    document.getElementById('addPersonelBtn').addEventListener('click', function () {
      // Tambah personel secara dinamis
    });
  });
</script>

<script>
  document.getElementById('addPersonelBtn').addEventListener('click', function () {
    // Tambah personel (duplikat dari atas)
  });

  // AJAX simpan project juga di sini
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let personelCount = 3;

  // HANYA INI SAJA: tombol tambah personel
  document.getElementById('addPersonelBtn').addEventListener('click', function () {
    const container = document.getElementById('personelContainer');
    const index = personelCount++;

    const row = document.createElement('div');
    row.className = 'row g-2 mb-3 personel-row';
    row.innerHTML = `
      <div class="col-md-6">
        <label class="form-label">Personel ${index + 1}</label>
        <input type="text" name="personel[${index}][nama]" class="form-control" placeholder="Nama Personel">
      </div>
      <div class="col-md-6">
        <label class="form-label">Sebagai:</label>
        <select name="personel[${index}][role]" class="form-select">
          <option value="">Pilih peran</option>
          <option>Analis</option>
          <option>Programer web</option>
          <option>Programer mobile</option>
          <option>Tester</option>
          <option>Desainer</option>
          <option>Front-end</option>
        </select>
      </div>
    `;
    container.appendChild(row);
  });

    // Simpan proyek via AJAX
  document.getElementById('formTambahProject').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const notif = document.getElementById('notifAjax');
    const btn = document.getElementById('btnSimpanProject');

    btn.disabled = true;
    fetch("{{ url('/projects/ajax-store') }}", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": '{{ csrf_token() }}'
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      btn.disabled = false;
      if (data.success) {
        notif.classList.remove('d-none', 'alert-danger');
        notif.classList.add('alert-success');
        notif.innerText = data.message;

        // Tambahkan baris ke tabel
        const table = document.getElementById('tabelWorkOrder').querySelector('tbody');
        const index = table.querySelectorAll('tr').length + 1;
        const personelList = data.project.project_personel.map(p => p.nama).join(', ');
        const row = `
  <tr>
    <td>${index}</td>
    <td>${data.project.judul}</td>
    <td><span class="status-dot dot-warning"></span> Belum Diajukan</td>
    <td><span class="status-dot dot-warning"></span> Belum Disetujui</td>
    <td>${parseInt(data.project.nilai).toLocaleString('id-ID')}</td>
    <td>${personelList || '-'}</td>
    <td>
      <a href="/projects/${data.project.id}" class="btn btn-sm btn-info text-white">Detail</a>
      <a href="/projects/${data.project.id}/edit" class="btn btn-sm btn-warning text-white">Edit</a>
      <form action="/projects/${data.project.id}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
  </tr>`;
        table.insertAdjacentHTML('beforeend', row);

        // Reset form & tutup modal
        form.reset();
        document.getElementById('modalTambahProject').querySelector('.btn-close').click();
      } else {
        notif.classList.remove('d-none', 'alert-success');
        notif.classList.add('alert-danger');
        notif.innerText = data.message || 'Gagal menyimpan proyek.';
      }
    })
    .catch(err => {
      notif.classList.remove('d-none', 'alert-success');
      notif.classList.add('alert-danger');
      notif.innerText = 'Kesalahan server. Silakan coba lagi.';
      btn.disabled = false;
    });
  });
});
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let personelCount = 3;

    // Tambah Personel
    document.getElementById('addPersonelBtn').addEventListener('click', function () {
      const container = document.getElementById('personelContainer');
      const index = personelCount++;

      const row = document.createElement('div');
      row.className = 'row g-2 mb-3 personel-row';
      row.innerHTML = `
        <div class="col-md-6">
          <label class="form-label">Personel ${index + 1}</label>
          <input type="text" name="personel[${index}][nama]" class="form-control" placeholder="Nama Personel">
        </div>
        <div class="col-md-6">
          <label class="form-label">Sebagai:</label>
          <select name="personel[${index}][role]" class="form-select">
            <option value="">Pilih peran</option>
            <option>Analis</option>
            <option>Programer web</option>
            <option>Programer mobile</option>
            <option>Tester</option>
            <option>Desainer</option>
            <option>Front-end</option>
          </select>
        </div>
      `;
      container.appendChild(row);
    });

    // RESET form saat klik Batal
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
      btn.addEventListener('click', function () {
        const form = document.getElementById('formTambahProject');
        form.reset();

        // Hapus semua personel dinamis
        const container = document.getElementById('personelContainer');
        container.innerHTML = '';

        // Tambahkan kembali default 3 personel
        personelCount = 3;
        for (let i = 0; i < 3; i++) {
          const row = document.createElement('div');
          row.className = 'row g-2 mb-3 personel-row';
          row.innerHTML = `
            <div class="col-md-6">
              <label class="form-label">Personel ${i + 1}</label>
              <input type="text" name="personel[${i}][nama]" class="form-control" placeholder="Nama Personel">
            </div>
            <div class="col-md-6">
              <label class="form-label">Sebagai:</label>
              <select name="personel[${i}][role]" class="form-select">
                <option value="">Pilih peran</option>
                <option>Analis</option>
                <option>Programer web</option>
                <option>Programer mobile</option>
                <option>Tester</option>
                <option>Desainer</option>
                <option>Front-end</option>
              </select>
            </div>
          `;
          container.appendChild(row);
        }

        // Sembunyikan notifikasi
        const notif = document.getElementById('notifAjax');
        notif.classList.add('d-none');
        notif.innerText = '';
      });
    });
  });
</script>


  <!-- Style -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fd;
    }

    .sidebar {
      width: 240px;
      background-color: #0284c7;
      color: white;
      position: fixed;
      height: 100vh;
      padding: 20px 16px;
    }

    .sidebar .role-label {
      background-color: #0369a1;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-bottom: 30px;
    }

    .sidebar .nav-link {
      color: white;
      font-weight: 600;
      margin-bottom: 12px;
      display: block;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      text-decoration: underline;
    }

    .topbar {
      margin-left: 240px;
      padding: 15px 30px;
      background-color: white;
      border-bottom: 1px solid #ddd;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .main-content {
      margin-left: 240px;
      padding: 30px;
    }

    .add-button {
      background-color: #6366f1;
      color: white;
      border: none;
      border-radius: 24px;
      padding: 8px 18px;
      font-weight: 600;
    }

    .card-box {
      background-color: white;
      border-radius: 16px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      padding: 24px;
    }
    .status-dot {
      height: 10px;
      width: 10px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 6px;
    }

    .dot-success { background-color: #22c55e; }
    .dot-warning { background-color: #f59e0b; }

    .doc-box, .komisi-box {
      background-color: #ffffff;
      border: 1px solid #e0e7ff;
      border-radius: 14px;
      padding: 20px;
      text-align: center;
    }

    .doc-box i, .komisi-box i {
      font-size: 28px;
      margin-bottom: 8px;
      display: block;
    }

    .number {
      font-size: 24px;
      font-weight: bold;
      color: #4f46e5;
    }

    .table-fixed {
      table-layout: fixed;
      width: 100%;
    }
    .table-fixed th,
    .table-fixed td {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      vertical-align: middle;
    }

    .col-no { width: 40px; }
    .col-judul { width: 180px; }
    .col-status { width: 180px; }
    .col-nilai { width: 150px; }
    .col-personel { width: 300px; }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column" style="height: 100vh;">
    <div class="text-center mb-3">
      <img src="{{ asset('images/desnet-logo.png') }}" alt="Logo" class="img-fluid mb-2">
      <div class="role-label" id="openAccountModal" style="cursor:pointer;">
    <i class="bi bi-person-fill"></i> {{ Auth::user()->role }}
  </div>
    </div>

    <nav class="nav flex-column mb-auto">
      <a href="{{ route('hod.dashboard') }}" class="nav-link {{ Request::is('hod/dashboard') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('hod.project') }}" class="nav-link {{ Request::is('hod/project') ? 'active' : '' }}">Project</a>
      <a href="{{ route('hod.komisi') }}" class="nav-link {{ Request::is('hod/komisi') ? 'active' : '' }}">Komisi</a>
    </nav>

    <div class="mt-auto p-3">
      <a href="#" id="btnLogout" class="btn btn-sm btn-dark w-100 d-flex align-items-center justify-content-center">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>
  </div>

<!-- Topbar -->
<div class="topbar">
  <div><h6 class="mb-0 fw-bold">Manajemen Arsip Dokumen dan Komisi</h6></div>
  <div class="d-flex align-items-center gap-3">
    <!-- Notification Bell -->
    <div class="dropdown">
      <button class="btn btn-link position-relative p-0" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-5"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none;">
          0
        </span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
        <li><h6 class="dropdown-header d-flex justify-content-between align-items-center">
          Notifikasi
          <button class="btn btn-sm btn-outline-primary" id="markAllRead">Tandai Semua Dibaca</button>
        </h6></li>
        <li><hr class="dropdown-divider"></li>
        <div id="notificationList">
          <li class="dropdown-item text-muted">Memuat notifikasi...</li>
        </div>
      </ul>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main-content">
<!-- Modal Tambah Proyek -->
<div class="modal fade" id="modalTambahProject" tabindex="-1" aria-labelledby="modalTambahProjectLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-bold">Tambah Data Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('projects.store') }}" method="POST" id="formTambahProject">
        @csrf
        <div id="notifAjax" class="alert d-none" role="alert"></div>
        <div class="modal-body">

          <!-- Proyek -->
          <div class="mb-4">
            <h6 class="fw-semibold">Proyek</h6>

            <div class="mb-3">
              <label class="form-label">Judul Proyek</label>
              <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Nilai Proyek</label>
              <input type="number" name="nilai" class="form-control" required>
            </div>
          </div>

          <!-- Personel -->
          <div class="mb-3">
            <h6 class="fw-semibold">Personel</h6>

            <div class="mb-3">
              <label class="form-label">Project Manager</label>
              <input type="text" name="pm" class="form-control" required>
            </div>

            <div id="personelContainer">
              @for ($i = 0; $i < 3; $i++)
              <div class="row g-2 mb-3 personel-row">
                <div class="col-md-6">
                  <label class="form-label">Personel {{ $i + 1 }}</label>
                  <input type="text" name="personel[{{ $i }}][nama]" class="form-control" placeholder="Nama Personel">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Sebagai:</label>
                  <select name="personel[{{ $i }}][role]" class="form-select">
                    <option value="">Pilih peran</option>
                    <option>Analis</option>
                    <option>Programer web</option>
                    <option>Programer mobile</option>
                    <option>Tester</option>
                    <option>Desainer</option>
                    <option>Front-end</option>
                  </select>
                </div>
              </div>
              @endfor
            </div>

            <!-- Tombol Tambah Personel -->
            <button type="button" class="btn btn-sm btn-primary mt-2 rounded-pill px-3" id="addPersonelBtn">
              <i class="bi bi-plus-circle me-1"></i> Tambah Personel
            </button>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-top-0">
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4" id="btnSimpanProject">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabel Work Order -->
<div class="card-box mb-4">
  <h6 class="fw-bold mb-3">Work Order</h6>
  <div class="table-responsive">
    <table class="table table-bordered align-middle" id="tabelWorkOrder">
      <thead class="table-light">
        <tr>
          <th class="col-no">No</th>
          <th class="col-judul">Judul Proyek</th>
          <th class="col-status">Status Dokumen</th>
          <th class="col-status">Status Komisi</th>
          <th class="col-nilai">Nilai Proyek</th>
          <th class="col-personel">Personel</th>
        </tr>
      </thead>
      <tbody>
        @php $projects = $projects ?? collect(); @endphp
        @forelse ($projects as $project)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $project->judul }}</td>
            <td>
              <span class="status-dot {{ $project->status_dokumen === 'Sudah Diajukan' ? 'dot-success' : 'dot-warning' }}"></span>
              {{ $project->status_dokumen ?? 'Belum Diajukan' }}
            </td>
            <td>
              <span class="status-dot {{ $project->status_komisi === 'Disetujui' ? 'dot-success' : 'dot-warning' }}"></span>
              {{ $project->status_komisi ?? 'Belum Disetujui' }}
            </td>
            <td>{{ number_format($project->nilai ?? 0, 0, ',', '.') }}</td>
            <td>
              {{ $project->projectPersonel->map(function($p) {
                  return $p->user ? $p->user->name : '(User tidak ditemukan)';
              })->join(', ') ?: '-' }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">Belum ada dokumen proyek.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

  <!-- Modal Akun -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4" style="border-radius:40px;">
      <div class="modal-header justify-content-center border-0">
        <h5 class="modal-title px-4 py-2 rounded" style="background-color: #044280; color: white;">
          <i class="bi bi-person-fill"></i> Akun Saya
        </h5>
        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between py-2">
          <strong>Nama</strong>
          <span id="accountName">{{ Auth::user()->name }}</span>
        </div>
        <div class="d-flex justify-content-between py-2">
          <strong>Email</strong>
          <span id="accountEmail">{{ Auth::user()->email }}</span>
        </div>
        <div class="d-flex justify-content-between py-2">
          <strong>Role</strong>
          <span id="accountRole">{{ Auth::user()->role }}</span>
        </div>
        <div class="d-flex justify-content-between py-2">
          <strong>Password</strong>
          <span id="accountPassword">*******</span>
        </div>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-warning" id="btnEditAkun">Edit Akun</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Akun -->
<div class="modal fade" id="modalEditUser" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Akun Saya</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="errorEditUser" class="text-danger mb-2"></div>
        
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" class="form-control" id="editName">
        </div>
        
        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" id="editEmail">
        </div>
        
        <div class="mb-3">
          <label>Role</label>
          <input type="text" class="form-control" id="editRole" readonly>
        </div>

        <div class="mb-3">
          <label>Password Lama</label>
          <div class="input-group">
            <input type="password" class="form-control" id="editOldPassword">
            <button type="button" class="btn btn-outline-secondary" id="toggleEditOldPassword">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label>Password Baru</label>
          <div class="input-group">
            <input type="password" class="form-control" id="editPassword">
            <button type="button" class="btn btn-outline-secondary" id="toggleEditPassword">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label>Konfirmasi Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="editPasswordConfirmation">
            <button type="button" class="btn btn-outline-secondary" id="toggleEditPasswordConfirmation">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" id="btnSaveEdit">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function togglePassword(buttonId, inputId) {
        const btn = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        btn.addEventListener('click', function () {
            const icon = this.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        });
    }

    togglePassword("toggleEditOldPassword", "editOldPassword");
    togglePassword("toggleEditPassword", "editPassword");
    togglePassword("toggleEditPasswordConfirmation", "editPasswordConfirmation");
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen modal dan tombol
    const modalAccountEl = document.getElementById('accountModal');
    const modalEditUserEl = document.getElementById('modalEditUser');
    const modalAccount = new bootstrap.Modal(modalAccountEl);
    const modalEditUser = new bootstrap.Modal(modalEditUserEl);

    const btnOpenAccount = document.getElementById("openAccountModal");
    const btnEditAkun = document.getElementById("btnEditAkun");

    // Buka modal akun
    if (btnOpenAccount) {
        btnOpenAccount.addEventListener("click", function () {
            document.getElementById("accountName").innerText = "{{ Auth::user()->name }}";
            document.getElementById("accountEmail").innerText = "{{ Auth::user()->email }}";
            document.getElementById("accountRole").innerText = "{{ Auth::user()->role }}";
            document.getElementById("accountPassword").innerText = "********";
            modalAccount.show();
        });
    }

    // Klik edit akun dari modal akun
    if (btnEditAkun) {
        btnEditAkun.addEventListener("click", function (e) {
            e.preventDefault();

            // Isi form edit dengan data user
            document.getElementById('editName').value = "{{ Auth::user()->name }}";
            document.getElementById('editEmail').value = "{{ Auth::user()->email }}";
            document.getElementById('editRole').value = "{{ Auth::user()->role }}"; // ← ini penting!

            document.getElementById('editOldPassword').value = '';
            document.getElementById('editPassword').value = '';
            document.getElementById('editPasswordConfirmation').value = '';

            document.querySelector('#modalEditUser .modal-title').innerText = 'Edit Akun Saya';

            // Tutup modal akun, baru buka modal edit
            modalAccount.hide();
            modalAccountEl.addEventListener('hidden.bs.modal', function openEdit() {
                modalEditUser.show();
                modalAccountEl.removeEventListener('hidden.bs.modal', openEdit);
            });
        });
    }

    // Tombol simpan di modal edit
    const btnSaveEdit = document.getElementById('btnSaveEdit');

    if (!btnSaveEdit) return;

    btnSaveEdit.addEventListener('click', function (e) {
        e.preventDefault();

        const name = document.getElementById('editName').value;
        const email = document.getElementById('editEmail').value;
        const role = document.getElementById('editRole').value;
        const oldPassword = document.getElementById('editOldPassword').value;
        const newPassword = document.getElementById('editPassword').value;
        const passwordConfirm = document.getElementById('editPasswordConfirmation').value;
        const errorBox = document.getElementById('errorEditUser');

        fetch('/profile', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                name: name,
                email: email,
                role: role,
                old_password: oldPassword,
                password: newPassword,
                password_confirmation: passwordConfirm
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                errorBox.textContent = '';

                // Tutup modal edit
                bootstrap.Modal.getInstance(document.getElementById('modalEditUser')).hide();

                // Tampilkan notifikasi berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // reload setelah user klik OK
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan.',
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan sistem.',
            });
        });
    });
});
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const hapusButtons = document.querySelectorAll('.btn-hapus');
    const modalHapus = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
    let projectIdToDelete = null;
    let rowToDelete = null;

    // Tangkap klik tombol hapus
    hapusButtons.forEach(button => {
      button.addEventListener('click', function () {
        projectIdToDelete = this.dataset.id;
        rowToDelete = this.closest('tr');
        modalHapus.show();
      });
    });

    // Ketika tombol "Hapus" dalam modal diklik
    document.getElementById('btnKonfirmasiHapus').addEventListener('click', function () {
      if (!projectIdToDelete) return;

      fetch(`/projects/${projectIdToDelete}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (response.ok) {
          // Hapus baris dari tabel tanpa reload
          rowToDelete.remove();
          modalHapus.hide();
        } else {
          alert('Gagal menghapus data. Coba lagi.');
        }
      })
      .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan!');
      });
    });
  });
</script>

  <!-- Modal Logout -->
<div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
      <h5 class="fw-bold mt-3">Apakah Anda yakin ingin keluar?</h5>
      <p class="text-muted">Tindakan ini akan mengeluarkan anda dari aplikasi</p>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <div class="d-flex justify-content-center gap-2 mt-3">
          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-dark" id="btnConfirmLogout">Yakin</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const logoutButton = document.getElementById('btnLogout');
  const logoutModal = new bootstrap.Modal(document.getElementById('modalLogout'));
  const confirmLogoutBtn = document.getElementById('btnConfirmLogout');

  // Buka modal saat klik tombol logout di sidebar
  logoutButton.addEventListener('click', function (e) {
    e.preventDefault();
    logoutModal.show();
  });

  // Logout saat klik tombol "Yakin"
  confirmLogoutBtn.addEventListener('click', function (e) {
    e.preventDefault();

    fetch('{{ route('logout') }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    }).then(res => {
      if (res.ok) {
        window.location.href = '/login';
      } else {
        alert('Gagal logout!');
      }
    }).catch(err => {
      console.error(err);
      alert('Kesalahan sistem saat logout.');
    });
  });
});
</script>

 <script>
  document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('btnLogout');
    const logoutModal = new bootstrap.Modal(document.getElementById('modalLogout'));

    logoutButton.addEventListener('click', function (e) {
      e.preventDefault();
      logoutModal.show();
    });
  });
</script>
 

  <!-- Statistik Dokumen -->
  <div class="card-box mb-4">
    <h6 class="fw-bold mb-3">Dokumen</h6>
    <div class="row g-3">
      <div class="col-md-4"><div class="doc-box border-primary"><i class="bi bi-folder-fill text-primary"></i><div class="title">Total Dokumen</div><div class="number">47</div></div></div>
      <div class="col-md-4"><div class="doc-box border-warning"><i class="bi bi-folder-symlink-fill text-warning"></i><div class="title">Dokumen Revisi</div><div class="number">15</div></div></div>
      <div class="col-md-4"><div class="doc-box border-success"><i class="bi bi-folder-check text-success"></i><div class="title">Dokumen Selesai</div><div class="number">32</div></div></div>
    </div>
  </div>

  <!-- Statistik Komisi -->
  <div class="card-box mb-4">
    <h6 class="fw-bold mb-3">Komisi</h6>
    <div class="row g-3">
      <div class="col-md-6"><div class="komisi-box border-primary"><div class="title"><i class="bi bi-receipt"></i> Komisi Bulan ini</div><div class="amount">Rp. 76.000.000,00</div></div></div>
      <div class="col-md-6"><div class="komisi-box border-primary"><div class="title"><i class="bi bi-receipt"></i> Komisi Tahun ini</div><div class="amount">Rp. 1.546.000.000,00</div></div></div>
    </div>
  </div>

</div>

<!-- Pusher and Laravel Echo Scripts (if using real-time notifications) -->
@if(config('broadcasting.default') === 'pusher')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
<script>
    // Initialize Echo with Pusher
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config("broadcasting.connections.pusher.key") }}',
        cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
        forceTLS: true
    });
</script>
@endif

<!-- HOD Notifications Script -->
<script>
    // Inline HOD notification script (embedded for simplicity)
    // This would normally be in a separate file

    // HOD Notification System
    function loadHodNotifications() {
        fetch('/hod/notifications')
            .then(res => res.json())
            .then(data => {
                let list = document.getElementById('notificationList');
                let badge = document.getElementById('notificationBadge');

                list.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(notification => {
                        let timeAgo = new Date(notification.created_at).toLocaleString('id-ID');
                        let projectLink = '';
                        
                        // Add link to project if it's a commission notification
                        if (notification.type === 'commission_submitted' && notification.data && notification.data.project_id) {
                            projectLink = `<a href="/hod/komisi/${notification.data.project_id}" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>`;
                        }

                        let item = `
                            <li class="dropdown-item border-bottom py-2" data-notification-id="${notification.id}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <p class="mb-1 small">${notification.message}</p>
                                        <small class="text-muted">${timeAgo}</small>
                                        ${projectLink}
                                    </div>
                                    <button class="btn btn-sm btn-link text-muted mark-read-btn" data-id="${notification.id}">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </div>
                            </li>`;
                        list.innerHTML += item;
                    });

                    // Add click handlers for mark as read buttons
                    document.querySelectorAll('.mark-read-btn').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            markNotificationAsRead(this.dataset.id);
                        });
                    });
                } else {
                    list.innerHTML = `<li class="dropdown-item text-muted">Tidak ada notifikasi baru</li>`;
                }

                // Update badge
                if (data.length > 0) {
                    badge.textContent = data.length;
                    badge.style.display = 'inline';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(err => {
                console.error('Error loading notifications:', err);
                document.getElementById('notificationList').innerHTML = 
                    `<li class="dropdown-item text-danger">Gagal memuat notifikasi</li>`;
            });
    }

    function markNotificationAsRead(notificationId) {
        fetch(`/hod/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Remove the notification from the list
                const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.remove();
                }
                // Reload notifications to update badge
                loadHodNotifications();
            }
        })
        .catch(err => {
            console.error('Error marking notification as read:', err);
        });
    }

    function markAllHodNotificationsAsRead() {
        fetch('/hod/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                loadHodNotifications();
            }
        })
        .catch(err => {
            console.error('Error marking all notifications as read:', err);
        });
    }

    // Toast notification function
    function showNotificationToast(title, message) {
        // Create toast element if it doesn't exist
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        const toastId = 'toast-' + Date.now();
        const toastHTML = `
            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-bell-fill text-primary me-2"></i>
                    <strong class="me-auto">${title}</strong>
                    <small>Baru saja</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;

        toastContainer.insertAdjacentHTML('beforeend', toastHTML);

        // Show the toast
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();

        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function() {
            toastElement.remove();
        });
    }

    // Initialize HOD notifications
    document.addEventListener('DOMContentLoaded', function() {
        // Load notifications on page load
        loadHodNotifications();

        // Mark all as read handler
        const markAllBtn = document.getElementById('markAllRead');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                markAllHodNotificationsAsRead();
            });
        }

        // Setup real-time notifications if Echo is available
        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('hod-notifications')
                .listen('.commission.submitted', (e) => {
                    console.log('New commission notification:', e);
                    
                    // Show toast notification
                    showNotificationToast('Komisi Baru', `PM ${e.pm_name} telah menginput komisi untuk proyek ${e.project_title}`);
                    
                    // Reload notifications
                    loadHodNotifications();
                });
        }

        // Refresh notifications every 30 seconds
        setInterval(loadHodNotifications, 30000);
    });
</script>

</body>
</html>
