<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6"><h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1></div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="<?= base_url($action) ?>" method="post" enctype="multipart/form-data">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
            <?php if ($group_name === 'admin'): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dosen</label>
                    <select name="dosen_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($dosen_list as $d): ?>
                        <option value="<?= $d->id_dosen ?>" <?= (isset($row) && $row->dosen_id == $d->id_dosen) ? 'selected' : '' ?>><?= esc($d->nama_dosen) ?> (<?= esc($d->nama_matkul ?? '-') ?>)</option>
                        <?php endforeach; ?>
                    </select>
            </div>
            <?php endif; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Matkul</label>
                <select name="matkul_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($matkul_list as $m): ?>
                    <option value="<?= $m->id_matkul ?>" <?= (isset($row) && $row->matkul_id == $m->id_matkul) ? 'selected' : '' ?>><?= esc($m->nama_matkul) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bobot</label>
                <input type="number" name="bobot" min="1" max="99" value="<?= isset($row) ? esc($row->bobot) : '1' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Soal</label>
            <textarea name="soal" id="summernote" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" rows="5"><?= isset($row) ? $row->soal : '' ?></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">File Soal (gambar/doc)</label>
            <input type="file" name="file" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <?php if (isset($row) && !empty($row->file)): ?>
            <p class="text-xs text-gray-500 mt-1">File saat ini: <?= esc($row->file) ?> (<a href="<?= base_url('uploads/soal/' . $row->file) ?>" target="_blank" class="text-blue-600">lihat</a>)</p>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-4">
            <?php $optLabels = ['A', 'B', 'C', 'D', 'E']; ?>
            <?php foreach ($optLabels as $opt): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Opsi <?= $opt ?></label>
                <textarea name="opsi_<?= strtolower($opt) ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= isset($row) ? $row->{'opsi_' . strtolower($opt)} : '' ?></textarea>
                <input type="file" name="file_<?= strtolower($opt) ?>" class="w-full text-xs text-gray-600 mt-1 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                <?php if (isset($row) && !empty($row->{'file_' . strtolower($opt)})): ?>
                <p class="text-xs text-gray-500 mt-1"><a href="<?= base_url('uploads/soal/' . $row->{'file_' . strtolower($opt)}) ?>" target="_blank" class="text-blue-600">file</a></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban Benar</label>
            <div class="flex gap-4">
                <?php foreach ($optLabels as $opt): ?>
                <label class="flex items-center gap-1 text-sm">
                    <input type="radio" name="jawaban" value="<?= $opt ?>" <?= (isset($row) && $row->jawaban === $opt) ? 'checked' : '' ?> required>
                    <?= $opt ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="<?= base_url('soal') ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
$(function() {
    $('#summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview']],
        ]
    });
});
</script>
<?= $this->endSection() ?>