<?php
/**
 * @var \App\Models\UjianModel $ujian
 */
?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1>
        <p class="text-gray-600 mt-1">Update jadwal ujian.</p>
    </div>
    <a href="<?= base_url('ujian') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition-colors">
        <i class="fas fa-arrow-left"></i> Batal
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8">
        <form action="<?= base_url('ujian/save') ?>" method="post" class="space-y-4">
            <input type="hidden" name="id_ujian" value="<?= $ujian->id_ujian ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="dosen_id" class="text-sm font-medium text-gray-700">Dosen Pengampu</label>
                    <select name="dosen_id" id="dosen_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" required>
                        <?php foreach ($dosen as $d) : ?>
                            <option value="<?= $d->id_dosen ?>" <?= $d->id_dosen == $ujian->dosen_id ? 'selected' : '' ?>><?= $d->nama_dosen ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="matkul_id" class="text-sm font-medium text-gray-700">Mata Kuliah</label>
                    <select name="matkul_id" id="matkul_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" required>
                        <?php foreach ($matkul as $m) : ?>
                            <option value="<?= $m->id_matkul ?>" <?= $m->id_matkul == $ujian->matkul_id ? 'selected' : '' ?>><?= $m->nama_matkul ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nama_ujian" class="text-sm font-medium text-gray-700">Nama Ujian</label>
                <input type="text" name="nama_ujian" id="nama_ujian" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: UTS Alpro Semester Ganjil" value="<?= esc($ujian->nama_ujian) ?>" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="jumlah_soal" class="text-sm font-medium text-gray-700">Jumlah Soal</label>
                    <input type="number" name="jumlah_soal" id="jumlah_soal" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Jumlah butir soal" value="<?= esc($ujian->jumlah_soal) ?>" required>
                </div>
                <div class="space-y-1">
                    <label for="waktu" class="text-sm font-medium text-gray-700">Waktu (Menit)</label>
                    <input type="number" name="waktu" id="waktu" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Durasi pengerjaan" value="<?= esc($ujian->waktu) ?>" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="tgl_mulai" class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="datetime-local" name="tgl_mulai" id="tgl_mulai" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="<?= date('Y-m-d\TH:i', strtotime($ujian->tgl_mulai)) ?>" required>
                </div>
                <div class="space-y-1">
                    <label for="terlambat" class="text-sm font-medium text-gray-700">Batas Terlambat</label>
                    <input type="datetime-local" name="terlambat" id="terlambat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="<?= date('Y-m-d\TH:i', strtotime($ujian->terlambat)) ?>" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="jenis" class="text-sm font-medium text-gray-700">Metode Pengacakan</label>
                    <select name="jenis" id="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" required>
                        <option value="acak" <?= $ujian->jenis == 'acak' ? 'selected' : '' ?>>Acak Soal</option>
                        <option value="urut" <?= $ujian->jenis == 'urut' ? 'selected' : '' ?>>Urut Sesuai Input</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="token" class="text-sm font-medium text-gray-700">Token Ujian</label>
                    <input type="text" name="token" id="token" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg font-mono font-bold text-blue-600 outline-none" value="<?= esc($ujian->token) ?>" readonly>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition-colors focus:ring-4 focus:ring-blue-200">
                    <i class="fas fa-save mr-1"></i> Update Jadwal Ujian
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>