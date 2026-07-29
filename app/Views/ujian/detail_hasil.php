<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800"><?= $title ?></h2>
        <a href="<?= base_url('hasilujian') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Mahasiswa</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-500 font-medium w-1/3">NIM</td>
                    <td class="py-2 text-gray-800"><?= $hasil->nim ?></td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500 font-medium">Nama</td>
                    <td class="py-2 text-gray-800"><?= $hasil->nama_mahasiswa ?></td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500 font-medium">Mata Kuliah</td>
                    <td class="py-2 text-gray-800"><?= $hasil->nama_matkul ?></td>
                </tr>
            </table>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Ujian</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-500 font-medium w-1/3">Ujian</td>
                    <td class="py-2 text-gray-800"><?= $hasil->nama_ujian ?></td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500 font-medium">Mulai</td>
                    <td class="py-2 text-gray-800"><?= date('d/m/Y H:i', strtotime($hasil->tgl_mulai)) ?></td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500 font-medium">Selesai</td>
                    <td class="py-2 text-gray-800"><?= date('d/m/Y H:i', strtotime($hasil->tgl_selesai)) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="bg-gray-50 rounded-xl p-8 border border-gray-200 text-center">
        <h4 class="text-gray-500 uppercase tracking-wider font-semibold text-sm mb-2">Nilai Akhir</h4>
        <div class="text-6xl font-black text-blue-600 mb-4"><?= number_format($hasil->nilai, 2) ?></div>
        <div class="flex justify-center gap-6 text-gray-600">
            <div class="flex flex-col">
                <span class="font-bold text-gray-800 text-xl"><?= $hasil->jumlah_soal ?></span>
                <span class="text-xs uppercase">Total Soal</span>
            </div>
            <div class="border-r border-gray-300"></div>
            <div class="flex flex-col">
                <span class="font-bold text-green-600 text-xl"><?= $hasil->jml_benar ?></span>
                <span class="text-xs uppercase text-green-600">Benar</span>
            </div>
            <div class="border-r border-gray-300"></div>
            <div class="flex flex-col">
                <span class="font-bold text-red-600 text-xl"><?= $hasil->jumlah_soal - $hasil->jml_benar ?></span>
                <span class="text-xs uppercase text-red-600">Salah</span>
            </div>
        </div>
        <div class="mt-8">
            <a href="<?= base_url('hasilujian/cetak/' . $hasil->id) ?>" target="_blank" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold inline-flex items-center gap-2 transition-all">
                <i class="fa-solid fa-file-pdf"></i> Cetak Hasil (PDF)
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>