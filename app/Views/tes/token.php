<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= esc($title) ?></h1>
    <p class="text-gray-600 mt-1">Konfirmasi data pengerjaan ujian.</p>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 lg:p-8">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Ujian</p>
                        <p class="text-lg font-bold text-gray-900"><?= esc($ujian->nama_ujian) ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mata Kuliah</p>
                        <p class="text-lg font-bold text-gray-900"><?= esc($ujian->nama_matkul) ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dosen Pengampu</p>
                        <p class="text-lg font-bold text-gray-900"><?= esc($ujian->nama_dosen) ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Durasi & Soal</p>
                        <p class="text-lg font-bold text-gray-900"><?= esc($ujian->waktu) ?> Menit / <?= esc($ujian->jumlah_soal) ?> Soal</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <label for="token" class="block text-sm font-medium text-gray-700 mb-2 text-center">Masukkan Token Ujian</label>
                    <div class="relative max-w-xs mx-auto">
                        <input type="text" name="token" id="token" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none text-center font-mono text-2xl font-bold text-blue-600 tracking-widest placeholder:text-gray-200" 
                               placeholder="XXXXX" required>
                    </div>
                    <input type="hidden" name="id_ujian" id="id_ujian" value="<?= $ujian->id_ujian ?>">
                </div>
            </div>
        </div>
        <div class="p-6 bg-gray-50 border-t border-gray-200 flex flex-col md:flex-row gap-3">
            <a href="<?= base_url('tes') ?>" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2 text-gray-400"></i> Kembali
            </a>
            <button id="btn-mulai" class="flex-[2] inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                Mulai Ujian <i class="fas fa-play ml-2"></i>
            </button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btn-mulai').click(function() {
        let token = $('#token').val();
        let id_ujian = $('#id_ujian').val();
        
        if (token == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Token Kosong',
                text: 'Silakan masukkan token ujian terlebih dahulu.'
            });
            return false;
        }

        $(this).attr('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...');

        $.ajax({
            url: "<?= base_url('tes/cek_token') ?>",
            type: "POST",
            data: {id_ujian: id_ujian, token: token},
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Token Valid',
                        text: 'Menyiapkan lembar ujian...',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "<?= base_url('tes/mulai') ?>/" + id_ujian;
                    });
                } else {
                    $('#btn-mulai').attr('disabled', false).html('Mulai Ujian <i class="fas fa-play ml-2"></i>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Token Salah',
                        text: 'Token yang anda masukkan tidak valid.'
                    });
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>