<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800"><?= $title ?></h2>
    </div>

    <div class="overflow-x-auto">
        <table id="table-hasil" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 border-b font-semibold text-gray-700">No.</th>
                    <th class="px-4 py-3 border-b font-semibold text-gray-700">Nama Ujian</th>
                    <th class="px-4 py-3 border-b font-semibold text-gray-700">Mata Kuliah</th>
                    <?php if (session()->get('user_group') != 'mahasiswa') : ?>
                        <th class="px-4 py-3 border-b font-semibold text-gray-700">Mahasiswa</th>
                    <?php endif; ?>
                    <th class="px-4 py-3 border-b font-semibold text-gray-700 text-center">Jumlah Soal</th>
                    <th class="px-4 py-3 border-b font-semibold text-gray-700 text-center">Benar</th>
                    <th class="px-4 py-3 border-b font-semibold text-gray-700 text-center">Nilai</th>
                    <th class="px-4 py-3 border-b font-semibold text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($hasil as $row) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 border-b text-gray-600"><?= $no++ ?></td>
                        <td class="px-4 py-3 border-b text-gray-600 font-medium"><?= $row->nama_ujian ?></td>
                        <td class="px-4 py-3 border-b text-gray-600"><?= $row->nama_matkul ?></td>
                        <?php if (session()->get('user_group') != 'mahasiswa') : ?>
                            <td class="px-4 py-3 border-b text-gray-600"><?= $row->nama_mahasiswa ?> (<?= $row->nim ?>)</td>
                        <?php endif; ?>
                        <td class="px-4 py-3 border-b text-gray-600 text-center"><?= $row->jumlah_soal ?></td>
                        <td class="px-4 py-3 border-b text-gray-600 text-center"><?= $row->jml_benar ?></td>
                        <td class="px-4 py-3 border-b text-center">
                            <span class="px-2 py-1 rounded text-sm font-semibold <?= $row->nilai >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                <?= number_format($row->nilai, 2) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 border-b text-center">
                            <div class="flex justify-center gap-2">
                                <a href="<?= base_url('hasilujian/detail/' . $row->id) ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                                <a href="<?= base_url('hasilujian/cetak/' . $row->id) ?>" target="_blank" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                                    <i class="fa-solid fa-file-pdf"></i> PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table-hasil').DataTable({
            dom: '<"flex flex-col md:flex-row justify-between gap-4 mb-4"f l>rt<"flex flex-col md:flex-row justify-between items-center gap-4 mt-4"i p>',
            language: {
                search: "",
                searchPlaceholder: "Cari hasil...",
                lengthMenu: "_MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    next: '<i class="fa-solid fa-chevron-right text-xs"></i>',
                    previous: '<i class="fa-solid fa-chevron-left text-xs"></i>'
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>