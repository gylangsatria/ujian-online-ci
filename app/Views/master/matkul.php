<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Mata Kuliah</h1>
        <p class="text-gray-600 mt-1">Kelola data mata kuliah</p>
    </div>
    <a href="<?= base_url('matkul/create') ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
        <i class="fas fa-plus mr-1"></i> Tambah Matkul
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left p-3 font-medium text-gray-600">#</th>
                <th class="text-left p-3 font-medium text-gray-600">Nama Matkul</th>
                <th class="text-center p-3 font-medium text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $i = 1; foreach ($matkul as $row): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-3 text-gray-500"><?= $i++ ?></td>
                <td class="p-3 font-medium text-gray-800"><?= esc($row->nama_matkul) ?></td>
                <td class="p-3 text-center">
                    <a href="<?= base_url('matkul/update/' . $row->id_matkul) ?>" class="inline-block px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 mr-1"><i class="fas fa-edit"></i> Edit</a>
                    <a href="<?= base_url('matkul/delete/' . $row->id_matkul) ?>" class="inline-block px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($matkul)): ?>
            <tr><td colspan="3" class="p-6 text-center text-gray-500">Belum ada data matkul.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>