<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Manajemen')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS dan Icons (1x saja) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

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
      cursor: pointer;
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
  </style>

  @stack('styles')
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column">
    <div class="text-center mb-3">
      <img src="{{ asset('images/desnet-logo.png') }}" alt="Logo" class="img-fluid mb-2">
      <div class="role-label" id="openAccountModal">
        <i class="bi bi-person-fill"></i> {{ Auth::user()->role }}
      </div>
    </div>

    <nav class="nav flex-column mb-auto">
      <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('kelola-user.index') }}" class="nav-link {{ Request::is('kelola-user*') ? 'active' : '' }}">Kelola User</a>
      <a href="{{ route('komisi.index') }}" class="nav-link {{ Request::is('komisi*') ? 'active' : '' }}">Komisi</a>
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
        <li class="nav-item dropdown list-unstyled m-0">
            <a id="notificationDropdown" class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                    0
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notificationDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                <li class="p-2 border-bottom fw-bold">Notifikasi</li>
                <div id="notificationList">
                    <li class="p-2 text-muted">Tidak ada notifikasi baru</li>
                </div>
                <li class="text-center border-top">
                    <a href="#" id="markAllRead" class="small text-primary">Tandai semua dibaca</a>
                </li>
            </ul>
        </li>
    </div>
</div>


  <!-- Main Content -->
  <div class="main-content">
    @yield('content')
  </div>

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
          <button type="submit" class="btn btn-dark">Yakin</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Logout modal
  const logoutButton = document.getElementById('btnLogout');
  const logoutModal  = new bootstrap.Modal(document.getElementById('modalLogout'));
  logoutButton.addEventListener('click', function (e) {
    e.preventDefault();
    logoutModal.show();
  });
</script>


  @stack('scripts')
</body>
</html>
