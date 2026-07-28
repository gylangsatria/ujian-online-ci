<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1>
        <p class="text-gray-600 mt-1">Kelola jadwal dan token ujian.</p>
    </div>
    <a href="<?= base_url('ujian/add') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
        <i class="fas fa-plus"></i> Tambah Ujian
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">No.</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">Nama Ujian</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">Mata Kuliah</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Soal</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Waktu</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">Token</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $no = 1; foreach ($ujian as $u) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-600"><?= $no++ ?></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= esc($u->nama_ujian) ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <div class="font-medium text-gray-800"><?= esc($u->nama_matkul) ?></div>
                        <div class="text-xs text-gray-500"><?= esc($u->nama_dosen) ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm text-center text-gray-600"><?= esc($u->jumlah_soal) ?></td>
                    <td class="px-6 py-4 text-sm text-center text-gray-600"><?= esc($u->waktu) ?>m</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <code class="px-2 py-1 bg-gray-100 rounded text-blue-600 font-bold font-mono token-box"><?= esc($u->token) ?></code>
                            <button class="p-1 text-gray-400 hover:text-blue-600 btn-refresh" data-id="<?= $u->id_ujian ?>" title="Refresh Token">
                                <i class="fas fa-sync-alt text-xs"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?= base_url('ujian/delete/' . $u->id_ujian) ?>" 
                               class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                               onclick="return confirm('Hapus ujian ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($ujian)): ?>
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">Belum ada data ujian.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-refresh').click(function() {
        let id = $(this).data('id');
        let btn = $(this);
        let icon = btn.find('i');
        
        icon.addClass('fa-spin');
        
        $.ajax({
            url: "<?= base_url('ujian/token') ?>/" + id,
            type: "GET",
            dataType: "json",
            success: function(data) {
                btn.siblings('.token-box').text(data.token);
                icon.removeClass('fa-spin');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Token Diperbarui',
                    text: 'Token baru: ' + data.token,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>