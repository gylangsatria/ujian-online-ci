<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6"><h1 class="text-2xl font-bold text-gray-800">Import Soal (Excel)</h1></div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-xl">
    <form action="<?= base_url('soal/import') ?>" method="post" enctype="multipart/form-data">
        <?php if ($group_name === 'admin'): ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Dosen</label>
            <select name="dosen_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($dosen_list as $d): ?>
                <option value="<?= $d->id_dosen ?>"><?= esc($d->nama_dosen) ?> (<?= esc($d->nama_matkul ?? '-') ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Matkul</label>
            <select name="matkul_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($matkul_list as $m): ?>
                <option value="<?= $m->id_matkul ?>"><?= esc($m->nama_matkul) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Bobot (default untuk semua soal)</label>
            <input type="number" name="bobot" min="1" max="99" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">File Excel</label>
            <input type="file" name="file_excel" accept=".xlsx,.xls" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
            <p class="text-xs text-gray-500 mt-2">
                Format: kolom A=Soal, B=Opsi A, C=Opsi B, D=Opsi C, E=Opsi D, F=Opsi E, G=Jawaban (A/B/C/D/E). Baris pertama = header (akan dilewati).
                <a href="<?= base_url('soal/template') ?>" class="text-blue-600 hover:underline">Download template</a>
            </p>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700"><i class="fas fa-upload mr-1"></i> Import</button>
            <a href="<?= base_url('soal') ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>