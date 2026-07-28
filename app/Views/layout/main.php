<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?> - Ujian Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .sidebar-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.625rem 1rem; color: #d1d5db; border-radius: 0.5rem; transition: all 0.15s; }
        .sidebar-link:hover { background: #374151; color: #fff; }
        .sidebar-link.active { background: #374151; color: #fff; }
        .stat-card { background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 1.5rem; transition: box-shadow 0.15s; }
        .stat-card:hover { box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-900 text-white z-40 transition-transform -translate-x-full lg:translate-x-0">
        <div class="p-4 border-b border-gray-700">
            <h1 class="font-bold text-lg">Ujian Online</h1>
            <p class="text-xs text-gray-400 mt-1"><?= esc($group_name ?? '') ?></p>
        </div>
        <nav class="p-3 space-y-1 overflow-y-auto h-[calc(100%-64px)]">
            <a href="<?= base_url('dashboard') ?>" class="sidebar-link <?= ($active_menu ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt w-5 text-center"></i> Dashboard
            </a>

            <?php if ($group_name === 'admin'): ?>
            <div class="text-xs text-gray-500 uppercase tracking-wider px-4 pt-4 pb-1">Master</div>
            <a href="<?= base_url('jurusan') ?>" class="sidebar-link"><i class="fas fa-building w-5 text-center"></i> Jurusan</a>
            <a href="<?= base_url('matkul') ?>" class="sidebar-link"><i class="fas fa-book w-5 text-center"></i> Matkul</a>
            <a href="<?= base_url('dosen') ?>" class="sidebar-link"><i class="fas fa-chalkboard-user w-5 text-center"></i> Dosen</a>
            <a href="<?= base_url('kelas') ?>" class="sidebar-link"><i class="fas fa-people-group w-5 text-center"></i> Kelas</a>
            <a href="<?= base_url('mahasiswa') ?>" class="sidebar-link"><i class="fas fa-user-graduate w-5 text-center"></i> Mahasiswa</a>
            <div class="text-xs text-gray-500 uppercase tracking-wider px-4 pt-4 pb-1">Relasi</div>
            <a href="<?= base_url('jurusan-matkul') ?>" class="sidebar-link"><i class="fas fa-link w-5 text-center"></i> Jurusan-Matkul</a>
            <a href="<?= base_url('kelas-dosen') ?>" class="sidebar-link"><i class="fas fa-chalkboard w-5 text-center"></i> Kelas-Dosen</a>
            <div class="text-xs text-gray-500 uppercase tracking-wider px-4 pt-4 pb-1">Lainnya</div>
            <a href="<?= base_url('soal') ?>" class="sidebar-link"><i class="fas fa-question-circle w-5 text-center"></i> Bank Soal</a>
            <a href="<?= base_url('ujian') ?>" class="sidebar-link"><i class="fas fa-pencil-alt w-5 text-center"></i> Ujian</a>
            <a href="<?= base_url('hasil-ujian') ?>" class="sidebar-link"><i class="fas fa-square-poll-vertical w-5 text-center"></i> Hasil Ujian</a>
            <a href="<?= base_url('users') ?>" class="sidebar-link"><i class="fas fa-user-shield w-5 text-center"></i> Users</a>
            <a href="<?= base_url('settings') ?>" class="sidebar-link"><i class="fas fa-cog w-5 text-center"></i> Settings</a>

            <?php elseif ($group_name === 'dosen'): ?>
            <div class="text-xs text-gray-500 uppercase tracking-wider px-4 pt-4 pb-1">Menu</div>
            <a href="<?= base_url('soal') ?>" class="sidebar-link"><i class="fas fa-question-circle w-5 text-center"></i> Bank Soal</a>
            <a href="<?= base_url('ujian') ?>" class="sidebar-link"><i class="fas fa-pencil-alt w-5 text-center"></i> Ujian</a>
            <a href="<?= base_url('kelas-dosen') ?>" class="sidebar-link"><i class="fas fa-chalkboard w-5 text-center"></i> Kelas Saya</a>

            <?php elseif ($group_name === 'mahasiswa'): ?>
            <div class="text-xs text-gray-500 uppercase tracking-wider px-4 pt-4 pb-1">Menu</div>
            <a href="<?= base_url('tes') ?>" class="sidebar-link"><i class="fas fa-pencil-alt w-5 text-center"></i> Ujian</a>
            <a href="<?= base_url('hasil-ujian') ?>" class="sidebar-link"><i class="fas fa-square-poll-vertical w-5 text-center"></i> Hasil Ujian</a>
            <?php endif; ?>
        </nav>
    </aside>

    <!-- Main content area -->
    <div id="main-content" class="lg:ml-64 min-h-screen flex flex-col">
        <!-- Top navbar -->
        <header class="bg-white shadow-sm border-b sticky top-0 z-30">
            <div class="flex items-center justify-between px-4 lg:px-6 py-3">
                <button id="sidebar-toggle" class="lg:hidden text-gray-600 hover:text-gray-900 text-xl">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex items-center gap-4 ml-auto">
                    <span class="text-sm text-gray-600">
                        <i class="fas fa-user-circle mr-1"></i>
                        <?= esc($user_name ?? '') ?>
                    </span>
                    <a href="<?= base_url('logout') ?>" class="text-sm text-red-600 hover:underline">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-4 lg:p-6">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script>
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebar-toggle');
            if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !toggle.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>