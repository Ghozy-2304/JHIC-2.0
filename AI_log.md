## 2026-08-18 - Fix Dockerfile & Railway Deployment Configuration

### Sedang / Sudah Membuat
- Memperbaiki `Dockerfile` untuk deployment Railway.
- Menambahkan instalasi ekstensi PHP `pdo_mysql`, `pdo_pgsql`, `bcmath`, `gd`, `zip`.
- Menambahkan pembuatan folder storage & bootstrap cache beserta permission `www-data`.
- Menambahkan script otomatisasi startup di `/etc/entrypoint.d/99-laravel.sh` (`php artisan migrate --force`, `config:cache`, `route:cache`, `view:cache`).

### File
- `Dockerfile`
- `AI_log.md`

### Status
DONE

### Catatan
- Penyebab error di Railway:
  1. Ekstensi database PHP (`pdo_mysql` / `pdo_pgsql`) belum terinstall di image Docker.
  2. Root directory di Railway harus diset ke `Website-IDN-JHIC` jika repositori memiliki subfolder.
  3. Direktori storage & cache di Docker butuh kepemilikan `www-data` dan pembuatan folder `storage/framework/*`.
  4. Perlu konfigurasi Environment Variables di Dashboard Railway (`APP_KEY`, `DB_HOST`, `DB_PORT`, dll.).

### Pekerjaan Selanjutnya
- Melakukan Push ke GitHub/Railway dan melakukan verifikasi deployment.
