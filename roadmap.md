# Migrasi CodeIgniter 3 → CodeIgniter 4 + MySQL + Docker

## Ringkasan

Proyek ini memigrasikan **Ujian Online CI** dari CodeIgniter 3 ke CodeIgniter 4 dengan MySQL 8, didockerisasi untuk development reproducibility. Branch: `migrate/codeigniter-4`.

---

## 1. Arsitektur Docker

### 1.1 Service

| Service | Image | Versi | Port |
|---|---|---|---|
| `app` | `php:8.2-fpm` | PHP 8.2 | 9000 |
| `web` | `nginx:1.25` | Nginx 1.25 | 80 → 8080 |
| `db` | `mysql:8.0` | MySQL 8.0 | 3306 |
| `phpmyadmin` | `phpmyadmin:5.2` | - | 8081 |

### 1.2 Dockerfile (PHP)

- Base `php:8.2-fpm`
- Extensions: `pdo`, `pdo_mysql`, `mysqli`, `mbstring`, `intl`, `gd`, `zip`, `openssl`, `curl`, `xml`, `json`, `bcmath`, `exif`
- Composer terinstal
- Node.js + npm untuk build Tailwind
- Working dir: `/var/www/html`

### 1.3 Nginx Config

- Root: `/var/www/html/public`
- Passthrough PHP ke `app:9000`

### 1.4 docker-compose.yml

```yaml
version: '3.8'
services:
  app:
    build: .
    container_name: ci4-app
    volumes:
      - .:/var/www/html
    networks:
      - ci4-network
    depends_on:
      db:
        condition: service_healthy

  web:
    image: nginx:1.25-alpine
    container_name: ci4-web
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - ci4-network

  db:
    image: mysql:8.0
    container_name: ci4-db
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: rootpass
      MYSQL_DATABASE: ci_online_test
      MYSQL_USER: ci4user
      MYSQL_PASSWORD: ci4pass
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./sql/init.sql:/docker-entrypoint-initdb.d/init.sql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5
    networks:
      - ci4-network

  phpmyadmin:
    image: phpmyadmin:5.2
    container_name: ci4-phpmyadmin
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
      PMA_USER: root
      PMA_PASSWORD: rootpass
    depends_on:
      - db
    networks:
      - ci4-network

volumes:
  db_data:

networks:
  ci4-network:
    driver: bridge
```

### 1.5 Environment (.env)

```
CI_ENVIRONMENT = development
database.default.hostname = db
database.default.database = ci_online_test
database.default.username = ci4user
database.default.password = ci4pass
database.default.DBDriver = MySQLi
```

---

## 2. Migrasi CodeIgniter 3 → 4

### 2.1 Perubahan Struktur Direktori

| CI3 → CI4 | Keterangan |
|---|---|
| `application/` → `app/` | Folder aplikasi |
| `system/` → `vendor/` | Framework via composer |
| `assets/` → `public/assets/` | Static assets |
| `uploads/` → `public/uploads/` | File upload |
| `index.php` → `public/index.php` | Entry point |

### 2.2 Konfigurasi

| CI3 File | CI4 File |
|---|---|
| `application/config/config.php` | `app/Config/App.php` |
| `application/config/database.php` | `app/Config/Database.php` |
| `application/config/routes.php` | `app/Config/Routes.php` |
| `application/config/autoload.php` | `app/Config/Autoload.php` |
| `application/config/ion_auth.php` | `app/Config/IonAuth.php` |
| `application/config/constants.php` | `app/Config/Constants.php` |

### 2.3 Controller Migration

| CI3 Controller | CI4 Namespace |
|---|---|
| `Auth.php` | `App\Controllers\Auth` |
| `Dashboard.php` | `App\Controllers\Dashboard` |
| `Dosen.php` | `App\Controllers\Dosen` |
| `Hasilujian.php` | `App\Controllers\HasilUjian` |
| `Jurusan.php` | `App\Controllers\Jurusan` |
| `Jurusanmatkul.php` | `App\Controllers\JurusanMatkul` |
| `Kelas.php` | `App\Controllers\Kelas` |
| `Kelasdosen.php` | `App\Controllers\KelasDosen` |
| `Mahasiswa.php` | `App\Controllers\Mahasiswa` |
| `Matkul.php` | `App\Controllers\Matkul` |
| `Settings.php` | `App\Controllers\Settings` |
| `Soal.php` | `App\Controllers\Soal` |
| `Ujian.php` | `App\Controllers\Ujian` |
| `Users.php` | `App\Controllers\Users` |

