<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6"><h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1></div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-lg">
    <form action="<?= base_url($action) ?>" method="post">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($kelas_list as $k): ?>
                <option value="<?= $k->id_kelas ?>"><?= esc($k->nama_kelas) ?> - <?= esc($k->nama_jurusan) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Dosen</label>
            <select name="dosen_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($dosen_list as $d): ?>
                <option value="<?= $d->id_dosen ?>"><?= esc($d->nama_dosen) ?> - <?= esc($d->nama_matkul) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="<?= base_url('kelas-dosen') ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>