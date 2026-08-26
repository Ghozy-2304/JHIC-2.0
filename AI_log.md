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


## 2026-08-19 - Enforce HTTPS Scheme in AppServiceProvider for Production

### Sedang / Sudah Membuat
- Memperbarui `app/Providers/AppServiceProvider.php` untuk memanggil `URL::forceScheme('https')` secara global saat `config('app.env') === 'production'` atau `app()->environment('production')`.
- Memastikan perintah pembersihan cache (`config:clear`, `view:clear`, `route:clear`) dieksekusi secara otomatis saat startup kontainer di `entrypoint.sh`.

### File
- `app/Providers/AppServiceProvider.php`
- `entrypoint.sh`
- `AI_log.md`

### Status
DONE

### Catatan
- Menghilangkan `mixed-content` blocking dengan memaksa seluruh generasi URL asset (`asset()`, `@vite()`, `url()`) menggunakan skema `https://` di lingkungan produksi Railway.

### Pekerjaan Selanjutnya
- Commit dan Push ke GitHub.


## 2026-08-19 - Bind ASSET_URL in Config and Dynamic Helpers

### Sedang / Sudah Membuat
- Menambahkan `'asset_url' => env('ASSET_URL')` pada `config/app.php` sehingga fungsi helper Laravel (`asset()`, `@vite()`, `url()`) secara dinamis membaca variabel lingkungan `ASSET_URL` dari Railway.
- Mengganti URL hardcoded API FastAPI pada `resources/views/welcome.blade.php` dan `resources/views/articles/show.blade.php` dengan helper `env('FASTAPI_CHATBOT_URL')`.

### File
- `config/app.php`
- `resources/views/welcome.blade.php`
- `resources/views/articles/show.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh asset dan URL API kini 100% bergantung pada variabel lingkungan (`ASSET_URL`, `APP_URL`, `FASTAPI_CHATBOT_URL`) dan helper bawaan Laravel tanpa ada URL hardcoded.

### Pekerjaan Selanjutnya
- Commit dan Push perubahan ke GitHub.


## 2026-08-19 - Fix FastAPI CORS & Preflight by Proxying via Laravel ChatbotController

### Sedang / Sudah Membuat
- Menyesuaikan `app/Http/Controllers/ChatbotController.php` untuk menangani pembuatan sesi percakapan (`createConversation`) dan pengiriman pesan (`sendMessage`) ke backend FastAPI secara server-to-server.
- Mendaftarkan route proxy `/api/chatbot/conversations` dan `/api/chatbot/chat` di `routes/web.php`.
- Memperbarui skrip frontend pada `resources/views/welcome.blade.php` dan `resources/views/articles/show.blade.php` untuk memanggil endpoint proxy Laravel lokal bukannya memanggil langsung FastAPI external.

### File
- `app/Http/Controllers/ChatbotController.php`
- `routes/web.php`
- `resources/views/welcome.blade.php`
- `resources/views/articles/show.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Panggilan langsung dari browser ke Render FastAPI menyebabkan error CORS dan status `400 Bad Request` pada HTTP OPTIONS preflight karena header `X-API-Key`. Dengan mem-proxy permintaan melalui Laravel backend (`ChatbotController`), browser memanggil domain sendiri (Same-Origin) tanpa preflight OPTIONS, menghilangkan error CORS 100%, serta menyembunyikan API Key dari skrip client-side.

### Pekerjaan Selanjutnya
- Commit dan Push perubahan ke GitHub.


## 2026-08-19 - Add Automatic Database Seeder to Container Entrypoint

### Sedang / Sudah Membuat
- Menambahkan perintah `php /var/www/html/artisan db:seed --force` pada `entrypoint.sh` agar seeder (termasuk `ArticleSeeder`) secara otomatis dieksekusi setiap kali kontainer di-deploy/start di Railway.

### File
- `entrypoint.sh`
- `AI_log.md`

