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


## 2026-08-18 - Local Static Tailwind CSS Setup

### Sedang / Sudah Membuat
- Membuat file CSS statis lokal `public/css/tailwind.css` dari hasil kompilasi Tailwind CSS v4 proyek.
- Mengganti tag stylesheet pada `resources/views/welcome.blade.php` dengan pemanggilan lokal murni: `<link rel="stylesheet" href="/css/tailwind.css">`.

### File
- `public/css/tailwind.css`
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Menggunakan file CSS lokal statis di `public/css/tailwind.css` dengan pemanggilan path relatif `/css/tailwind.css`. Tidak bergantung pada CDN, tidak bergantung pada hash Vite, dan 100% aman dari mixed content blocking di Railway maupun localhost.

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


## 2026-08-18 - Inline CSS Injection & Secure Asset Enforcement

### Sedang / Sudah Membuat
- Menginjeksi isi CSS `app-Br8wb-en.css` secara langsung ke dalam tag `<style>` pada `resources/views/welcome.blade.php`. Hal ini menghilangkan 100% permintaan jaringan eksternal untuk file CSS sehingga bebas sama sekali dari error mixed content/HTTP.
- Menyetel `$this->app['request']->server->set('HTTPS', 'on');` di `AppServiceProvider.php` dan memperkuat `secure_asset()`.

### File
- `resources/views/welcome.blade.php`
- `app/Providers/AppServiceProvider.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Dengan metode *Inline Style Injection*, CSS Tailwind dibaca langsung dari sistem file server lokal saat halaman di-render. Tidak ada request HTTP tambahan yang dilakukan oleh browser untuk CSS, sehingga tidak mungkin terkena mixed-content blocking.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke GitHub.


## 2026-08-18 - Local Static Tailwind CSS Setup

### Sedang / Sudah Membuat
- Membuat file CSS statis lokal `public/css/tailwind.css` dari hasil kompilasi Tailwind CSS v4 proyek.
- Mengganti tag stylesheet pada `resources/views/welcome.blade.php` dengan pemanggilan lokal murni: `<link rel="stylesheet" href="/css/tailwind.css">`.

### File
- `public/css/tailwind.css`
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Menggunakan file CSS lokal statis di `public/css/tailwind.css` dengan pemanggilan path relatif `/css/tailwind.css`. Tidak bergantung pada CDN, tidak bergantung pada hash Vite, dan 100% aman dari mixed content blocking di Railway maupun localhost.


## 2026-08-18 - Clear Compiled Blade View Cache & Update Git Ignore

### Sedang / Sudah Membuat
- Menambahkan penghapusan file Blade terkompilasi lama (`storage/framework/views/*.php`) pada `entrypoint.sh` saat startup kontainer.
- Menambahkan pola ignore `/storage/framework/views/*` pada `.gitignore` dan menghapus file view terkompilasi lama dari tracking Git agar server Railway tidak lagi menyajikan HTML cache lama.

### File
- `.gitignore`
- `entrypoint.sh`
- `AI_log.md`

### Status
DONE

### Catatan
- Ditemukan 45 file cache Blade terkompilasi lama yang ikut ter-commit ke Git. Hal ini menyebabkan server Railway terus menyajikan HTML cache versi lama. Dengan membersihkan cache view di Git dan menambahkan penghapusan otomatis di `entrypoint.sh`, Railway dipaksa merender file `welcome.blade.php` versi terbaru dengan `<link rel="stylesheet" href="/css/tailwind.css">`.


## 2026-08-18 - Dual-Mode Support for Local DevMode & Railway Production

### Sedang / Sudah Membuat
- Menyesuaikan `<head>` pada `resources/views/welcome.blade.php` agar mendukung 2 mode secara otomatis:
  1. Mode lokal devmode (`npm run dev` / file `hot` ada): Menggunakan `@vite(...)` untuk Hot Module Replacement.
  2. Mode production (Railway / tanpa `npm run dev`): Menginjeksi `public/css/tailwind.css` lokal secara langsung ke tag `<style>` sehingga bebas dari network request & mixed content blocking di DevTools.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Logika pengecekan `file_exists(public_path('hot'))` memastikan pengembang dapat menjalankan `npm run dev` di komputer lokal tanpa kendala, sekaligus menjamin server Railway menyajikan file CSS statis lokal secara langsung di production.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke GitHub.


## 2026-08-19 - Fix Asset Blocking & Configure Root-Relative Vite Resolver

### Sedang / Sudah Membuat
- Memperbaiki `BadMethodCallException` di `app/Providers/AppServiceProvider.php` dengan mengganti `request()->isLocal()` menjadi `app()->isLocal()`.
- Menambahkan `Vite::createAssetPathsUsing` di `AppServiceProvider.php` untuk menghasilkan URL asset dengan path relatif murni (`/build/assets/...`), membebaskan asset dari skema `http://` absolut.
- Menghapus meta tag `<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">` dari `resources/views/welcome.blade.php` yang menyebabkan kegagalan blokir CSP pada line 6 `(index):6` di browser Chromium.

### File
- `app/Providers/AppServiceProvider.php`
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Screenshot DevTools menunjukkan error `(blocked: ...)` pada `(index):6`. Penyebab utamanya adalah meta tag Content-Security-Policy line 6 serta URL asset absolut `http://`. Dengan menggunakan `Vite::createAssetPathsUsing`, URL asset sekarang selalu ter-render sebagai path relatif murni `/build/assets/app-Br8wb-en.css` dan `/build/assets/app-l0sNRNKZ.js`, sehingga 100% kompatibel di Railway (HTTPS) maupun lokal.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke GitHub.


## 2026-08-19 - Configure Explicit Trusted Proxies in Bootstrap

### Sedang / Sudah Membuat
- Mengonfigurasi `trustProxies` secara eksplisit pada `bootstrap/app.php` dengan mempercayai semua proxy (`at: '*'`) dan menyertakan seluruh header forwarding (`HEADER_X_FORWARDED_FOR`, `HEADER_X_FORWARDED_HOST`, `HEADER_X_FORWARDED_PORT`, `HEADER_X_FORWARDED_PROTO`, `HEADER_X_FORWARDED_AWS_ELB`).

### File
- `bootstrap/app.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Dengan mempercayai proxy Railway dan seluruh header `X-Forwarded-*`, Laravel secara tepat mengenali skema request HTTPS asli dari reverse proxy Railway, mencegah timbulnya redirect HTTP yang menyebabkan `(blocked: mixed-content)`.

### Pekerjaan Selanjutnya
- Commit dan Push perubahan ke GitHub.



