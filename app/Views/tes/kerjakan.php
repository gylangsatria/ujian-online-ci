<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col lg:flex-row gap-6">
    <!-- Main Exam Area -->
    <div class="flex-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Pertanyaan Ke <span id="soal-no" class="text-blue-600">1</span></h3>
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock text-red-500"></i>
                    <span class="font-mono font-bold text-lg text-gray-700" id="timer">00:00:00</span>
                </div>
            </div>
            
            <div class="p-6 lg:p-8">
                <form id="form-ujian">
                    <input type="hidden" name="id_hasil" id="id_hasil" value="<?= $hasil->id ?>">
                    <?php $no = 1; foreach ($soal as $s) : ?>
                        <div class="soal-item space-y-6" id="soal-<?= $no ?>" style="<?= $no > 1 ? 'display:none' : '' ?>">
                            <div class="text-lg text-gray-800 leading-relaxed font-medium">
                                <?= $s->soal ?>
                            </div>
                            
                            <div class="space-y-3">
                                <?php foreach (['A', 'B', 'C', 'D', 'E'] as $opt) : ?>
                                    <?php $opsi_key = 'opsi_' . strtolower($opt); ?>
                                    <label class="flex items-center p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition-all group">
                                        <input type="radio" name="jawaban_<?= $s->id_soal ?>" class="opt-input w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300" 
                                            data-soal="<?= $s->id_soal ?>" value="<?= $opt ?>"
                                            <?= (isset($jawaban[$s->id_soal]) && $jawaban[$s->id_soal] == $opt) ? 'checked' : '' ?>>
                                        <span class="ml-4 text-gray-700 group-hover:text-blue-700">
                                            <span class="font-bold mr-2"><?= $opt ?>.</span> <?= $s->$opsi_key ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php $no++; endforeach; ?>
                </form>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                <button class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors" id="btn-prev" disabled>
                    <i class="fas fa-chevron-left mr-2"></i> Sebelumnya
                </button>
                
                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors" id="btn-next">
                    Selanjutnya <i class="fas fa-chevron-right ml-2"></i>
                </button>
                
                <button class="px-8 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors hidden" id="btn-selesai">
                    Selesai Ujian <i class="fas fa-check-double ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="w-full lg:w-80">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Navigasi Soal</h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-5 gap-2" id="navigasi-container">
                    <?php for ($i = 1; $i < $no; $i++) : ?>
                        <button class="h-10 w-full flex items-center justify-center rounded-lg border-2 text-sm font-bold transition-all btn-nav <?= isset($jawaban[$soal[$i-1]->id_soal]) && $jawaban[$soal[$i-1]->id_soal] != 'N' ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-200 text-gray-400 hover:border-blue-200 hover:text-blue-600' ?>" 
                            data-no="<?= $i ?>" id="nav-<?= $i ?>">
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                    <div class="flex items-center text-xs text-gray-500">
                        <span class="w-3 h-3 bg-blue-600 rounded-full mr-2"></span> Terjawab
                    </div>
                    <div class="flex items-center text-xs text-gray-500">
                        <span class="w-3 h-3 bg-white border-2 border-gray-200 rounded-full mr-2"></span> Belum Dijawab
                    </div>
                    <div class="flex items-center text-xs text-gray-500">
                        <span class="w-3 h-3 bg-white border-2 border-blue-600 rounded-full mr-2"></span> Sedang Dibuka
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let currentSoal = 1;
    let totalSoal = <?= count($soal) ?>;

    function updateNavActive(n) {
        $('.btn-nav').removeClass('border-blue-600 ring-2 ring-blue-100');
        $('#nav-' + n).addClass('border-blue-600 ring-2 ring-blue-100');
    }

    function showSoal(n) {
        $('.soal-item').hide();
        $('#soal-' + n).show();
        $('#soal-no').text(n);
        
        updateNavActive(n);

        if (n == 1) $('#btn-prev').attr('disabled', true);
        else $('#btn-prev').attr('disabled', false);

        if (n == totalSoal) {
            $('#btn-next').addClass('hidden');
            $('#btn-selesai').removeClass('hidden');
        } else {
            $('#btn-next').removeClass('hidden');
            $('#btn-selesai').addClass('hidden');
        }
        currentSoal = n;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    $('#btn-next').click(function() {
        if (currentSoal < totalSoal) showSoal(currentSoal + 1);
    });

    $('#btn-prev').click(function() {
        if (currentSoal > 1) showSoal(currentSoal - 1);
    });

    $('.btn-nav').click(function() {
        showSoal($(this).data('no'));
    });

    $('.opt-input').change(function() {
        let id_soal = $(this).data('soal');
        let jawaban = $(this).val();
        let id_hasil = $('#id_hasil').val();
        
        $('#nav-' + currentSoal).addClass('bg-blue-600 border-blue-600 text-white').removeClass('text-gray-400');
        
        // Visual feedback
        $(this).closest('label').addClass('bg-blue-50 border-blue-200 ring-2 ring-blue-100');
        $(this).closest('.soal-item').find('label').not($(this).closest('label')).removeClass('bg-blue-50 border-blue-200 ring-2 ring-blue-100');

        $.ajax({
            url: "<?= base_url('tes/simpan_satu') ?>",
            type: "POST",
            data: {id_hasil: id_hasil, id_soal: id_soal, jawaban: jawaban},
            dataType: "json"
        });
    });

    $('#btn-selesai').click(function() {
        Swal.fire({
            title: 'Selesai Ujian?',
            text: "Pastikan semua jawaban telah terisi. Anda tidak dapat kembali setelah ini!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let id_hasil = $('#id_hasil').val();
                let form = $('<form action="<?= base_url('tes/selesai') ?>" method="post">' +
                    '<input type="hidden" name="id_hasil" value="' + id_hasil + '">' +
                    '</form>');
                $('body').append(form);
                form.submit();
            }
        });
    });

    // Initial Nav State
    updateNavActive(1);

    // Timer
    let targetDate = new Date("<?= $hasil->tgl_selesai ?>").getTime();
    let x = setInterval(function() {
        let now = new Date().getTime();
        let distance = targetDate - now;
        
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        let timerStr = (hours < 10 ? "0" + hours : hours) + ":" + 
                       (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                       (seconds < 10 ? "0" + seconds : seconds);
        
        $("#timer").text(timerStr);
        
        if (distance < 0) {
            clearInterval(x);
            $("#timer").text("WAKTU HABIS");
            Swal.fire({
                title: 'Waktu Habis!',
                text: 'Ujian akan dihentikan secara otomatis.',
                icon: 'warning',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                let id_hasil = $('#id_hasil').val();
                let form = $('<form action="<?= base_url('tes/selesai') ?>" method="post">' +
                    '<input type="hidden" name="id_hasil" value="' + id_hasil + '">' +
                    '</form>');
                $('body').append(form);
                form.submit();
            });
        }
    }, 1000);
});
</script>
<?= $this->endSection() ?>