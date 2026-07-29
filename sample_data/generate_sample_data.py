#!/usr/bin/env python3
"""Generate sample data SQL for ujian-online-ci system."""

import os
import random

random.seed(42)

# Fixed bcrypt hashes (cost=10) - works with PHP password_verify
HASH_ADMIN = "$2y$10$qVSPvyDpXbT81LyOw8MNkek9RpPImEaaVMDnOkLE62BMbiXbyNNHS"
HASH_DOSEN = "$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy"
HASH_MAHASISWA = "$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO"

now_ts = 1722000000

# ---------- DATA ----------
jurusan = [
    (1, "Sistem Informasi"),
    (2, "Teknik Informatika"),
    (3, "Manajemen Informatika"),
]

matkul = [
    (1, "Basis Data", 1),
    (2, "Analisis Sistem", 1),
    (3, "Manajemen Proyek", 1),
    (4, "E-commerce", 1),
    (5, "Interaksi Manusia Komputer", 1),
    (6, "Algoritma & Struktur Data", 2),
    (7, "Jaringan Komputer", 2),
    (8, "Sistem Operasi", 2),
    (9, "Pemrograman Web", 2),
    (10, "Keamanan Informasi", 2),
    (11, "Pemrograman Dasar", 3),
    (12, "Multimedia", 3),
    (13, "Akuntansi Dasar", 3),
    (14, "Sistem Informasi Manajemen", 3),
    (15, "Desain Grafis", 3),
]

# Nama dosen
dosen_names = [
    ("Dr. Ahmad Fauzi, M.Kom", "ahmad.fauzi@univ.ac.id"),
    ("Dr. Siti Rahmawati, M.T", "siti.rahmawati@univ.ac.id"),
    ("Bambang Supriyadi, S.Kom, M.Cs", "bambang.supriyadi@univ.ac.id"),
    ("Dewi Sartika, S.Si, M.T", "dewi.sartika@univ.ac.id"),
    ("Eko Prasetyo, S.Kom, M.Eng", "eko.prasetyo@univ.ac.id"),
    ("Fitri Handayani, S.T, M.Kom", "fitri.handayani@univ.ac.id"),
    ("Gunawan Wijaya, S.Kom, M.M", "gunawan.wijaya@univ.ac.id"),
    ("Hendra Gunawan, S.T, M.Kom", "hendra.gunawan@univ.ac.id"),
    ("Indah Permata Sari, S.Kom, M.Cs", "indah.permata@univ.ac.id"),
    ("Joko Susilo, S.Si, M.T", "joko.susilo@univ.ac.id"),
]

# Nama mahasiswa (200 nama Indonesia)
first_names = ["Ahmad","Budi","Citra","Dedi","Eka","Fajar","Gita","Hadi","Indah","Joko",
    "Kurnia","Lilis","Mega","Nanda","Oscar","Putri","Rina","Siska","Teguh","Umi",
    "Vina","Wawan","Yanti","Adi","Bayu","Cindy","Dimas","Erna","Feri","Galuh",
    "Herman","Intan","Jaya","Komang","Lina","Maya","Novi","Oman","Puji","Rizky",
    "Sri","Tata","Ujang","Vivi","Winda","Yuda","Agus","Bunga","Dwi","Eko",
    "Fanny","Gusti","Hana","Irwan","Juni","Kadek","Lisa","Made","Nina","Opik",
    "Pasha","Ratna","Sari","Tono","Utami","Wahyu","Yuni","Ayu","Bagus","Dian",
    "Euis","Fajar","Gilang","Heru","Ida","Jamil","Kiki","Lukman","Mira","Nana",
    "Okta","Pipit","Rudi","Santi","Taufik","Uci","Wulan","Yoga","Andi","Bella",
    "Candra","Desi","Edi","Fani","Galih","Hesti","Iwan","Jihan","Kartika","Lala",
    "Maman","Nia","Oki","Pramono","Rian","Sinta","Tomas","Umar","Winda","Yayan",
    "Arif","Betty","Cici","Doni","Eva","Fauzi","Gina","Hendra","Ina","Jefri",
    "Krisna","Leni","Mimi","Nizar","Olla","Pandi","Rini","Susanti","Tedi","Ulfah",
    "Vera","Wasis","Yeni","Aliya","Bima","Cici","Dani","Elen","Fikri","Geby",
    "Hasan","Ilham","Juli","Kevin","Linda","Mario","Niken","Olga","Pandu","Rama",
    "Siska","Tari","Ucok","Vania","Willy","Yuni","Ardi","Bunga","Caca","Dodo",
    "Endah","Fandi","Gilang","Hani","Iqbal","Jesika","Kurni","Laras","Momon","Nadya",
    "Oji","Putu","Risa","Santi","Tio","Uswa","Vina","Wira","Yani","Aditya",
    "Boni","Citra","Dania","Ewin","Fany","Geri","Hesti","Intan","Jordi","Kamil",
    "Laily","Mila","Novan","Oni","Panca","Rere","Sena","Tika","Ucok","Via"]

