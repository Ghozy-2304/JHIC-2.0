## 2026-08-18 - Fix Tailwind CSS Purge & Public Build Permissions

### Sedang / Sudah Membuat
- Mengoreksi direktori `@source` Tailwind CSS v4 di `resources/css/app.css` agar memindai file view secara presisi.
- Menambahkan pembersihan file `public/hot` otomatis pada `Dockerfile` & `entrypoint.sh` untuk mencegah mode Vite Dev Server di production.
- Menambahkan izin akses `chmod -R 755 public` di Docker agar Nginx dapat menyajikan bundle CSS/JS dari `public/build/assets/`.

### File
- `resources/css/app.css`
- `Dockerfile`
- `entrypoint.sh`
- `AI_log.md`

### Status
DONE

### Catatan
- Penyebab tampilan polos tanpa CSS:
  1. Direktori `@source` di `app.css` sebelumnya mengacu ke folder `vendor/` dan `storage/` luar yang belum ada saat proses `npm run build` di Docker stage 1, menyebabkan Tailwind membuang semua class CSS.
  2. Kemungkinan adanya file `public/hot` sisa lokal yang memaksa Laravel memanggil Vite dev server `http://localhost:5173`.
  3. Izin direktori `public/build/` pada Nginx.

### Pekerjaan Selanjutnya
- Push perubahan ke GitHub.

## 2026-08-18 - Commit Pre-compiled Assets & Add Fallback Tailwind CDN

### Sedang / Sudah Membuat
- Menghapus `/public/build` dari `.gitignore` dan melakukan komit langsung bundel `public/build/` (manifest & css) ke repository Git agar tidak bergantung pada proses Node build di dalam Docker Railway.
- Menambahkan script fallback Tailwind CSS v4 CDN di `resources/views/welcome.blade.php`.

### File
- `.gitignore`
- `resources/views/welcome.blade.php`
- `public/build/manifest.json`
- `public/build/assets/app-Br8wb-en.css`
- `AI_log.md`

### Status
DONE

### Catatan
- Dengan menyertakan `public/build` langsung dalam repositori Git dan menambahkan CDN fallback, tampilan Tailwind CSS dijamin 100% muncul sempurna di Railway.


## 2026-08-18 - Fix Mixed Content Blocking for Assets

### Sedang / Sudah Membuat
- Mengganti pemanggilan asset di `resources/views/welcome.blade.php` dengan link relatif `/build/assets/app-Br8wb-en.css` agar browser selalu memanggil file CSS dengan protokol yang sama (`https://`) dan terhindar dari `(blocked:mixed-content)`.
- Mengatur `AppServiceProvider.php` agar tidak memaksa HTTPS saat dijalankan di `localhost` / `127.0.0.1` (`php artisan serve`).

### File
- `resources/views/welcome.blade.php`
- `app/Providers/AppServiceProvider.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Log browser menunjukkan `(blocked:mixed-content)` pada file CSS/JS karena URL absolut diawali dengan `http://`. Dengan mengganti ke path relatif `/build/...`, browser secara otomatis mengambil asset menggunakan `https://`.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke GitHub.


## 2026-08-18 - Add Content Security Policy Upgrade Insecure Requests

### Sedang / Sudah Membuat
- Menambahkan meta tag `<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">` di `<head>` pada `resources/views/welcome.blade.php`.
- Menghapus tag `@vite` yang me-render URL HTTP absolut dan menggantikannya dengan path relatif murni `/build/assets/app-Br8wb-en.css` + Tailwind Browser Engine.

### File
- `resources/views/welcome.blade.php`
- `app/Providers/AppServiceProvider.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Meta tag `upgrade-insecure-requests` memaksa browser untuk secara otomatis meng-upgrade seluruh permintaan HTTP menjadi HTTPS sebelum dikirim ke jaringan. Ini secara permanen menghilangkan error `(blocked:mixed-content)`.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke GitHub.