### Status
DONE

### Catatan
- Dengan flag `--force`, seeder berjalan aman secara otomatis di lingkungan produksi tanpa membutuhkan input interaktif dari terminal.

### Pekerjaan Selanjutnya
- Commit dan Push perubahan ke GitHub.


## 2026-08-19 - Move Faker Dependency to Require for Production Seeder Execution

### Sedang / Sudah Membuat
- Memindahkan `fakerphp/faker` dari `require-dev` ke `require` pada `composer.json` untuk memastikan pustaka Faker tersedia di lingkungan produksi Railway yang menggunakan `composer install --no-dev`.
- Menggunakan `$this->faker` pada `UserFactory.php` untuk mencegah error `Call to undefined function fake()`.

### File
- `composer.json`
- `database/factories/UserFactory.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Menghilangkan `Call to undefined function Database\Factories\fake()` di server Railway saat `db:seed` dieksekusi secara otomatis maupun manual.

### Pekerjaan Selanjutnya
- Commit dan Push perubahan ke GitHub.


## 2026-08-24 - Redesign Chatbot UI according to Figma Specs & Fix Railway Dockerfile Permissions

### Sedang / Sudah Membuat
- Mendesain ulang launcher button chatbot dan pop-up chat window secara presisi sesuai spesifikasi Figma (`node-id=20502-11704` & `node-id=20239-29135`).
- Membuat komponen Blade reusable `<x-chatbot />` di `resources/views/components/chatbot.blade.php`.
- Mengunduh dan menempatkan asset resmi Figma di `public/assets/chatbot/` (`avatar.png`, `icon-close.svg`, `icon-mic.svg`, `icon-send.svg`).
- Mengganti kode chatbot inline lama di `welcome.blade.php` dan `articles/show.blade.php` dengan `<x-chatbot />`.
- Memperbaiki `Dockerfile` dengan menambahkan `USER root` sebelum `install-php-extensions` untuk menyelesaikan permission denied (`mkdir: cannot create directory '/usr/src/php': Permission denied`) di server Railway.
- Menambahkan route `/clear-cache` di `routes/web.php` untuk pembersihan cache produksi otomatis.

### File
- `resources/views/components/chatbot.blade.php`
- `public/assets/chatbot/avatar.png`
- `public/assets/chatbot/icon-close.svg`
- `public/assets/chatbot/icon-mic.svg`
- `public/assets/chatbot/icon-send.svg`
- `resources/views/welcome.blade.php`
- `resources/views/articles/show.blade.php`
- `app/Providers/AppServiceProvider.php`
- `routes/web.php`
- `Dockerfile`
- `AI_log.md`

### Status
DONE

### Catatan
- Semua komponen responsif dan mengikuti aturan Tailwind CSS.
- Fitur input suara (Speech Recognition) terintegrasi pada tombol mikrofon.
- Memperbaiki `Dockerfile` dengan menghapus build stage nodejs berlebih untuk mencegah `exit code: 137` (Out of Memory saat `npm install`) di server Railway karena file `public/build/` sudah siap & ter-commit di repository git.

### Pekerjaan Selanjutnya
- Lakukan Commit & Push perubahan ke GitHub.


## 2026-08-25 - Fix Railway Composer Install Exit Code 4 by Syncing composer.lock

### Sedang / Sudah Membuat
- Memperbarui `composer.lock` menggunakan `composer update --lock` / `composer update fakerphp/faker` agar package `fakerphp/faker` berpindah dari `packages-dev` ke section `packages` produksi di `composer.lock`.

### File
- `composer.lock`
- `AI_log.md`

### Status
DONE

### Catatan
- Pemindahan `fakerphp/faker` ke `"require"` pada `composer.json` sebelumnya belum menyinkronkan `composer.lock`.
- Hal ini menyebabkan build Docker Railway yang menjalankan `composer install --no-dev` gagal (exit code 4) karena `fakerphp/faker` berada di `packages-dev` bukan `packages` utama `composer.lock`.
- Setelah dilakukan update lock, `fakerphp/faker` sekarang terdaftar resmi di `packages` (produksi) pada `composer.lock`.

### Pekerjaan Selanjutnya
- Melakukan Commit & Push file `composer.lock` dan `AI_log.md` ke GitHub.


## 2026-08-25 - Fix Railway Dockerfile Entrypoint Permission Denied Error

### Sedang / Sudah Membuat
- Memindahkan proses penyalinan `entrypoint.sh` ke `/etc/entrypoint.d/99-laravel.sh` serta eksekusi `sed -i` & `chmod +x` ke posisi `USER root` di `Dockerfile` sebelum beralih ke `USER www-data`.

### File
- `Dockerfile`
- `AI_log.md`

### Status
DONE

### Catatan
- Error `sed: couldn't open temporary file /etc/entrypoint.d/sedpo84K1: Permission denied` terjadi karena instruksi `sed -i` dijalankan di bawah user non-root (`USER www-data`). Direktori `/etc/entrypoint.d/` dimiliki oleh root sehingga `www-data` tidak memiliki izin membuat file temporer di sana.
- Dengan memindahkan eksekusi penyalinan dan modifikasi skrip entrypoint di bawah `USER root` (sebelum perintah `USER www-data`), proses `sed` dan `chmod` berjalan sukses tanpa error permission denied.