last_names = ["Santoso","Wijaya","Kusuma","Pratama","Setiawan","Purnama","Hidayat","Saputra","Utami","Wulandari",
    "Siregar","Ginting","Sitompul","Siburian","Manurung","Simanjuntak","Nainggolan","Sinaga","Siahaan","Situmeang",
    "Sembiring","Tarigan","Purba","Sihombing","Rajagukguk","Simatupang","Marpaung","Lumbantobing","Hutapea","Sitanggang",
    "Nasution","Harahap","Lubis","Hasibuan","Siregar","Daulay","Ritonga","Siregar","Dalimunthe","Siregar",
    "Nugroho","Susanto","Halim","Salim","Lim","Tan","Gunawan","Sulaiman","Iskandar","Darmawan",
    "Herman","Yulianto","Hartono","Santoso","Wibowo","Suryanto","Cahyono","Prabowo","Winarto","Suharto",
    "", "", "", "", "", "", "", "", "", ""]

# NIM prefix
nim_prefixes = ["121","122","123","124","125","131","132","133","134","135","141","142","143","144","145"]

# Kelas names
kelas_per_jurusan = {
    1: ["12.1E.01", "12.1E.02", "12.1E.03", "11.1E.01"],
    2: ["12.1A.01", "12.1A.02", "11.1A.01", "11.1A.02"],
    3: ["12.1B.01", "12.1B.02", "11.1B.01"],
}

# ---------- BUILD SQL ----------
lines = []
def L(s=""):
    lines.append(s)

