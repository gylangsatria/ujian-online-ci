<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600 mt-1">Selamat datang, <?= esc($user_name) ?>!</p>
</div>

<?php if ($group_name === 'admin'): ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Jurusan</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_jurusan ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <i class="fas fa-building text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('jurusan') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Matkul</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_matkul ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('matkul') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Dosen</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_dosen ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('dosen') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Mahasiswa</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_mahasiswa ?></p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('mahasiswa') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Kelas</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_kelas ?></p>
            </div>
            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center text-teal-600">
                <i class="fas fa-users-class text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('kelas') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Ujian</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_ujian ?></p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                <i class="fas fa-pencil-alt text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('ujian') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Bank Soal</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_soal ?></p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                <i class="fas fa-question-circle text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('soal') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-history mr-2 text-gray-500"></i>User Terakhir Login</h3>
        <?php if (!empty($last_login_users)): ?>
        <div class="space-y-3">
            <?php foreach ($last_login_users as $u): ?>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-sm font-medium text-gray-600">
                    <?= strtoupper(substr($u->first_name, 0, 1)) ?>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800"><?= esc($u->first_name . ' ' . $u->last_name) ?></p>
                    <p class="text-xs text-gray-500"><?= date('d M Y H:i', $u->last_login) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-sm text-gray-500">Belum ada aktivitas login.</p>
        <?php endif; ?>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-play-circle mr-2 text-gray-500"></i>Ujian Aktif</h3>
        <?php if (!empty($ujian_aktif)): ?>
        <div class="space-y-3">
            <?php foreach ($ujian_aktif as $u): ?>
            <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                <p class="text-sm font-medium text-gray-800"><?= esc($u->nama_ujian) ?></p>
                <p class="text-xs text-gray-500"><?= esc($u->nama_matkul) ?> — <?= esc($u->nama_dosen) ?></p>
                <p class="text-xs text-gray-400">Token: <span class="font-mono font-bold"><?= esc($u->token) ?></span></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-sm text-gray-500">Tidak ada ujian aktif saat ini.</p>
        <?php endif; ?>
    </div>
</div>

<?php elseif ($group_name === 'dosen'): ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Mata Kuliah</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_matkul ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Bank Soal</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_soal ?></p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                <i class="fas fa-question-circle text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('soal') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Ujian</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_ujian ?></p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                <i class="fas fa-pencil-alt text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('ujian') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Kelas</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_kelas ?></p>
            </div>
            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center text-teal-600">
                <i class="fas fa-users-class text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('kelas-dosen') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Lihat →</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-info-circle mr-2 text-gray-500"></i>Akses Cepat</h3>
    <p class="text-sm text-gray-600 mb-4">Gunakan menu sidebar untuk mengelola bank soal, membuat ujian, dan melihat kelas anda.</p>
    <div class="flex flex-wrap gap-3">
        <a href="<?= base_url('soal') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
            <i class="fas fa-plus"></i> Tambah Soal
        </a>
        <a href="<?= base_url('ujian') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
            <i class="fas fa-pencil-alt"></i> Buat Ujian
        </a>
    </div>
</div>

<?php elseif ($group_name === 'mahasiswa'): ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Ujian Tersedia</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_tersedia ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <i class="fas fa-clipboard-list text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('ujian') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Ikuti →</a>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Ujian Diikuti</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $count_diikuti ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <i class="fas fa-poll text-xl"></i>
            </div>
        </div>
        <a href="<?= base_url('hasil-ujian') ?>" class="text-sm text-blue-600 hover:underline mt-3 inline-block">Lihat →</a>
    </div>
</div>

<?php if ($nilai_terakhir): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-star mr-2 text-yellow-500"></i>Nilai Terakhir</h3>
    <div class="flex items-center gap-6">
        <div class="text-center">
            <div class="text-4xl font-bold <?= $nilai_terakhir->nilai >= 60 ? 'text-green-600' : 'text-red-600' ?>">
                <?= esc(number_format((float)$nilai_terakhir->nilai, 0)) ?>
            </div>
            <p class="text-xs text-gray-500 mt-1">Nilai</p>
        </div>
        <div>
            <p class="font-medium text-gray-800"><?= esc($nilai_terakhir->nama_ujian) ?></p>
            <p class="text-sm text-gray-500"><?= date('d M Y H:i', strtotime($nilai_terakhir->tgl_selesai)) ?></p>
        </div>
    </div>
</div>
<?php else: ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-info-circle mr-2 text-gray-500"></i>Belum Ada Ujian</h3>
    <p class="text-sm text-gray-600">Anda belum mengikuti ujian apapun. Silakan cek halaman Ujian untuk melihat ujian yang tersedia.</p>
    <a href="<?= base_url('ujian') ?>" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
        <i class="fas fa-pencil-alt"></i> Lihat Ujian Tersedia
    </a>
</div>
<?php endif; ?>

<?php endif; ?>

<?= $this->endSection() ?>