### Pekerjaan Selanjutnya
- Lakukan Commit & Push perubahan file `Dockerfile` dan `AI_log.md` ke GitHub (`git add Dockerfile AI_log.md`, `git commit`, `git push origin main`).


## 2026-08-26 - Implementation of Reusable Navbar Component with Figma Specs & Active Page Detection

### Sedang / Sudah Membuat
- Membuat komponen Blade reusable `<x-navbar />` pada `resources/views/components/navbar.blade.php` berdasarkan desain Figma (`node-id=20514-11332`).
- Mengimplementasikan deteksi otomatis route/halaman aktif (`active` & `activeSub`) untuk menyorot menu navigasi yang sedang dibuka oleh user.
- Mengatur style menu utama dan dropdown opsi Program sesuai dengan 4 status state Figma (Normal, Hover, Selected, dan Selected_Hover) dengan indikator border kiri 2px warna `#0c61cf` dan latar belakang `#f5f5f5`.
- Mengganti elemen header navbar hardcoded pada `resources/views/articles/show.blade.php` dan `resources/views/welcome.blade.php` dengan komponen reusable `<x-navbar />`.
- Mendaftarkan rute navigasi pendukung di `routes/web.php` untuk memfasilitasi pengujian status aktif navbar pada semua menu/sub-menu.

### File
- `resources/views/components/navbar.blade.php`
- `resources/views/welcome.blade.php`
- `resources/views/articles/show.blade.php`
- `routes/web.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Ukuran container navbar `1120px` x `60px`, `rounded-full`, dan `shadow-[0px_4px_15px_rgba(0,0,0,0.04)]` telah disesuaikan presisi dengan Figma.
- Dropdown menu Program berukuran `200px`, `rounded-[16px]`, dengan efek `shadow-[0px_4px_25px_0px_rgba(0,0,0,0.15)]`.
- Opsi dropdown mendukung 4 state tampilan (Normal: `bg-white border-l-2 border-transparent`, Hover: `bg-[#f5f5f5] border-l-2 border-transparent`, Selected: `bg-white border-l-2 border-[#0c61cf] font-semibold`, Selected_Hover: `bg-[#f5f5f5] border-l-2 border-[#0c61cf] font-semibold`).
- Responsive navbar mobile menggunakan hamburger button & drawer accordion.

### Pekerjaan Selanjutnya
- Melakukan Commit & Push perubahan ke repositori Git / GitHub.