L("-- ===========================================================")
L("-- SAMPLE DATA for ujian-online-ci system")
L("-- Generated: 200 mahasiswa, 10 dosen, 3 jurusan, 15 matkul")
L("-- ===========================================================")
L("")
L("SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";")
L("SET AUTOCOMMIT = 0;")
L("START TRANSACTION;")
L("SET time_zone = '+07:00';")
L("SET FOREIGN_KEY_CHECKS = 0;")
L("")

# --- GROUPS ---
L("-- ---------- GROUPS ----------")
L("DELETE FROM `users_groups`;")
L("DELETE FROM `groups`;")
L("INSERT INTO `groups` (`id`, `name`, `description`) VALUES")
L("(1, 'admin', 'Administrator'),")
L("(2, 'dosen', 'Pembuat Soal dan ujian'),")
L("(3, 'mahasiswa', 'Peserta Ujian');")
L("")

# --- JURUSAN ---
L("-- ---------- JURUSAN ----------")
L("TRUNCATE TABLE `jurusan`;")
L("INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES")
for i, (idj, nama) in enumerate(jurusan):
    comma = "," if i < len(jurusan) - 1 else ";"
    L(f"({idj}, '{nama}'){comma}")
L("")

# --- MATKUL ---
L("-- ---------- MATA KULIAH ----------")
L("TRUNCATE TABLE `matkul`;")
L("INSERT INTO `matkul` (`id_matkul`, `nama_matkul`) VALUES")
for i, (idm, nama, _) in enumerate(matkul):
    comma = "," if i < len(matkul) - 1 else ";"
    L(f"({idm}, '{nama}'){comma}")
L("")

# --- JURUSAN_MATKUL ---
L("-- ---------- JURUSAN_MATKUL ----------")
L("TRUNCATE TABLE `jurusan_matkul`;")
L("INSERT INTO `jurusan_matkul` (`id`, `matkul_id`, `jurusan_id`) VALUES")
jm_id = 1
jm_rows = []
for idm, nama, idj in matkul:
    jm_rows.append(f"({jm_id}, {idm}, {idj})")
    jm_id += 1
for i, row in enumerate(jm_rows):
    comma = "," if i < len(jm_rows) - 1 else ";"
    L(f"{row}{comma}")
L("")

# --- KELAS ---
L("-- ---------- KELAS ----------")
L("TRUNCATE TABLE `kelas`;")
L("INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jurusan_id`) VALUES")
kid = 0
kelas_rows = []
for idj, names in kelas_per_jurusan.items():
    for n in names:
        kid += 1
        kelas_rows.append((kid, n, idj))
for i, (kid, n, idj) in enumerate(kelas_rows):
    comma = "," if i < len(kelas_rows) - 1 else ";"
    L(f"({kid}, '{n}', {idj}){comma}")
L("")

# --- DOSEN ---
L("-- ---------- DOSEN ----------")
L("TRUNCATE TABLE `dosen`;")
L("INSERT INTO `dosen` (`id_dosen`, `nip`, `nama_dosen`, `email`, `matkul_id`) VALUES")
dosen_rows = []
for i, (nama, email) in enumerate(dosen_names):
    did = i + 1
    nip = f"19{74+i:02d}{random.randint(1000,9999)}"
    mk_id = (i % len(matkul)) + 1
    dosen_rows.append((did, nip, nama, email, mk_id))
for i, (did, nip, nama, email, mk_id) in enumerate(dosen_rows):
    comma = "," if i < len(dosen_rows) - 1 else ";"
    L(f"({did}, '{nip}', '{nama}', '{email}', {mk_id}){comma}")
L("")

# --- KELAS_DOSEN ---
L("-- ---------- KELAS_DOSEN ----------")
L("TRUNCATE TABLE `kelas_dosen`;")
L("INSERT INTO `kelas_dosen` (`id`, `kelas_id`, `dosen_id`) VALUES")
kd_id = 0
kd_rows = []
for did in range(1, len(dosen_names) + 1):
    assigned = random.sample(range(1, kid + 1), min(2, kid))
    for k in assigned:
        kd_id += 1
        kd_rows.append((kd_id, k, did))
for i, (kd_id, k, did) in enumerate(kd_rows):
    comma = "," if i < len(kd_rows) - 1 else ";"
    L(f"({kd_id}, {k}, {did}){comma}")
L("")

# --- MAHASISWA ---
L("-- ---------- MAHASISWA ----------")
L("TRUNCATE TABLE `mahasiswa`;")
L("INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `nim`, `email`, `jenis_kelamin`, `kelas_id`) VALUES")

mhs_rows = []
used_nims = set()

rng = random.Random(42)
fn_shuffled = first_names.copy()
rng.shuffle(fn_shuffled)
ln_shuffled = last_names.copy()
rng.shuffle(ln_shuffled)

for i in range(200):
    mid = i + 1
    fn = fn_shuffled[i % len(fn_shuffled)]
    ln = ln_shuffled[i % len(ln_shuffled)]
    nama = f"{fn} {ln}".strip()
    if nama.strip() == "":
        nama = f"{fn}"
    
    nim_prefix = random.choice(nim_prefixes)
    nim = f"{nim_prefix}{i+1:04d}"
    while nim in used_nims:
        nim = f"{nim_prefix}{i+1:04d}{random.randint(0,9)}"
    used_nims.add(nim)
    
    email = f"{fn.lower()}.{i+1}@student.univ.ac.id"
    jk = "L" if i % 3 != 0 else "P"
    kelas = kelas_rows[i % len(kelas_rows)]
    kelas_id = kelas[0]
    
    mhs_rows.append((mid, nama, nim, email, jk, kelas_id))

for i, (mid, nama, nim, email, jk, kelas_id) in enumerate(mhs_rows):
    comma = "," if i < len(mhs_rows) - 1 else ";"
    L(f"({mid}, '{nama}', '{nim}', '{email}', '{jk}', {kelas_id}){comma}")
L("")

# --- USERS ---
L("-- ---------- USERS ----------")
L("TRUNCATE TABLE `users`;")
L("INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES")

user_rows = []

# Admin
user_rows.append((1, "127.0.0.1", "admin", HASH_ADMIN, "admin@admin.com",
    None, "", None, None, None, None, None,
    now_ts, now_ts, 1, "Admin", "System", "ADMIN", "0"))

# Users for dosen
for i, (did, nip, nama, email, mk_id) in enumerate(dosen_rows):
    uid = i + 2
    fn = nama.split(",")[0].split()[-1] if " " in nama.split(",")[0] else nama.split(",")[0]
    ln = ""
    user_rows.append((uid, "127.0.0.1", nip, HASH_DOSEN, email,
        None, None, None, None, None, None, None,
        now_ts, now_ts, 1, fn, ln, None, None))

# Users for mahasiswa
for i, (mid, nama, nim, email, jk, kelas_id) in enumerate(mhs_rows):
    uid = i + 12
    fn = nama.split()[0] if nama.split() else nama
    ln = " ".join(nama.split()[1:]) if len(nama.split()) > 1 else ""
    user_rows.append((uid, "127.0.0.1", nim, HASH_MAHASISWA, email,
        None, None, None, None, None, None, None,
        now_ts, now_ts, 1, fn, ln, None, None))

def sql_val(v):
    """Return SQL literal string for a value."""
    if v is None or v == "NULL":
        return "NULL"
    if isinstance(v, int) or (isinstance(v, str) and v.lstrip('-').isdigit()):
        return str(v)
    return f"'{v}'"

for i, row in enumerate(user_rows):
    uid, ip, username, pw, email, act_sel, act_code, fg_sel, fg_code, fg_time, rem_sel, rem_code, created_on, last_login, active, first_name, last_name, company, phone = row
    parts = [sql_val(uid), sql_val(ip), sql_val(username), sql_val(pw), sql_val(email),
             sql_val(act_sel), sql_val(act_code), sql_val(fg_sel), sql_val(fg_code), sql_val(fg_time),
             sql_val(rem_sel), sql_val(rem_code), sql_val(created_on), sql_val(last_login), sql_val(active),
             sql_val(first_name), sql_val(last_name), sql_val(company), sql_val(phone)]
    comma = "," if i < len(user_rows) - 1 else ";"
    L(f"({', '.join(parts)}){comma}")
L("")

# --- USERS_GROUPS ---
L("-- ---------- USERS_GROUPS ----------")
L("TRUNCATE TABLE `users_groups`;")
L("INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES")

ug_rows = []
ug_rows.append((1, 1, 1))
for i in range(10):
    ug_rows.append((i + 2, i + 2, 2))
for i in range(200):
    ug_rows.append((i + 12, i + 12, 3))

for i, (ugid, uid, gid) in enumerate(ug_rows):
    comma = "," if i < len(ug_rows) - 1 else ";"
    L(f"({ugid}, {uid}, {gid}){comma}")
L("")

# --- SOAL ---
L("-- ---------- SOAL ----------")
L("TRUNCATE TABLE `tb_soal`;")
L("INSERT INTO `tb_soal` (`id_soal`, `dosen_id`, `matkul_id`, `bobot`, `file`, `tipe_file`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `file_a`, `file_b`, `file_c`, `file_d`, `file_e`, `jawaban`, `created_on`, `updated_on`) VALUES")

soal_templates = [
    ("Apa yang dimaksud dengan {topic}?",
     ["Teori tentang {topic}", "Penerapan {topic}", "Definisi {topic}", "Sejarah {topic}", "Semua salah"],
     "C"),
    ("Berikut ini adalah contoh dari {topic}, kecuali:",
     ["Contoh 1", "Contoh 2", "Contoh 3", "Contoh 4", "Semua benar"],
     "E"),
    ("Siapa tokoh utama dalam pengembangan {topic}?",
     ["Tokoh A", "Tokoh B", "Tokoh C", "Tokoh D", "Tokoh E"],
     "A"),
    ("{topic} pertama kali diperkenalkan pada tahun?",
     ["1950", "1960", "1970", "1980", "1990"],
     "C"),
    ("Manakah pernyataan yang BENAR tentang {topic}?",
     ["Pernyataan 1 benar", "Pernyataan 2 benar", "Pernyataan 1 dan 2 benar", "Semua salah", "Semua benar"],
     "C"),
    ("Protokol yang digunakan pada {topic} adalah?",
     ["TCP/IP", "HTTP", "FTP", "SMTP", "Semua tergantung konteks"],
     "E"),
    ("Keunggulan utama dari {topic} adalah?",
     ["Keunggulan A", "Keunggulan B", "Keunggulan C", "Keunggulan D", "Semua keunggulan"],
     "E"),
    ("Dalam {topic}, istilah yang tepat untuk menggambarkan {subtopic} adalah?",
     ["Istilah A", "Istilah B", "Istilah C", "Istilah D", "Istilah E"],
     "B"),
]

soal_topic_map = {
    1: ["Basis Data", "Database", "DBMS", "Normalisasi", "SQL"],
    2: ["Analisis Sistem", "SDLC", "UML", "Use Case", "Flowchart"],
    3: ["Manajemen Proyek", "Project Management", "Agile", "Scrum", "Waterfall"],
    4: ["E-commerce", "E-commerce", "Digital Marketing", "Online Payment", "E-business"],
    5: ["Interaksi Manusia Komputer", "HCI", "Usability", "User Interface", "User Experience"],
    6: ["Algoritma", "Struktur Data", "Sorting", "Searching", "Linked List"],
    7: ["Jaringan Komputer", "Networking", "Routing", "OSI Layer", "IP Address"],
    8: ["Sistem Operasi", "Process Management", "Memory Management", "File System", "Scheduling"],
    9: ["Pemrograman Web", "HTML", "CSS", "JavaScript", "PHP"],
    10: ["Keamanan Informasi", "Cryptography", "Firewall", "Enkripsi", "Cyber Security"],
    11: ["Pemrograman Dasar", "Variable", "Looping", "Function", "Array"],
    12: ["Multimedia", "Audio", "Video", "Animasi", "Grafik"],
    13: ["Akuntansi Dasar", "Jurnal", "Neraca", "Laba Rugi", "Laporan Keuangan"],
    14: ["Sistem Informasi Manajemen", "SIM", "ERP", "CRM", "Decision Support"],
    15: ["Desain Grafis", "Color Theory", "Typography", "Layout", "Vector"],
}

soal_rows = []
sid = 0
for id_matkul in range(1, 16):
    topics = soal_topic_map[id_matkul]
    dosen_ids = [d[0] for d in dosen_rows if d[4] == id_matkul]
    if not dosen_ids:
        dosen_ids = [1]
    d_id = random.choice(dosen_ids)
    
    for q_idx in range(5):
        sid += 1
        tmpl = soal_templates[q_idx % len(soal_templates)]
        soal_text, opsi, jawaban = tmpl
        
        topic = random.choice(topics)
        subtopic = random.choice(["konsep dasar", "implementasi", "pengembangan", "keamanan", "arsitektur"])
        soal = soal_text.format(topic=topic, subtopic=subtopic)
        soal = soal.replace("'", "\\'")
        opsi_escaped = [o.replace("'", "\\'") for o in opsi]
        
        if q_idx % len(soal_templates) == 1:
            jawaban = "E"
        
        soal_rows.append((sid, d_id, id_matkul, 1, "", "", f"<p>{soal}</p>",
            f"<p>{opsi_escaped[0]}</p>", f"<p>{opsi_escaped[1]}</p>",
            f"<p>{opsi_escaped[2]}</p>", f"<p>{opsi_escaped[3]}</p>",
            f"<p>{opsi_escaped[4]}</p>", "", "", "", "", "", jawaban, now_ts, now_ts))

for i, row in enumerate(soal_rows):
    comma = "," if i < len(soal_rows) - 1 else ";"
    L(f"({row[0]}, {row[1]}, {row[2]}, {row[3]}, '{row[4]}', '{row[5]}', '{row[6]}', '{row[7]}', '{row[8]}', '{row[9]}', '{row[10]}', '{row[11]}', '{row[12]}', '{row[13]}', '{row[14]}', '{row[15]}', '{row[16]}', '{row[17]}', {row[18]}, {row[19]}){comma}")
L("")

# --- UJIAN ---
L("-- ---------- UJIAN ----------")
L("TRUNCATE TABLE `m_ujian`;")
L("INSERT INTO `m_ujian` (`id_ujian`, `dosen_id`, `matkul_id`, `nama_ujian`, `jumlah_soal`, `waktu`, `jenis`, `tgl_mulai`, `terlambat`, `token`) VALUES")

rnd2 = random.Random(99)
tokens_pool = []
for _ in range(30):
    t = ''.join(rnd2.choices("ABCDEFGHIJKLMNOPQRSTUVWXYZ", k=5))
    tokens_pool.append(t)

ujian_rows = []
ujid = 0
for uj_idx in range(15):
    ujid += 1
    d_id = rnd2.randint(1, 10)
    mk = [d[4] for d in dosen_rows if d[0] == d_id]
    mk_id = mk[0] if mk else 1
    nama = f"Ujian {['UTS','UAS','Quiz','Try Out','Remidi'][uj_idx % 5]} - {matkul[mk_id-1][1]} - {['Ganjil','Genap'][uj_idx % 2]} 2026"
    jml = rnd2.choice([10, 15, 20, 25])
    waktu = rnd2.choice([30, 45, 60, 90, 120])
    jenis = rnd2.choice(["acak", "urut"])
    tgl = f"2026-{7 + uj_idx // 5:02d}-{1 + uj_idx:02d} 08:00:00"
    terlambat = f"2026-{7 + uj_idx // 5:02d}-{15 + uj_idx:02d} 23:59:00"
    token = tokens_pool[uj_idx]
    ujian_rows.append((ujid, d_id, mk_id, nama, jml, waktu, jenis, tgl, terlambat, token))

for i, row in enumerate(ujian_rows):
    comma = "," if i < len(ujian_rows) - 1 else ";"
    L(f"({row[0]}, {row[1]}, {row[2]}, '{row[3]}', {row[4]}, {row[5]}, '{row[6]}', '{row[7]}', '{row[8]}', '{row[9]}'){comma}")
L("")

# --- HASIL UJIAN ---
L("-- ---------- HASIL UJIAN ----------")
L("TRUNCATE TABLE `h_ujian`;")
L("INSERT INTO `h_ujian` (`id`, `ujian_id`, `mahasiswa_id`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`) VALUES")

rnd3 = random.Random(123)
hasil_rows = []
hid = 0
for _ in range(50):
    hid += 1
    uj = random.choice(ujian_rows)
    mhs = random.choice(mhs_rows)
    
    matkul_soal_ids = [s[0] for s in soal_rows if s[2] == uj[2]]
    if not matkul_soal_ids:
        continue
    jml_soal = min(uj[4], len(matkul_soal_ids))
    selected = random.sample(matkul_soal_ids, jml_soal)
    list_soal = ",".join(str(s) for s in selected)
    
    jawaban_parts = []
    benar = 0
    for s_id in selected:
        s_data = [s for s in soal_rows if s[0] == s_id][0]
        jwb = random.choice(["A", "B", "C", "D", "E"])
        status = "Y" if jwb == s_data[16] else "N"
        if status == "Y":
            benar += 1
        jawaban_parts.append(f"{s_id}:{jwb}:{status}")
    list_jawaban = ",".join(jawaban_parts)
    
    nilai = round((benar / jml_soal) * 100, 2)
    tgl_mulai = f"2026-{random.randint(7,8):02d}-{random.randint(1,28):02d} {random.randint(8,16):02d}:{random.randint(0,59):02d}:00"
    tgl_selesai = f"2026-{random.randint(7,8):02d}-{random.randint(1,28):02d} {random.randint(8,16):02d}:{random.randint(0,59):02d}:00"
    status = "N"
    
    hasil_rows.append((hid, uj[0], mhs[0], list_soal, list_jawaban, benar, f"{nilai:.2f}", "100.00", tgl_mulai, tgl_selesai, status))

for i, row in enumerate(hasil_rows):
    comma = "," if i < len(hasil_rows) - 1 else ";"
    L(f"({row[0]}, {row[1]}, {row[2]}, '{row[3]}', '{row[4]}', {row[5]}, '{row[6]}', '{row[7]}', '{row[8]}', '{row[9]}', '{row[10]}'){comma}")
L("")

# --- RESET AUTO_INCREMENT ---
L("-- ---------- RESET AUTO_INCREMENT ----------")
L("ALTER TABLE `groups` AUTO_INCREMENT = 4;")
L("ALTER TABLE `jurusan` AUTO_INCREMENT = 4;")
L("ALTER TABLE `matkul` AUTO_INCREMENT = 16;")
L(f"ALTER TABLE `jurusan_matkul` AUTO_INCREMENT = {len(jm_rows) + 1};")
L(f"ALTER TABLE `kelas` AUTO_INCREMENT = {kid + 1};")
L(f"ALTER TABLE `dosen` AUTO_INCREMENT = {len(dosen_rows) + 1};")
L(f"ALTER TABLE `kelas_dosen` AUTO_INCREMENT = {len(kd_rows) + 1};")
L(f"ALTER TABLE `mahasiswa` AUTO_INCREMENT = {len(mhs_rows) + 1};")
L(f"ALTER TABLE `users` AUTO_INCREMENT = {len(user_rows) + 1};")
L(f"ALTER TABLE `users_groups` AUTO_INCREMENT = {len(ug_rows) + 1};")
L(f"ALTER TABLE `tb_soal` AUTO_INCREMENT = {len(soal_rows) + 1};")
L(f"ALTER TABLE `m_ujian` AUTO_INCREMENT = {len(ujian_rows) + 1};")
L(f"ALTER TABLE `h_ujian` AUTO_INCREMENT = {len(hasil_rows) + 1};")
L("")

L("SET FOREIGN_KEY_CHECKS = 1;")
L("COMMIT;")

# ---------- WRITE FILE ----------
script_dir = os.path.dirname(os.path.abspath(__file__))
out_path = os.path.join(script_dir, "sample_data.sql")
with open(out_path, "w") as f:
    f.write("\n".join(lines))

print(f"Generated SQL: {len(lines)} lines")
print(f"  - {len(jurusan)} jurusan")
print(f"  - {len(matkul)} matkul")
print(f"  - {len(dosen_rows)} dosen")
print(f"  - {len(kelas_rows)} kelas")
print(f"  - {len(mhs_rows)} mahasiswa")
print(f"  - {len(user_rows)} users")
print(f"  - {len(ug_rows)} users_groups")
print(f"  - {len(soal_rows)} soal")
print(f"  - {len(ujian_rows)} ujian")
print(f"  - {len(hasil_rows)} hasil ujian")