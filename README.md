# Ujian Online CI — CodeIgniter 4 + Docker

Migrasi [Ujian Online CI](https://github.com/gylangsatria/ujian-online-ci) dari CodeIgniter 3 ke CodeIgniter 4, dengan MySQL 8 dan Docker.

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | PHP 8.2 + CodeIgniter 4 |
| Database | MySQL 8.0 |
| Web Server | Nginx 1.25 |
| Frontend | Tailwind CSS (CDN) + Alpine.js |
| Auth | Custom Auth Library (`App\Libraries\Auth`) |
| PDF | Dompdf |
| Excel | Future: TBD |

## Quick Start

```bash
# clone
git clone git@github.com:gylangsatria/ujian-online-ci.git
cd ujian-online-ci
git checkout migrate/codeigniter-4

# setup env
cp .env.example .env
# edit .env — isi MYSQL_DATABASE, user, password sesuai keinginan

# jalankan container (otomatis bikin DB + seed data dari sql/init.sql)
docker compose up -d

# akses
# App:       http://localhost:8080
# phpMyAdmin: http://localhost:8081
```

## Environment

Copy `.env.example` ke `.env` lalu isi nilai sesuai lingkungan:

| Variabel | Contoh | Keterangan |
|---|---|---|
| `MYSQL_DATABASE` / `database.default.database` | `ujian_online` | Nama database |
| `MYSQL_USER` / `database.default.username` | `ci4user` | User MySQL |
| `MYSQL_PASSWORD` / `database.default.password` | `ci4pass` | Password MySQL |
| `MYSQL_ROOT_PASSWORD` | `rootpass` | Root password MySQL |

Variabel `MYSQL_*` dipakai oleh container MySQL.  
`database.default.*` dipakai oleh aplikasi.  
Keduanya harus **sama** nilainya.

## Struktur

```
ujian-online-ci/
├── app/            # Kode aplikasi (Controllers, Models, Views, Config)
├── docker/         # Docker config (nginx)
├── public/         # Entry point, assets, uploads
├── sql/            # Init database
├── writable/       # Cache, logs, session
├── .env            # Environment config
├── docker-compose.yml
└── Dockerfile
```

## Progress

| Phase | Status |
|---|---|
| Phase 0: Bootstrap | ✅ |
| Phase 1: Database | ✅ |
| Phase 2: Core Migration | ✅ |
| Phase 3: Library & Helper | ✅ |
| Phase 4: Tailwind UI | ✅ |
| Phase 5: Testing | 🚧 1-2 hari |
| Phase 6: Final | 🔲 |

Lihat [roadmap.md](roadmap.md) untuk detail tahapan migrasi.

## User Default Login

Login via **username** (NIP/NIM) — password ada di seed data.
| Role | Username | Password |
|---|---|---|
| Admin | Administrator | admin |
| Dosen | 12345678 | password |
| Dosen | 01234567 | password |
| Mahasiswa | 12183018 | password |

## License

MIT — lihat [LICENSE](LICENSE).