### 2.4 Model Migration

| CI3 Model | CI4 Namespace |
|---|---|
| `Master_model.php` | `App\Models\MasterModel` |
| `Soal_model.php` | `App\Models\SoalModel` |
| `Ujian_model.php` | `App\Models\UjianModel` |
| `Dashboard_model.php` | `App\Models\DashboardModel` |
| `Settings_model.php` | `App\Models\SettingsModel` |
| `Users_model.php` | `App\Models\UsersModel` |

### 2.5 Library Migration

| CI3 Library | CI4 Strategy |
|---|---|
| `Datatables.php` | Port ke `App\Libraries\Datatables` |
| `Ion_auth.php` | `ion-auth/ion-auth` via composer |
| `Pdf.php` | Port ke `App\Libraries\Pdf` |
| `tcpdf/` | `tecnickcom/tcpdf` via composer |
| `PHPExcel/` | `phpoffice/phpspreadsheet` via composer |

---

## 3. Database

### 3.1 MySQL 8 Migration

- Convert charset `latin1` → `utf8mb4`
- Migration files: `app/Database/Migrations/`
- Seeder: `app/Database/Seeds/`

### 3.2 Tabel

| Tabel | Fungsi |
|---|---|
| `dosen` | Data dosen |
| `groups` | Grup user (IonAuth) |
| `h_ujian` | Hasil ujian |
| `jurusan` | Jurusan |
| `jurusan_matkul` | Relasi jurusan-matkul |
| `kelas` | Kelas |
| `kelas_dosen` | Relasi kelas-dosen |
| `login_attempts` | Log login (IonAuth) |
| `mahasiswa` | Data mahasiswa |
| `matkul` | Mata kuliah |
| `m_ujian` | Master ujian |
| `tb_soal` | Bank soal |
| `users` | User (IonAuth) |
| `users_groups` | Relasi user-group (IonAuth) |
| `migrations` | Riwayat migrasi CI4 (auto) |

### 3.3 Trigger → Model Events

Trigger `dosen` sync ke `users` dipindah ke model events:
- `afterInsert`, `afterUpdate`, `afterDelete` di `DosenModel`

---

## 4. Frontend: Tailwind CSS

### 4.1 Strategi

Ganti **Bootstrap 3** dengan **Tailwind CSS v3** via CDN (phase awal). Upgrade ke build pipeline (npm + postcss) saat final.

### 4.2 Asset Baru (via CDN)

| Asset | Source | Fungsi |
|---|---|---|
| Tailwind CSS | CDN (play CDN) | Utility CSS framework |
| jQuery | CDN | JS DOM manipulation |
| Datatables.net | CDN | Table sorting/search |
| Font Awesome 6 | CDN | Icons |
| Select2 | CDN | Enhanced select |
| SweetAlert2 | CDN | Alert modal |
| Alpine.js | CDN | Interaktivitas ringan (ganti JS vanilla) |
| Summernote | CDN | Rich text editor (ganti Froala) |
| PACE | CDN | Page progress bar |

### 4.3 Komponen Utama Tailwind

- **Layout**: sidebar navigasi (fixed), header, content area
- **Card**: untuk dashboard stats, form sections
- **Table**: datatables with Tailwind styling
- **Form**: input styling dengan ring/focus states
- **Modal**: SweetAlert2 untuk konfirmasi
- **Button**: color variants (primary, danger, success, warning)
- **Badge**: status labels (aktif/nonaktif, role user)
- **Pagination**: Tailwind-style pagination

### 4.4 Warna Tema

```js
// tailwind.config.js (future)
colors: {
  primary: { 50-900: blue },
  success: { 50-900: green },
  danger: { 50-900: red },
  warning: { 50-900: yellow },
}
```

---

## 5. Daftar Library Eksternal

### 5.1 Composer (production)

| Package | Versi | Fungsi |
|---|---|---|
| `codeigniter4/framework` | ^4.5 | Framework |
| `ion-auth/ion-auth` | ^4.0 | Auth library |
| `tecnickcom/tcpdf` | ^6.7 | PDF generation |
| `phpoffice/phpspreadsheet` | ^2.0 | Excel import/export |

