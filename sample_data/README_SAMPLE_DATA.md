# Sample Data Ujian Online CI

## File

| File | Fungsi |
|------|--------|
| `full_sample.sql` | **RECOMMENDED** — struktur tabel + data sample siap import |
| `sample_data.sql` | HANYA data (struktur tabel harus sudah ada) |
| `generate_sample_data.py` | Script Python generate ulang data |

## Cara Import

### Opsi 1: DB Baru (RECOMMENDED)

```bash
mysql -u root -p < sample_data/full_sample.sql
```

File ini otomatis:
- `CREATE DATABASE IF NOT EXISTS ci_online_test`
- `USE ci_online_test`
- Buat semua tabel (`CREATE TABLE IF NOT EXISTS`)
- Tambah index & foreign key
- Insert sample data

### Opsi 2: DB Existing (tabel sudah ada)

```bash
mysql -u root -p nama_database < sample_data/sample_data.sql
```

Data akan di-`TRUNCATE` lalu insert ulang. Aman diulang.

### Opsi 3: phpMyAdmin

1. Buka phpMyAdmin
2. Pilih database **ci_online_test** (buat dulu kalo belum ada)
3. Klik tab **Import**
4. Pilih file `sample_data/full_sample.sql`
5. Klik **Go**

## Cara Generate Ulang Data

```bash
python3 sample_data/generate_sample_data.py
```

Script Python, gak perlu install library tambahan. Hasil:
- `sample_data/sample_data.sql` — data aja
- `full_sample.sql` — struktur + data

## Isi Data

| Tabel | Jumlah |
|-------|--------|
| jurusan | 3 |
| matkul | 15 |
| dosen | 10 |
| kelas | 11 |
| mahasiswa | 200 |
| users | 211 |
| tb_soal | 75 |
| m_ujian | 15 |
| h_ujian | 50 |

## Password

| Role | Username | Password |
|------|----------|----------|
| **Admin** | `admin` | `admin123` |
| **Dosen** | NIP masing-masing | `dosen123` |
| **Mahasiswa** | NIM masing-masing | `mahasiswa123` |

Contoh login:
- Admin: `admin` / `admin123`
- Dosen: `19742824` / `dosen123`
- Mahasiswa: `1310001` / `mahasiswa123`

## Catatan

- Password bcrypt hash ($2y$10$) kompatibel PHP `password_verify()`.
- Token ujian 5 huruf kapital random.
- Urutan insert udah perhatikan foreign key constraints.
- Data hasil ujian (h_ujian) jawabannya random — nilai 0 (buat latihan).