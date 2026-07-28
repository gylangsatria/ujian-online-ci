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
| PDF | Native Browser Print (Future: TBD) |
| Excel | Future: TBD |

## Quick Start

```bash
# clone
git clone git@github.com:gylangsatria/ujian-online-ci.git
cd ujian-online-ci
git checkout migrate/codeigniter-4

# jalankan container
docker compose up -d

# migrasi & seed database (pertama kali)
docker compose exec app php spark migrate
docker compose exec app php spark db:seed DatabaseSeeder

# akses
# App:       http://localhost:8080
# phpMyAdmin: http://localhost:8081
```

## Environment

Copy `.env.example` ke `.env` (sudah tersedia dengan default development):

```
CI_ENVIRONMENT = development
database.default.hostname = db
database.default.database = ci_online_test
database.default.username = ci4user
database.default.password = ci4pass
database.default.DBDriver = MySQLi
```

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
| Phase 3: Library & Helper | 🚧 70% |
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