### 5.2 Composer (dev)

| Package | Fungsi |
|---|---|
| `codeigniter4/devkit` | Debug toolbar, code generation |

---

## 6. Tahapan Migrasi

### Phase 0: Bootstrap ✅
- [x] Branch `migrate/codeigniter-4`
- [x] Roadmap ini
- [x] Docker setup (compose, Dockerfile, nginx, .env, .dockerignore)
- [x] CI4 install via composer
- [x] Konfigurasi `.env` untuk database
- [x] Konfigurasi database CI4
- [x] Struktur `app/` siap pakai
- [x] `public/assets/` + `public/uploads/` siap
- [x] Testing: landing page CI4 muncul di `localhost:8080`
- [x] `.gitignore` cleanup: exclude `temp-ci4/`, `composer.lock`, CI3 `assets/bower_components/`, `uploads/`

### Phase 1: Database ✅
- [x] Buat migration files (14 tabel)
- [x] Seed data (users, groups, dsb)
- [x] Testing: migrate & seed sukses
- [x] Fix `app/Config/Database.php` — env() agar terbaca dari .env
- [x] Buat `spark` root entrypoint (FCPATH benar)

### Phase 2: Core Migration
- [ ] Auth (Login/Logout + IonAuth)
- [ ] Dashboard
- [ ] Master: Jurusan, Matkul, Kelas, Dosen, Mahasiswa
- [ ] Relasi: JurusanMatkul, KelasDosen
- [ ] Bank Soal (CRUD + import/export Excel)
- [ ] Ujian (jadwal, token, pelaksanaan)
- [ ] Hasil Ujian (nilai, PDF)
- [ ] Users Management
- [ ] Settings

### Phase 3: Library & Helper
- [ ] Datatables library
- [ ] PDF library
- [ ] Helper functions
- [ ] IonAuth config

### Phase 4: Tailwind UI Implementation
- [ ] Layout template (sidebar, navbar, content)
- [ ] Auth pages (login)
- [ ] Dashboard page
- [ ] Master pages (CRUD tables + forms)
- [ ] Soal pages (editor)
- [ ] Ujian pages (pelaksanaan)
- [ ] Users pages
- [ ] Settings page
- [ ] Responsive design

### Phase 5: Testing
- [ ] Login all roles
- [ ] CRUD semua master
- [ ] Buat soal + ujian
- [ ] Ikut ujian
- [ ] Lihat hasil + PDF

### Phase 6: Final
- [ ] Update README.md
- [ ] Cleanup CI3 files
- [ ] Push ke branch

---

## 7. Struktur Direktori Final

```
ujian-online-ci/
├── app/
│   ├── Config/
│   ├── Controllers/
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeds/
│   ├── Filters/
│   ├── Helpers/
│   ├── Language/
│   ├── Libraries/
│   ├── Models/
│   └── Views/
│       ├── layout/
│       ├── auth/
│       ├── dashboard.php
│       ├── master/
│       ├── relasi/
│       ├── soal/
│       ├── ujian/
│       ├── users/
│       └── errors/
├── docker/
│   └── nginx/default.conf
├── public/
│   ├── assets/
│   ├── uploads/
│   ├── index.php
│   └── .htaccess
├── sql/
│   ├── init.sql
│   └── ci_online_test.sql
├── vendor/
├── writable/
├── .env
├── .gitignore
├── Dockerfile
├── docker-compose.yml
└── roadmap.md
```

---

## 8. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| IonAuth v4 belum matured | Auth manual wrapper |
| Summernote feature parity | Evaluasi jika kurang, ganti Trix/Quill |
| Datatables server-side complex | Port manual parsing |
| Tailwind CDN besar di production | Build pipeline via npm + purgeCSS |
| Trigger MySQL dihapus | Pindah ke model events |

---

## 9. Timeline

| Phase | Effort |
|---|---|
| Phase 0: Bootstrap | ✅ Selesai |
| Phase 1: Database | 1 hari |
| Phase 2: Core Migration | 5-7 hari |
| Phase 3: Library & Helper | 1 hari |
| Phase 4: Tailwind UI | 3-4 hari |
| Phase 5: Testing | 2 hari |
| Phase 6: Final | 1 hari |
| **Total** | **~13-16 hari** |