<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Bank Soal</h1>
        <p class="text-gray-600 mt-1">Kelola bank soal</p>
    </div>
    <div class="flex gap-2">
        <a href="<?= base_url('soal/import') ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
            <i class="fas fa-upload mr-1"></i> Import Excel
        </a>
        <a href="<?= base_url('soal/export') ?>" class="px-4 py-2 bg-cyan-600 text-white rounded-lg text-sm hover:bg-cyan-700" target="_blank">
            <i class="fas fa-download mr-1"></i> Export Excel
        </a>
        <a href="<?= base_url('soal/create') ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah Soal
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left p-3 font-medium text-gray-600">#</th>
                <th class="text-left p-3 font-medium text-gray-600">Soal</th>
                <th class="text-left p-3 font-medium text-gray-600">Matkul</th>
                <th class="text-left p-3 font-medium text-gray-600">Dosen</th>
                <th class="text-center p-3 font-medium text-gray-600">Bobot</th>
                <th class="text-center p-3 font-medium text-gray-600">Jawaban</th>
                <th class="text-center p-3 font-medium text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $i = 1; foreach ($soal as $row): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-3 text-gray-500"><?= $i++ ?></td>
                <td class="p-3 max-w-xs">
                    <div class="truncate text-gray-800 font-medium"><?= esc(strip_tags($row->soal)) ?></div>
                    <?php if (!empty($row->file)): ?>
                    <span class="text-xs text-blue-600"><i class="fas fa-paperclip mr-1"></i>ada file</span>
                    <?php endif; ?>
                </td>
                <td class="p-3 text-gray-600"><?= esc($row->nama_matkul ?? '-') ?></td>
                <td class="p-3 text-gray-600"><?= esc($row->nama_dosen ?? '-') ?></td>
                <td class="p-3 text-center text-gray-600"><?= $row->bobot ?></td>
                <td class="p-3 text-center">
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded text-xs font-bold"><?= esc($row->jawaban) ?></span>
                </td>
                <td class="p-3 text-center">
                    <a href="<?= base_url('soal/update/' . $row->id_soal) ?>" class="inline-block px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 mr-1"><i class="fas fa-edit"></i></a>
                    <a href="<?= base_url('soal/delete/' . $row->id_soal) ?>" class="inline-block px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700" onclick="return confirm('Yakin hapus soal ini?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($soal)): ?>
            <tr><td colspan="7" class="p-6 text-center text-gray-500">Belum ada soal.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>