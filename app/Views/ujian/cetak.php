<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18pt; }
        .header p { margin: 5px 0 0; font-size: 10pt; }
        .content { margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .info-table td.label { width: 150px; font-weight: bold; }
        .info-table td.separator { width: 10px; }
        .result-box { border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9; text-align: center; margin-bottom: 20px; }
        .result-box .score { font-size: 36pt; font-bold: bold; color: #2c3e50; margin: 10px 0; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; color: #777; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN HASIL UJIAN</h1>
        <p>Sistem Ujian Online - Universitas Contoh</p>
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td class="label">NIM</td>
                <td class="separator">:</td>
                <td><?= $hasil->nim ?></td>
            </tr>
            <tr>
                <td class="label">Nama Mahasiswa</td>
                <td class="separator">:</td>
                <td><?= $hasil->nama_mahasiswa ?></td>
            </tr>
            <tr>
                <td class="label">Mata Kuliah</td>
                <td class="separator">:</td>
                <td><?= $hasil->nama_matkul ?></td>
            </tr>
            <tr>
                <td class="label">Nama Ujian</td>
                <td class="separator">:</td>
                <td><?= $hasil->nama_ujian ?></td>
            </tr>
            <tr>
                <td class="label">Waktu Mulai</td>
                <td class="separator">:</td>
                <td><?= date('d/m/Y H:i', strtotime($hasil->tgl_mulai)) ?></td>
            </tr>
            <tr>
                <td class="label">Waktu Selesai</td>
                <td class="separator">:</td>
                <td><?= date('d/m/Y H:i', strtotime($hasil->tgl_selesai)) ?></td>
            </tr>
        </table>

        <div class="result-box">
            <div>NILAI AKHIR</div>
            <div class="score"><?= number_format($hasil->nilai, 2) ?></div>
            <div>
                Total Soal: <?= $hasil->jumlah_soal ?> | 
                Jawaban Benar: <?= $hasil->jml_benar ?>
            </div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada: <?= date('d/m/Y H:i:s') ?> | Dokumen ini sah dan diterbitkan oleh sistem.
    </div>
</body>
</html>