<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1>
    <p class="text-gray-600 mt-1">Daftar ujian yang tersedia untuk anda ikuti.</p>
</div>

<?php if (empty($ujian)): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
        <i class="fas fa-clipboard-list text-2xl"></i>
    </div>
    <h3 class="text-lg font-medium text-gray-800">Tidak ada ujian tersedia</h3>
    <p class="text-gray-500 mt-1">Belum ada jadwal ujian yang ditugaskan untuk anda saat ini.</p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($ujian as $u) : ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
        <div class="p-6 flex-1">
            <div class="flex justify-between items-start mb-4">
                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded uppercase tracking-wider">
                    <?= esc($u->nama_matkul) ?>
                </span>
                <div class="flex items-center text-gray-400 text-xs">
                    <i class="far fa-clock mr-1"></i> <?= esc($u->waktu) ?>m
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight"><?= esc($u->nama_ujian) ?></h3>
            <p class="text-sm text-gray-500 mb-4">
                <i class="fas fa-chalkboard-user mr-1 text-gray-400"></i> <?= esc($u->nama_dosen) ?>
            </p>
            <div class="space-y-2 border-t border-gray-100 pt-4 mt-auto">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Jumlah Soal</span>
                    <span class="font-semibold text-gray-800"><?= esc($u->jumlah_soal) ?> Butir</span>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Mulai</span>
                    <span class="font-semibold text-gray-800"><?= date('d/m/Y H:i', strtotime($u->tgl_mulai)) ?></span>
                </div>
            </div>
        </div>
        <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
            <a href="<?= base_url('tes/token/' . $u->id_ujian) ?>" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                <i class="fas fa-pencil-alt"></i> Kerjakan Sekarang
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?= $this->endSection() ?>