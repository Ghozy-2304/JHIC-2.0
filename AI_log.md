## 2026-08-18 - Fix Tailwind CSS & Vite Mixed Content Asset Loading

### Sedang / Sudah Membuat
- Menambahkan `$middleware->trustProxies(at: '*')` di `bootstrap/app.php` agar Laravel mengenali header SSL reverse proxy Railway (`X-Forwarded-Proto`).
- Menambahkan `URL::forceScheme('https')` di `AppServiceProvider.php` saat environment `production` atau request via HTTPS.

### File
- `bootstrap/app.php`
- `app/Providers/AppServiceProvider.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Penyebab tampilan polis/tanpa CSS di Railway:
  Website diakses via `https://`, namun karena Laravel di balik reverse proxy Railway belum dikonfigurasi `trustProxies` dan `forceScheme('https')`, Laravel me-render tag asset `@vite` menggunakan protocol `http://`. Browser (Chrome/Edge/Safari) secara otomatis memblokir file CSS `http://` tersebut (*Mixed Content Block*).

### Pekerjaan Selanjutnya
- Commit dan push ke GitHub agar Railway men-deploy perbaikan ini.


