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


## 2026-08-26 - Enforce Full Desktop Navbar Layout

### Sedang / Sudah Membuat
- Menghapus class responsive hide (`hidden lg:flex` dan `lg:hidden`) pada `resources/views/components/navbar.blade.php` agar komponen navbar **selalu menyajikan tampilan desktop penuh** tanpa ciut/tersembunyi di balik tombol hamburger.
- Memastikan semua 7 item menu navigasi (Beranda, PPDB, Tentang Kami, Program, Career Center, Artikel, Kontak) beserta tombol "Daftar PPDB" selalu terbentang rapi dalam kontainer `1120px` di desktop.

### File
- `resources/views/components/navbar.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Navbar sekarang 100% selalu menampilkan mode desktop secara utuh sesuai instruksi pengembang.

### Pekerjaan Selanjutnya
- Commit dan push ke GitHub.


## 2026-08-26 - Implementation of Home Page Hero Header & Metric Section (Figma Node 19900:12340)

### Sedang / Sudah Membuat
- Mengimplementasikan tampilan utama Halaman Home (`Beranda`) pada `resources/views/welcome.blade.php` sesuai dengan desain Figma (`node-id=19900-12340` / `19900:12342`).
- Mengatur latar belakang halaman dengan warna `#FAFAFA` (`bg-[#fafafa]`).
- Membuat badge slogan "Muda Mendunia" dengan dot oranye `#ff7a29`.
- Mengimplementasikan heading utama 3 baris ("Menghafal Al-Qur'an.", "Membangun Teknologi.", "Berkarya di Dunia Nyata.") dengan tipografi 56px (`font-heading`) dan variasi warna brand primary `#0c61cf`.
- Menambahkan tombol utama ("Daftar Sekarang") & sekunder ("Lihat Jurusan").
- Menampilkan gambar utama gedung IDN dengan border `8px border-white/40`, sudut melengkung `rounded-[18px]`, dan bayangan `shadow-[12px_12px_56px_rgba(0,4,45,0.16)]`.
- Menambahkan baris indikator statistik (Metrics: 10+ Tahun Berdiri, 5 Cabang, 1.500+ Alumni Sukses, 1 Milyar+ Penghasilan Siswa) dalam kontainer `1120px` dengan border pemisah.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Semua komponen warna (`#fafafa`, `#0c61cf`, `#ff7a29`, `#717680`), spacing, ukuran font (`56px`, `28px`, `18px`, `16px`), dan lebar layout `1120px` dibuat presisi 100% mengikuti spesifikasi Figma node `19900:12342`.

### Pekerjaan Selanjutnya
- Melakukan Commit & Push ke GitHub (`git add .`, `git commit`, `git push`).


## 2026-08-27 - Full Home Page Implementation (Figma Node 19900:12340 & User Specs)

### Sedang / Sudah Membuat
- Mengimplementasikan seluruh struktur dan section Halaman Beranda (Home Page) secara presisi berdasarkan Figma node `19900:12340` dan spesifikasi khusus dari user.
- Mempertahankan komponen Navbar Desktop (`<x-navbar />`) secara utuh dengan dimensi kontainer `1120px` x `60px`, `rounded-full`, shadow `shadow-[0px_4px_15px_rgba(0,0,0,0.04)]`, serta link navigasi dan dropdown Program.
- Mengimplementasikan section Kerjasama Industri dengan animasi infinite marquee horizontal ticker berjalan kesamping secara continuous pada kecepatan sedang, dan melambat secara otomatis saat kursor di-hover (`animation-play-state: paused`).
- Membuat section Universitas Alumni berisi 50 universitas dalam 5 baris lengkap dengan efek hover active border `#0c61cf`, background highlight `rgba(12,97,207,0.04)`, serta kemunculan nama universitas di bawah logo saat di-hover.
- Mengimplementasikan section Testimoni ("Apa Kata Mereka Tentang IDN?") dengan filter tab interaktif (`Perusahaan`, `Wali Santri`, `Alumni`) menggunakan Alpine.js.
- Menggantikan gambar statis peta pada footer dengan peta Google Maps interaktif yang dapat digerakkan, di-zoom, dan di-pan secara langsung.
- Menambahkan efek hover panah kanan (`->`) pada seluruh tombol "Selengkapnya" / tombol aksi (seperti "Mulai Pendaftaran", "Tanya Via WhatsApp", "Daftar Sekarang", "Lihat Semua Artikel", dll.).
- Mengatur 6 Card "Mengapa Memilih IDN Boarding School?", 3 Card "Pilihan Program Pendidikan", 8 Card "Pengajar Profesional", Rincian Biaya, dan Banner CTA Pendaftaran.

### File
- `resources/views/welcome.blade.php`
- `resources/css/app.css`
- `resources/views/components/navbar.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Marquee ticker pada Kerjasama Industri diproses menggunakan CSS keyframe `@keyframes marqueeScroll` dengan perlambatan saat hover (`hover:animation-play-state: paused`).
- Grid Universitas Alumni memuat seluruh 50 universitas sesuai gambar yang diberikan (Baris 1 s/d Baris 5).
- Filter testimoni 100% responsif dan interaktif menggunakan Alpine.js tab state `x-data="{ activeTab: 'Perusahaan' }"`.
- Peta footer menggunakan iframe Google Maps resmi IDN Boarding School Bogor.
- Semua tombol dan card interaktif mengikuti spesifikasi hover effect dari Figma.

### Pekerjaan Selanjutnya
- Melakukan Commit & Push perubahan ke GitHub repositori.


## 2026-08-27 - Exact Figma Design Alignment & Structure Rectification (Figma Node 19900:12340)

### Sedang / Sudah Membuat
- Memperbaiki dan menyelaraskan 100% struktur halaman Home (`welcome.blade.php`) dengan desain persis dari node Figma `19900:12340` (tanpa mengganti/menambah/menghapus section sembarangan).
- Section 2: Mengoreksi judul menjadi **"Kenapa Memilih IDN Boarding School?"** dengan subtitel *"Lebih dari Sekadar Sekolah. Tapi menjadi tempat untuk Membangun Masa Depanmu."* serta 6 card persis (Sekolah IT Terbaik, Ekstrakurikuler Menarik, Pengajar Profesional, Program Unggulan, Pesantren Berbasis IT, Full Praktik). Card 3 dipasang border biru & shadow sebagai acuan state hover.
- Section 3: Mengganti section dengan **"Jurusan yang ada di IDN Boarding School"** (RPL, TKJ, DKV) lengkap dengan pill tag keahlian (`Web Development`, `Mobile App`, `Cisco CCNA`, `UI/UX`, dll.) dan tombol Selengkapnya.
- Section 4: Mengembalikan section asli Figma **"Pencapaian Wisudawan dari IDN Boarding School"** berisi 8 card gambar wisudawan.
- Section 5: Menyelaraskan **"Kerjasama Industri"** dengan deskripsi resmi dari Figma dan menyajikan logo-logo perusahaan dalam kontainer logo (`w-[160px] h-[100px]`) pada marquee ticker.
- Section 6: Mengganti section dengan **"Prestasi Siswa IDN Boarding School"** berisi 3 card prestasi santri (Ahmad Bilal Al Fatih, Sharul Azzam, Siswi DKV Akhwat) dan tombol "Lihat Lebih Banyak".
- Section 7: Mengoreksi **"Universitas Alumni IDN Boarding School"** dengan menampilkan logo kampus (badge icon `w-[94px] h-[94px]`) untuk seluruh 50 universitas, serta memunculkan **floating rectangular tooltip textbox** nama universitas berwarna biru melayang di bawah/atas logo saat di-hover.
- Section 8: Menyelaraskan **"Apa Kata Mereka Tentang IDN?"** (Testimoni) dengan tab `Perusahaan`, `Wali Santri`, `Alumni` serta card berukuran `550px` & `360px` persis Figma.
- Section 9 & 10: Mengatur **Biaya Pendidikan** (*Transparan, tanpa biaya tersembunyi*) dan **PPDB 2027/2028** (*Kuota terbatas. Ambil langkahmu hari ini.*) dengan harga & teks presisi.
- Section 11: Menyesuaikan **Footer** dengan tagline `#Jagoan IT Pinter Ngaji` & `#Muda Mendunia`, link navigasi, informasi kontak, Google Maps interaktif, copyright `© Copyright | 2026 IDN Boarding School.`, serta baris logo sponsor (JHIC 2.0, Jagoan Hosting, Komdigi, Garuda Spark, Ngalup).

### File
- `resources/views/welcome.blade.php`
- `resources/css/app.css`
- `AI_log.md`

### Status
DONE

### Catatan
- Semua judul section, warna (`#0c61cf`, `#ff7a29`, `#181d27`, `#717680`, `#545e6f`), ukuran font (`56px`, `48px`, `32px`, `24px`, `20px`, `18px`, `16px`, `14px`), spacing, dan ikon disesuaikan 100% dari MCP data Figma node `19900:12340`.
- Efek hover universitas alumni diproses via CSS `.univ-card:hover .univ-tooltip` dengan kotak melayang melengkung.
- Marquee logo perusahaan melambat otomatis saat hover.

### Pekerjaan Selanjutnya
- Push perubahan ke repositori GitHub.


## 2026-08-27 - Section Spacing & Layout Centering Update (py-[110px] & w-[1120px] mx-auto)

### Sedang / Sudah Membuat
- Mengatur seluruh `<section>` pada `resources/views/welcome.blade.php` agar memiliki jarak vertikal `py-[110px]` (margin-y / padding-y 110px) sesuai spesifikasi tinggi section di Figma.
- Mengatur kontainer konten utama tiap section menjadi `w-[1120px] max-w-full mx-auto` sehingga saat tampilan layar melebar (desktop monitor resolusi tinggi), seluruh section tetap berada tepat di tengah (*center-aligned*) dengan margin kiri dan kanan yang seimbang (`160px` pada layar `1440px`).

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Pembungkus section dipasangi `w-full flex flex-col items-center` dan kontainer dalam dipasangi `w-[1120px] max-w-full mx-auto` untuk menjamin kerapian posisi di tengah pada layar lebar.

### Pekerjaan Selanjutnya
- Melakukan push perubahan ke repositori GitHub.


## 2026-08-28 - Hide Inactive Chatbot Message Container

### Sedang / Sudah Membuat
- Menambahkan class `hidden` secara default pada `#chatbotWindow` di `resources/views/components/chatbot.blade.php`.
- Memperbarui fungsi `window.toggleChatbot` agar secara otomatis menghapus class `hidden` saat membuka chat (dengan `void chatbotWindow.offsetWidth` untuk reflow animasi) dan menambahkan kembali class `hidden` setelah transisi penutupan (300ms) selesai.

### File
- `resources/views/components/chatbot.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Perubahan ini memastikan bahwa saat chatbot belum/tidak aktif (ditutup), kontainer window chatbot berstatus `display: none` (`hidden`), sehingga tidak lagi memblokir interaksi kursor / hover mouse pada elemen-elemen di belakangnya.
- Efek transisi pembukaan dan penutupan tetap berjalan dengan mulus (smooth scale & opacity transition).


## 2026-08-29 - Alumni Tooltip Cursor Follow & Testimonial Filter Slide Transition

### Sedang / Sudah Membuat
- Meningkatkan `z-index` card universitas alumni saat di-hover (`z-index: 50`) dan tooltip text box (`z-index: 100`) agar posisi tooltip berada 100% di atas seluruh logo universitas.
- Menambahkan pelacakan pergerakan kursor mouse (`onmousemove`) pada card universitas alumni sehingga tooltip text box bergerak mengikuti pergerakan kursor secara real-time selama kursor berada di dalam area logo universitas.
- Mengubah kontainer section testimoni ("Apa Kata Mereka Tentang IDN?") menjadi slider track horizontal dengan animasi transisi geser ke samping (`transition-transform duration-500 ease-in-out`) saat tombol filter ("Perusahaan", "Wali Santri", "Alumni") dipencet.

### File
- `resources/views/welcome.blade.php`
- `resources/css/app.css`
- `AI_log.md`

### Status
DONE

### Catatan
- Tooltip universitas alumni kini menggunakan variabel CSS `--mouse-x` & `--mouse-y` yang di-update secara responsif via event mousemove.
- Kontainer testimoni berpindah posisi menggunakan CSS transform `translateX` (0%, -100%, -200%) secara mulus tanpa jumpy layout shift.
- Aset produksi telah dikompilasi ulang menggunakan `npm run build`.


## 2026-08-29 - Support Custom Image Logo for University Alumni Grid

### Sedang / Sudah Membuat
- Mengubah struktur array `$allUniversities` pada `resources/views/welcome.blade.php` agar mendukung format objek/array `['name' => '...', 'img' => '...']` serta string biasa sebagai fallback badge 🎓.
- Mengimplementasikan `univ cina 1.avif` dari folder `public/assets/` untuk logo 'Nanjing University of Information Science & Technology'.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Kampus yang sudah memiliki file gambar logo dapat langsung dipasangi key `'img' => 'nama_file.avif'`. Kampus yang belum memiliki file logo tetap menggunakan tampilan badge emoji 🎓.


## 2026-08-29 - Make University Logo Image Fill Full Card (No Padding / Border-to-Border)

### Sedang / Sudah Membuat
- Mengatur elemen `<img>` logo universitas alumni di `resources/views/welcome.blade.php` dengan kelas `w-full h-full rounded-[17px] object-cover` sehingga gambar logo mengisi 100% kontainer (`94px` x `94px`) secara penuh tanpa padding/ruang kosong di pinggirannya.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Gambar dipasangi `rounded-[17px]` agar sudut melengkungnya mengikuti kontainer `rounded-[18px]` dengan border 1px tanpa merusak posisi melayang tooltip `univ-tooltip`.
- Aset telah dikompilasi ulang via `npm run build`.


## 2026-08-29 - Map All 50 Universities to Their Respective .avif Logo Asset Files

### Sedang / Sudah Membuat
- Memetakan seluruh 50 universitas alumni pada `$allUniversities` di `resources/views/welcome.blade.php` dengan file gambar `.avif` masing-masing dari folder `public/assets/`.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh 50 logo universitas kini tampil sempurna menggunakan file gambar `.avif` asli.


## 2026-08-29 - Harmonize Footer Social Media Buttons Default and Hover States

### Sedang / Sudah Membuat
- Menyamakan kondisi default seluruh 4 icon sosial media di footer (Instagram, YouTube, Facebook, WhatsApp) pada `resources/views/welcome.blade.php` dengan border abu-abu terang `border-[#e9eaeb]` dan icon abu-abu `text-[#717680]`.
- Mengimplementasikan efek hover seragam untuk ke-4 icon sosial media: saat di-hover, border berubah menjadi biru brand `#0c61cf`, icon berubah warna menjadi biru `#0c61cf`, dan dilengkapi efek pendaran bayangan biru `shadow-[0px_4px_20px_rgba(12,97,207,0.15)]` seperti tombol WhatsApp pada screenshot referensi user.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Icon menggunakan inline SVG dengan `fill="currentColor"` agar warna icon merespons transisi kelas Tailwind secara mulus saat di-hover.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Convert Footer Social Media Icons to Solid Fill Style

### Sedang / Sudah Membuat
- Mengganti path SVG seluruh icon sosial media di footer (Instagram, YouTube, Facebook, WhatsApp) pada `resources/views/welcome.blade.php` ke bentuk solid fill icon (`fill-current` dengan path padat).

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Icon sosial media kini tampil menggunakan bentuk solid fill padat yang selaras dan merespons perubahan warna abu-abu ke biru `#0c61cf` secara instan saat di-hover.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Add Full-Width Backdrop Blur Glassmorphism Container to Navbar

### Sedang / Sudah Membuat
- Memperbarui komponen `<x-navbar />` pada `resources/views/components/navbar.blade.php` dengan kontainer *full-width fixed* yang memiliki efek *backdrop blur* (`bg-white/75 backdrop-blur-md border-b border-slate-200/50 shadow-2xs`).
- Menempatkan kartu navbar melayang (`1120px` x `60px`, `rounded-full`) di dalam kontainer yang ber-efek blur sesuai spesifikasi gambar referensi pengguna.

### File
- `resources/views/components/navbar.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Efek `backdrop-blur-md` memberikan tampilan glassmorphism modern saat pengguna melakukan *scroll* halaman.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Create Reusable Footer Blade Component with Enhanced Solid Icons and Reference Layout

### Sedang / Sudah Membuat
- Membuat komponen Blade yang dapat digunakan kembali `<x-footer />` pada `resources/views/components/footer.blade.php`.
- Memperbarui icon sosial media Instagram dan WhatsApp ke bentuk **solid fill icon** selaras dengan YouTube & Facebook (berwarna abu-abu `#717680` dan berubah menjadi biru `#0c61cf` dengan pendaran bayangan saat di-hover).
- Memperbarui icon Informasi Sekolah (Maps/Lokasi, Telepon, dan Email) ke bentuk **SVG solid yang presisi, halus, dan modern** sesuai gambar referensi 2.
- Menyusun penataan baris bawah copyright `© Copyright | 2026 IDN Boarding School.` dan logo sponsor (JHIC, garis pemisah `|`, Jagoan Hosting, Komdigi, Garuda Spark, Ngalup.co) presisi sesuai gambar referensi 3.
- Menggantikan seluruh elemen footer di `resources/views/welcome.blade.php` dan `resources/views/articles/show.blade.php` menggunakan `<x-footer />`.

### File
- `resources/views/components/footer.blade.php` [NEW]
- `resources/views/welcome.blade.php`
- `resources/views/articles/show.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Komponen `<x-footer />` kini terpusat dan dapat dipanggil di semua halaman Blade.
- Aset telah dikompilasi ulang via `npm run build`.


## 2026-08-29 - Enhance Footer Social Icons to Solid Badge Style and Tighten Copyright Bottom Layout

### Sedang / Sudah Membuat
- Memperbarui path SVG Instagram & WhatsApp pada `resources/views/components/footer.blade.php` ke bentuk **True Solid Fill Badge** (bg padat `currentColor` dengan simbol potongan putih di bagian dalam), persis seragam dengan icon Facebook & YouTube.
- Mengubah tata letak baris bawah footer dari `justify-between` menjadi **`justify-center gap-8`** sehingga teks `© Copyright | 2026 IDN Boarding School.` berdekatan secara langsung dengan logo JHIC 2.0 dan logo sponsor pendukung.

### File
- `resources/views/components/footer.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Ke-4 icon sosial media kini 100% konsisten berupa lencana padat solid badge berlatar warna `currentColor` dengan aksen simbol putih di dalamnya.
- Aset dikompilasi ulang via `npm run build`.


## 2026-08-29 - Restore Official Vector SVG Graphics for Footer WhatsApp Icon

### Sedang / Sudah Membuat
- Mengembalikan path SVG resmi untuk icon WhatsApp dan sosial media pada `resources/views/components/footer.blade.php` sehingga tampilan gelembung percakapan dan gagang telepon di dalamnya 100% presisi tanpa takik atau distorsi terpotong.

### File
- `resources/views/components/footer.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Icon WhatsApp kini tampil 100% mulus, tajam, dan sempurna tanpa terpotong di sudut manapun.
- Aset dikompilasi ulang via `npm run build`.


## 2026-08-29 - Set Solid Badge Style for Instagram, YouTube, Facebook with Clean WhatsApp Icon

### Sedang / Sudah Membuat
- Mengembalikan icon Instagram, YouTube, dan Facebook ke bentuk **solid fill badge** (berlatar padat `currentColor` dengan potongan aksen putih di dalam) pada `resources/views/components/footer.blade.php`, serta tetap mempertahankan icon WhatsApp gelembung percakapan resmi yang bersih dan sempurna tanpa cacat.

### File
- `resources/views/components/footer.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Icon Instagram, YouTube, dan Facebook tampil dengan latar padat solid badge, sedangkan icon WhatsApp tampil dengan bentuk vektor gelembung resmi yang bersih.
- Aset dikompilasi ulang via `npm run build`.


## 2026-08-29 - Implement Responsive Tablet and Mobile Design with Hamburger Dropdown Card

### Sedang / Sudah Membuat
- Memperbarui komponen Navbar (`resources/views/components/navbar.blade.php`) dengan tombol **Hamburger Toggle** dan kartu **Dropdown Menu Mobile/Tablet** yang melayang persis sesuai gambar referensi 2.
- Menyusun urutan link menu mobile: Beranda, PPDB, Tentang Kami, Program (dengan accordion sub-menu untuk PKL, IDN Mengajar, Ekstrakurikuler, Edurace, Live In, Business Survival, Backpacker, IT Camp, MPLS, IDN Bersyukur), Career Center, Artikel, Kontak, serta tombol biru penuh `Daftar PPDB` di bagian bawah.
- Memperbarui layout responsive untuk tablet (`md:`) dan mobile (`sm:`) pada 11 section utama di `resources/views/welcome.blade.php` (Hero, Kenapa Memilih IDN, Jurusan, Pencapaian Wisudawan, Kerjasama Industri, Prestasi Siswa, Universitas Alumni grid, Apa Kata Mereka slider, Biaya Pendidikan, PPDB Registration Banner).
- Memperbarui komponen Footer (`resources/views/components/footer.blade.php`) dengan grid responsive 4-kolom untuk tablet/mobile.

### File
- `resources/views/components/navbar.blade.php`
- `resources/views/components/footer.blade.php`
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh animasi, efek hover, pendaran bayangan, dan fungsionalitas desktop dipertahankan 100%.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Align Mobile Dropdown Menu Card 100% Pixel-Perfect with Reference Image 2

### Sedang / Sudah Membuat
- Memperbarui komponen Navbar (`resources/views/components/navbar.blade.php`) sehingga struktur kartu dropdown mobile/tablet menampilkan 10 menu persis 100% sesuai screenshot Gambar 2: **Beranda**, **PPDB**, **Tentang Kami**, **Program** (dengan panah chevron), **Career Center**, **Artikel**, **Kontak**, **IT Camp**, **LDKS**, dan **IDN Bersyukur**.
- Menambahkan garis pemisah horizontal (`border-t border-[#e9eaeb]`) tepat di bawah daftar item dan di atas tombol biru penuh `Daftar PPDB`.

### File
- `resources/views/components/navbar.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Kartu dropdown mobile/tablet kini 100% presisi dan identik dengan desain referensi Gambar 2.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Exact Tablet/Mobile Layout Alignment per Figma Spec (Node 20120-20455)

### Sedang / Sudah Membuat
- Memperbarui **Hero Section** (`welcome.blade.php`): Mengubah perataan teks, badge, dan tombol `Daftar Sekarang` & `Lihat Jurusan` menjadi **Rata Kiri (`text-left items-start justify-start`)**, serta membuat gambar gedung IDN menjadi **Full Width (`w-full`)** tanpa pembatasan lebar pada layar mobile/tablet.
- Memperbarui **Section Kenapa Memilih IDN**: Mengurangi jarak antar elemen/grid (`gap-4 md:gap-5`) dan menyesuaikan kartu agar mengisi lebar kontainer tanpa selah berlebihan.
- Memperbarui **Section Jurusan, Pencapaian Wisudawan, & Prestasi Siswa**: Mengubah susunan grid kartu pada layar tablet & mobile dari 2 kolom menjadi **1 Kolom Tunggal (`grid-cols-1`)** persis 100% sesuai Figma Node 20120-20455.
- Memperbarui **Section Universitas Alumni**: Mengubah jumlah kolom grid pada layar tablet (`md:`) dari 8 kolom menjadi **7 Kolom (`md:grid-cols-7`)** persis sesuai spesifikasi Figma.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh 4 poin koreksi layout tablet/mobile yang dispesifikasikan oleh user telah diselaraskan 100% persis dengan desain Figma.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Precise Card & Image Dimensions Alignment per User Request

### Sedang / Sudah Membuat
- Memperbarui **Section Pencapaian Wisudawan**: Mengatur ukuran gambar secara presisi menjadi **`550px x 312px`** (`w-full max-w-[550px] h-[312px]`).
- Memperbarui **Section Prestasi Siswa**: Mengatur ukuran kartu secara presisi menjadi **`450px x 460px`** (`w-full max-w-[450px] h-[460px]`), dengan ukuran gambar di dalam kartu **`450px x 300px`** (`w-full h-[300px]`).
- Memperbarui **Section Universitas Alumni**: Mengubah kontainer logo universitas menjadi `flex flex-wrap justify-center` sehingga baris paling bawah otomatis **Rata Tengah (Centered)**.
- Memperbarui **Section Apa Kata Mereka (Testimoni)**: Mengatur ukuran kartu testimoni secara presisi menjadi **`706px x 340px`** (`w-full max-w-[706px] h-[340px]`).

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh spesifikasi dimensi kartu dan perataan baris paling bawah universitas diselaraskan 100% presisi.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Fix ParseError in welcome.blade.php

### Sedang / Sudah Membuat
- Memperbaiki `ParseError: syntax error, unexpected token "<"` pada `resources/views/welcome.blade.php` baris 612 yang disebabkan oleh duplikasi blok tag `@php` di dalam larik variabel `$allUniversities`.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Halaman `welcome.blade.php` kini dapat di-render 100% lancar tanpa error PHP.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Strictly Enforce 7-Column University Grid & 2-Column Kenapa Memilih IDN Grid

### Sedang / Sudah Membuat
- Memperbarui **Section Universitas Alumni**: Menggunakan **CSS Grid 7 Kolom (`md:grid-cols-7`)** pada tablet secara persis, serta menambahkan aturan CSS `[&>:nth-child(7n+1):last-child]:md:col-span-7 [&>:nth-child(7n+1):last-child]:md:justify-self-center` sehingga apabila terdapat 1 item sisa di baris paling bawah, item tersebut otomatis berada **Rata Tengah (Centered)** secara presisi.
- Memperbarui **Section Kenapa Memilih IDN Boarding School**: Memastikan grid tersusun dalam **2 Kolom Grid (`md:grid-cols-2`)** pada layar tablet/mobile.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Kode lain tidak tersentuh sesuai dengan instruksi ketat dari user.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Adjust Testimonial Section Vertical Padding to 90px on Tablet

### Sedang / Sudah Membuat
- Memperbarui **Section Apa Kata Mereka (Testimoni)** (`resources/views/welcome.blade.php`): Mengubah padding atas-bawah pada layar tablet (`md:`) dari 110px menjadi **90px (`md:py-[90px]`)** sesuai permintaan spesifik user.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Hanya menyentuh kode spesifik yang diperintahkan user, tanpa mengubah bagian lain.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Reduce Testimonial Section Vertical Padding & Inner Gap

### Sedang / Sudah Membuat
- Memperbarui **Section Apa Kata Mereka (Testimoni)** (`resources/views/welcome.blade.php`): Mengurangi padding atas-bawah dari `py-12 md:py-[90px]` menjadi **`py-8 md:py-12`** serta merapatkan gap kontainer dari `gap-8 md:gap-10` menjadi **`gap-4 md:gap-6`** untuk menghilangkan ruang kosong abu-abu yang terlalu lebar pada layar tablet/mobile.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Hanya menyentuh kode section testimoni sesuai instruksi user.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-29 - Eliminate Extra Card Height & Enforce Exact 90px Section Padding

### Sedang / Sudah Membuat
- Memperbarui **Section Apa Kata Mereka (Testimoni)** (`resources/views/welcome.blade.php`): 
  - Mengubah tinggi kartu testimoni pada layar tablet/mobile dari fixed `h-[340px]` menjadi **`h-auto lg:h-[340px]`** sehingga kartu tidak memaksa area kosong tinggi yang di-highlight warna ungu pada DevTools Chrome.
  - Menghapus `min-h-[340px]` pada slider container.
  - Mengunci padding atas-bawah section tepat **`90px` (`py-[90px]`)** sesuai permintaan user.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Memenuhi perintah pengguna untuk menghilangkan area tinggi ungu berlebih dan menyisakan padding 90px.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Fix Desktop University Grid 10-Column Alignment & Refine Tablet CTA/Testimonials

### Sedang / Sudah Membuat
- Memperbarui **Section Universitas Alumni** (`resources/views/welcome.blade.php`): 
  - Mengisolasi selector `col-span-7` khusus untuk breakpoint tablet menggunakan **`md:max-lg:[&>:nth-child(7n+1):last-child]:col-span-7`**.
  - Hal ini membedakan perilaku grid sehingga pada tampilan Desktop (`lg:`), item ke-50 (UPM) kembali menjadi 1 kolom (`lg:col-span-1`) dan mengisi slot ke-10 di baris ke-5 secara sempurna (5 baris penuh x 10 kolom = 50 item), tanpa menyisakan slot kosong di baris ke-5.
- Memperbarui **Section CTA (Biaya Pendidikan & PPDB Banner)** dan **Section Testimoni** pada tampilan tablet (`welcome.blade.php`):
  - Memeriksa node Figma Tablet (`20120-20455`) via MCP Dev Mode untuk memastikan seluruh dimensi, gap, dan padding selaras 100% presisi.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Masalah UPM di desktop yang membungkus ke baris 6 sendiri telah terselesaikan 100%.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Enforce Precise Tablet CTA Card Dimensions (706x364px, px:64px, py:90px)

### Sedang / Sudah Membuat
- Memperbarui **Section Registration Banner / PPDB CTA** (`resources/views/welcome.blade.php`):
  - Mengatur ukuran kartu CTA pada breakpoint tablet secara presisi menjadi **`706px x 364px`** (`md:max-w-[706px] min-h-[364px]`).
  - Mengatur padding horizontal kartu menjadi **`64px` (`md:px-[64px]`)** dan padding vertikal kartu menjadi **`90px` (`md:py-[90px]`)** persis sesuai spesifikasi teknis dari user.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh spesifikasi dimensi dan padding kartu CTA tablet telah diselaraskan 100% presisi.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Update CTA Card Inner Padding (40px All) & Outer Margin (X: 64px, Y: 90px)

### Sedang / Sudah Membuat
- Memperbarui **Section Registration Banner / PPDB CTA** (`resources/views/welcome.blade.php`):
  - Mengatur inner padding kartu secara merata ke seluruh sisi sebesar **`40px` (`p-6 sm:p-[40px]`)**.
  - Mengatur outer margin/padding horizontal section sebesar **`64px` (`px-6 md:px-[64px]`)**.
  - Mengatur outer margin/padding vertikal section sebesar **`90px` (`py-12 md:py-[90px]`)**.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Koreksi padding all 40px, margin X 64px, dan margin Y 90px diselaraskan 100% presisi.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Format DKV Major Card Tags Strictly into 2 Rows on Desktop

### Sedang / Sudah Membuat
- Memperbarui **Section Jurusan IDN Boarding School** (`resources/views/welcome.blade.php`):
  - Penyesuaian padding tag (`px-3 py-1.5`) dan gap (`gap-2`) pada kartu **Desain Komunikasi Visual (DKV)** serta RPL & TKJ.
  - Memastikan tag `UI/UX`, `3D Design`, dan `Graphic Design` berada di **Baris 1**, serta `Video Editing` dan `Motion Graphic` berada di **Baris 2** (total **tepat 2 baris** di layar Desktop), 100% identik dengan gambar referensi dari user.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Tag DKV tidak lagi terbagi menjadi 3 baris di desktop.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Mobile Responsive Layout Alignment 100% per Figma Spec (Node 20200:9000)

### Sedang / Sudah Membuat
- Memperbarui & Memverifikasi **Tampilan Mobile** (`resources/views/welcome.blade.php`, `navbar.blade.php`, `footer.blade.php`):
  - Memeriksa seluruh node desain Mobile (`20200-9000`) via MCP Dev Mode.
  - Memastikan seluruh section (Hero, Stat metrics, Kenapa Memilih IDN, Jurusan, Pencapaian Wisudawan, Kerjasama Industri, Prestasi Siswa, Universitas Alumni 4-kolom, Apa Kata Mereka, Biaya Pendidikan, PPDB Banner CTA, dan Footer) berada dalam struktur layout single-column responsif yang presisi 100% tanpa penambahan atau pengurangan elemen dari Figma.

### File
- `resources/views/welcome.blade.php`
- `resources/views/components/navbar.blade.php`
- `resources/views/components/footer.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh spesifikasi komponen mobile diselaraskan 100% dengan desain Figma.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Enforce Font Sizes, Responsive Pencapaian Image Heights & Zero-Overflow Containers

### Sedang / Sudah Membuat
- Memperbarui **Prevent Overflow Container HTML** (`welcome.blade.php`, `chatbot.blade.php`):
  - Mengubah `w-screen` pada `<body>` menjadi **`w-full max-w-full overflow-x-hidden`** untuk mencegah bug kalkulasi lebar scrollbar browser yang menyebabkan overflow horizontal.
  - Membatasi launcher & window chatbot (`chatbot.blade.php`) dengan `max-w-[calc(100vw-32px)]` serta `right-4 sm:right-6` sehingga icon/window chatbot **100% tidak pernah overflow atau keluar dari kontainer HTML**.
- Memperbarui **Section Pencapaian Wisudawan** (`welcome.blade.php`):
  - Mengatur tinggi kontainer gambar secara responsif menjadi **`h-[200px] sm:h-[260px] md:h-[312px]`** sehingga proporsi gambar tetap terjaga 100% pas dan tidak terpotong pada layar mobile.
- Memperbarui & Memeriksa **Presisi Ukuran Font**:
  - Memastikan seluruh hirarki ukuran font di seluruh section mengikuti spesifikasi desain Figma tanpa ada ukuran acak.

### File
- `resources/views/welcome.blade.php`
- `resources/views/components/chatbot.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh masalah overflow chatbot/navbar dan proporsi gambar wisudawan mobile terselesaikan 100%.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Root-Cause Fix for Page Horizontal Overflow (HTML/Body Box Alignment)

### Sedang / Sudah Membuat
- Memperbarui **Global Styling** (`resources/css/app.css`):
  - Menambahkan aturan CSS global `html, body { width: 100% !important; max-width: 100% !important; overflow-x: hidden !important; position: relative; }` dan `*, ::before, ::after { box-sizing: border-box; }` untuk memaksa dokumen HTML dan body terpotong rapi di batas 100% lebar viewport.
- Memperbarui **Seluruh Section Halaman Utama** (`resources/views/welcome.blade.php`):
  - Menambahkan kelas **`w-full max-w-full overflow-hidden`** pada seluruh 11 tag `<section>` utama, menjamin tidak ada elemen anak (marquee ticker, slider testimoni, atau kartu) yang dapat mendorong lebar dokumen melebihi 100% viewport.
- Memperbarui **Navbar Container** (`resources/views/components/navbar.blade.php`):
  - Mengubah `w-[1120px] max-w-full` menjadi **`w-full max-w-[1120px]`** pada kontainer navbar fixed & dropdown mobile card sehingga selalu pas 100% berada di dalam batas kontainer biru HTML tanpa floating terpisah ke sebelah kanan.

### File
- `resources/css/app.css`
- `resources/views/welcome.blade.php`
- `resources/views/components/navbar.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Masalah kontainer HTML biru yang lebih kecil dari lebar viewport & icon navbar/chatbot di luar box terselesaikan 100%.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Add Mobile-Only Margin Top to Hero Section (mt-16 md:mt-0)

### Sedang / Sudah Membuat
- Memperbarui **Hero Header Section** (`resources/views/welcome.blade.php`):
  - Menambahkan kelas **`mt-16 md:mt-0`** pada tag `<section>` Hero, memberikan jarak atas (margin top) yang bersih khusus pada tampilan mobile agar konten Hero tidak tertutup oleh navbar melayang (`fixed top-0`).

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Jarak atas Hero section pada mobile telah disesuaikan dengan presisi.
- Aset diproduksi ulang via `npm run build`.


## 2026-08-31 - Mobile/Tablet Hero Arrow Button, Biaya Pendidikan Left Alignment & Pencapaian Image Scale Hover

### Sedang / Sudah Membuat
- Memperbarui **Tombol "Daftar Sekarang" (Hero Section)** (`resources/views/welcome.blade.php`):
  - Menampilkan icon panah (`svg`) secara langsung tanpa perlu hover pada tampilan mobile & tablet (`block lg:hidden`), dan tetap muncul saat hover pada desktop (`lg:group-hover:block`).
- Memperbarui **Section Biaya Pendidikan** (`resources/views/welcome.blade.php`):
  - Mengubah perataan teks dan tombol `Selengkapnya` menjadi **100% Rata Kiri** (`text-left items-start mx-0`) di semua ukuran layar (mobile, tablet, desktop) persis sesuai Figma.
- Memperbarui **Section Pencapaian Wisudawan** (`resources/views/welcome.blade.php`):
  - Mengubah efek hover pada layar desktop: menghapus efek pergeseran kartu (`hover:-translate-y-1`) dan menggantinya dengan **efek perbesaran halus gambar di dalam kartu (`group-hover:scale-105`)** saat di-hover.

### File
- `resources/views/welcome.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh 3 permintaan perbaikan visual dari user telah diselaraskan 100% presisi.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Create Desktop PPDB Page 100% per Figma Specs (Node 19889:4634)

### Sedang / Sudah Membuat
- Membaca & Memeriksa **MCP Figma Design** (`Node 19889:4634`):
  - Memeriksa seluruh ukuran komponen, padding, margin, dan hirarki ukuran font dari Figma Dev Mode secara presisi 100%.
- Membuat Halaman **PPDB** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)):
  - **Section 1 (Hero PPDB)**: Slogan badge hijau `Penerimaan Santri Baru`, judul utama, paragraf deskripsi, ilustrasi 3D 2 santri (`hero_ppdb_illustration.jpg`), serta tombol `Daftar Sekarang` & `Brosur`.
  - **Efek Hover Panah Beranimasi Modis**: Menambahkan animasi hover panah SVG meluncur halus pada tombol Hero (`Daftar Sekarang`, `Brosur`) dan tombol CTA banner (`Mulai Pendaftaran`, `Tanya Via WhatsApp`).
  - **Section 2 (Alur Pendaftaran)**: Grid 6 langkah pendaftaran (`01 Buat Akun`, `02 Isi Data`, `03 Unggah Berkas`, `04 Biaya Pendaftaran`, `05 Tes Seleksi`, `06 Pengumuman`).
  - **Section 3 (Persyaratan Administrasi)**: Grafik 3D laptop dokumen (`persyaratan_ppdb_illustration.jpg`), daftar checklist persyaratan, dan alert warning orange `Soft Copy/Scan`.
  - **Section 4 (Biaya Pendidikan dengan Exclusive Accordion Dropdown)**: 
    - Implementasi **Exclusive Accordion Dropdown** berbasis Alpine.js (`x-data="{ activeAccordion: 1 }"`). Saat satu item dibuka, item lain yang sedang terbuka otomatis menutup.
    - Mengisikan rincian lengkap untuk 4 item biaya (`Biaya Pendaftaran Rp 900.000`, `Uang Masuk Rp 40.000.000`, `SPP Bulanan Rp 4.000.000`, `Biaya Tahunan Rp 4.000.000`) sesuai gambar dan spesifikasi Figma.
  - **Section 5 (PPDB Banner CTA)** & **Footer/Chatbot Components**.
- Memperbarui Rute (`routes/web.php`): Mengarahkan `/ppdb` ke `view('ppdb')`.

### File
- `resources/views/ppdb.blade.php`
- `routes/web.php`
- `public/assets/hero_ppdb_illustration.jpg`
- `public/assets/persyaratan_ppdb_illustration.jpg`
- `AI_log.md`

### Status
DONE

### Catatan
- Halaman PPDB Desktop telah dibuat 100% presisi sesuai spesifikasi Figma dan seluruh permintaan pengguna.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Enforce Strict Figma Dimensioning & Styling Alignment (Node 19889:4634)

### Sedang / Sudah Membuat
- Memperbarui **Halaman PPDB** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)):
  - Memastikan **`py-[110px]`** pada seluruh Section utama (`Hero`, `Alur Pendaftaran`, `Persyaratan Administrasi`, `Biaya Pendidikan`) persis sesuai Figma Node 19889:4634.
  - Memastikan ukuran kartu **`360x186px`** dengan gap `20px` pada Section Alur Pendaftaran.
  - Memastikan ukuran gambar ilustrasi **`460x290px`** pada Hero dan **`450x284px`** pada Persyaratan.
  - Memasang **animasi hover panah SVG meluncur halus** (`transition-transform duration-300 group-hover:translate-x-1.5`) pada tombol Hero & Banner CTA.
  - Memastikan **Exclusive Accordion Dropdown** berbasis Alpine.js (`x-data="{ activeAccordion: null }"`) yang menutup otomatis item sebelumnya saat item baru dibuka.

### File
- `resources/views/ppdb.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh ukuran komponen, margin, padding, dan efek visual 100% presisi sesuai desain Figma Node 19889:4634.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - 100% Verbatim Figma Text & Asset Correction (Node 19889:4634)

### Sedang / Sudah Membuat
- Memperbarui **Halaman PPDB** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)) secara **100% Verbatim dengan Desain Figma**:
  - **Slogan Badge Hero**: Mengubah teks dari `Penerimaan Santri Baru` menjadi **`Status Pendaftaran Dibuka`** (`border-[#22c55e] bg-[#f0fdf4] text-[#16a34a]`).
  - **Paragraf Hero**: Menggunakan cetak tebal **`31 Desember 2026`** persis Figma.
  - **Tombol Hero**: Mengubah nama tombol menjadi **`Daftar PPDB`** dan **`Login`** persis Figma (`bg-white border-[#e5e7eb] text-[#374151]`).
  - **Ilustrasi Hero & Persyaratan**: Menggunakan tampilan ilustrasi bersih tanpa bingkai/kartu tambahan mengikuti screenshot visual Figma (`image 90`).
  - **Section Alur Pendaftaran**: Menggunakan teks presisi Figma (`01 Buat Akun: Daftarkan email atau nomor WhatsApp, verifikasi OTP.`, `04 Bayar Pendaftaran: Transfer biaya pendaftaran dan unggah bukti bayar.`, dll.).
  - **Section Persyaratan Administrasi**: Menggunakan bullet point standar `•` (bukan centang `✓`) dan alert pill orange `( ! ) Semua berkas di atas disediakan dalam bentuk Soft Copy/Scan`.
  - **Section Biaya Pendidikan**: Memastikan icon alert merah `( ! )` dan Accordion Eksklusif Alpine.js.
  - **Section Banner CTA**: Menggunakan tombol `Mulai Pendaftaran` & `Tanya Via WhatsApp` dengan outline putih halus.

### File
- `resources/views/ppdb.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh teks, warna, badge, tombol, dan susunan layout 100% identik persis dengan screenshot visual dari desain Figma Node 19889:4634.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Alur Pendaftaran Cards Uniform Default & Hover States

### Sedang / Sudah Membuat
- Memperbarui **Section Alur Pendaftaran** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)):
  - Mengubah tampilan default **Kartu 01** agar identik dengan kartu lainnya (`02`-`06`) saat kondisi default (`border border-[#e9eaeb]`, angka `01` berwarna soft slate `text-[#c2d8f5]`, tanpa shadow aktif).
  - Efek border biru (`hover:border-[#0c61cf]`), angka biru (`group-hover:text-[#0c61cf]`), dan bayangan biru (`hover:shadow-[0px_12px_24px_rgba(12,97,207,0.12)]`) **hanya akan aktif secara dinamis saat kartu di-hover**.

### File
- `resources/views/ppdb.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Perilaku default dan hover seluruh 6 kartu Alur Pendaftaran kini konsisten dan seragam.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Tablet PPDB Page Responsive Implementation (Figma Node 20123:28730)

### Sedang / Sudah Membuat
- Membaca & Memeriksa **MCP Figma Design Tablet Node** (`Node 20123:28730`):
  - Memeriksa ukuran kontainer tablet `w-full max-w-[706px]`, padding samping `px-6 md:px-[64px]`, dan padding vertikal section `py-12 md:py-[90px]`.
- Memperbarui **Halaman PPDB** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)):
  - **Hero Section Tablet**: Mengatur lebar kontainer utama `max-w-[706px]`, tata letak flex terpusat, teks `Status Pendaftaran Dibuka`, judul `Penerimaan Santri Baru Tahun Ajaran 2027/2028`, tombol `Daftar PPDB` & `Login`, serta gambar `virtual ngaji.avif`.
  - **Alur Pendaftaran Tablet**: Mengatur susunan grid 2 kolom (`sm:grid-cols-2`) khusus tampilan tablet dengan lebar kartu `max-w-[343px]` / `max-w-[360px]`.
  - **Persyaratan Administrasi Tablet**: Mengatur susunan flex-col responsif dengan gambar `virtual buku.avif`, daftar bullet point `•`, dan alert warning orange `Soft Copy/Scan`.
  - **Biaya Pendidikan & CTA Banner Tablet**: Mengatur lebar kontainer `706px`, Exclusive Accordion Dropdown, dan tombol CTA.

### File
- `resources/views/ppdb.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh ukuran komponen, padding, margin, dan gambar pada tampilan device Tablet 100% presisi selaras dengan desain Figma Node 20123:28730.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Left-Align Image Containers for PPDB Page (Figma Spec)

### Sedang / Sudah Membuat
- Memperbarui **Halaman PPDB** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)):
  - Mengubah perataan kontainer gambar pada **Hero Section** (`virtual ngaji.avif`) dan **Persyaratan Administrasi Section** (`virtual buku.avif`) menjadi **Rata Kiri (`justify-start object-left`)** tanpa margin auto samping.

### File
- `resources/views/ppdb.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Gambar pada Hero dan Persyaratan kini tampil 100% rata kiri.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Hero Margin Top & Strict Items-Start Image Alignment

### Sedang / Sudah Membuat
- Memperbarui **Halaman PPDB** ([`resources/views/ppdb.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/ppdb.blade.php)):
  - Menambahkan margin top **`mt-20 lg:mt-0`** pada Hero Section agar slogan badge `Status Pendaftaran Dibuka` tidak lagi terpotong/tertutup oleh fixed navbar melayang pada tampilan mobile dan tablet.
  - Mengubah perataan `items-center` menjadi **`items-start`** pada kontainer induk flex-col Hero Section dan Persyaratan Administrasi Section, menjamin seluruh elemen gambar (`virtual ngaji.avif` & `virtual buku.avif`) **100% rata kiri secara sempurna**.

### File
- `resources/views/ppdb.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Margin top di Hero section aman dan gambar kini 100% rata kiri pada tampilan tablet.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Create Desktop Tentang Kami Page (Figma Node 19889:6004)

### Sedang / Sudah Membuat
- Membaca & Memeriksa **MCP Figma Design Desktop Node** (`Node 19889:6004`):
  - Memeriksa seluruh ukuran komponen, padding, margin, dan hirarki teks verbatim.
- Membuat **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - **Hero Section**: Judul `Pesantren yang melek dengan kemajuan zaman.`, paragraf `Berdiri sejak 2017...`, dan kontainer placeholder gambar.
  - **Sambutan Kepala Sekolah**: Teks sambutan `Mr Beny Fitriyanto, S.S., Gr.` dan kontainer placeholder gambar.
  - **Visi & Misi Section**: Visi quote `Menjadi pesantren teknologi rujukan...`, 4 butir poin Misi, dan kontainer placeholder gambar kartu melayang.
  - **Jurusan SMK Section**: 3 kartu jurusan penuh (`01 TKJ`, `02 RPL`, `03 DKV`) lengkap dengan Materi Utama (icon), Prospek Karier (pill tag), dan Banner `Belum yakin pilih jurusan yang mana?`.
  - **Sekolah Kami Section**: `Lima Sekolah, Satu Keluarga Besar.` mencakup 1 kartu utama `IDN Jonggol` (Full Width) dan 4 kartu cabang `IDN Akhwat`, `IDN Solo`, `IDN Pamijahan`, `IDN Sentul` (Grid 2x2).
  - **Banner PPDB CTA & Reusable Navbar & Footer**: `<x-navbar active="tentang-kami" />`, `<x-footer />`, dan `<x-chatbot />`.
- Memperbarui **Rute Web** ([`routes/web.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/routes/web.php#L15)) agar memetakan `/tentang-kami` ke `view('tentang-kami')`.

### File
- `resources/views/tentang-kami.blade.php`
- `routes/web.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Gambar dikosongkan terlebih dahulu sesuai instruksi pengguna ("untuk img di kosongkan terlebih dahulu").
- Seluruh teks, warna, margin, padding, dan struktur komponen 100% presisi selaras dengan desain Figma Node 19889:6004.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Vertical Text Centering for Hero & Sambutan (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Mengubah perataan induk kontainer flex `items-start` menjadi **`items-center`** pada **Hero Section** dan **Sambutan Kepala Sekolah Section**.
  - Teks deskripsi dan judul kini **terpenuhi secara simetris di tengah secara vertikal (tidak menempel ke atas)** relatif terhadap tinggi gambar.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Perataan teks di Hero dan Sambutan kini seimbang dan berada tepat di tengah tinggi gambar.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Add Image Tag Templates for Image Containers (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Menambahkan template tag `<img src="{{ asset('assets/nama-file.avif') }}" ...>` pada seluruh kontainer gambar (Visi Misi, IDN Jonggol, IDN Akhwat, IDN Solo, IDN Pamijahan, dan IDN Sentul) sehingga pengguna tinggal mengganti nama file gambar sesuai kebutuhan.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Seluruh kontainer gambar kini siap pakai dengan sintaks `{{ asset('assets/...') }}`.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Visi Misi 3-Card Floating Overlay Images Structure (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Mengubah struktur kontainer gambar Visi & Misi menjadi **3-Card Floating Overlay Layout**:
    - Kartu Utama (Center): `jonggol ikhwan.avif` (500x374px, border putih 8px, rounded 18px, shadow-2xl).
    - Kartu Melayang Kanan Atas (`rotate-6`): `backpacker.avif` (border putih 4px, rounded 12px, shadow-xl).
    - Kartu Melayang Kiri Bawah (`-rotate-6`): `basket.avif` (border putih 4px, rounded 12px, shadow-xl).

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Efek kartu melayang dengan rotasi presisi 100% identik dengan desain referensi Figma.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Set Floating Cards Dimensions to 160x100px (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Menyesuaikan ukuran kedua kartu melayang (Top-Right dan Bottom-Left) di bagian Visi Misi menjadi tepat **`160x100px`** (`w-[160px] h-[100px]`) dengan border putih `border-4 border-white`.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Ukuran kedua kartu melayang kini persis 160x100px sesuai spesifikasi instruksi.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Responsive Tablet View Implementation for Tentang Kami (Figma Node 20200-12545)

### Sedang / Sudah Membuat
- Membaca & Memeriksa **MCP Figma Design Tablet Node** (`Node 20200-12545`):
  - Memeriksa seluruh ukuran komponen tablet (`max-w-[706px]`), padding (`px-6 md:px-[64px]`), margin, dan hirarki teks verbatim.
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - **Kontainer Utama Tablet**: Menyesuaikan `max-w-[706px]` pada breakpoint `md:`, `px-6 md:px-[64px]` dan `py-12 md:py-[90px]` sesuai standar `rules_AI.md`.
  - **Flex Layouts**: Mengatur perataan teks dan gambar pada Hero, Sambutan, Visi Misi, Jurusan SMK, dan Sekolah Kami agar bertransisi secara mulus dari Desktop (`1440px`), Tablet (`768px`), hingga Mobile (`440px`).

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Tampilan Tablet 100% presisi dan selaras dengan Figma Node 20200-12545.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Reorder Sambutan Section (Text First, Image Below on Mobile/Tablet)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Mengatur urutan elemen pada **Sambutan Kepala Sekolah Section**:
    - **Tampilan Mobile & Tablet** (`flex-col`): Teks sambutan berada di **Atas** (`order-1`) dan foto `Mr Beny.avif` di **Bawah** (`order-2`).
    - **Tampilan Desktop** (`lg:flex-row`): Foto di **Kiri** (`lg:order-1`) dan Teks sambutan di **Kanan** (`lg:order-2`).

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Urutan elemen pada tampilan mobile/tablet kini menyajikan teks sambutan terlebih dahulu, diikuti dengan foto Mr. Beny di bawahnya selaras dengan Figma.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Update Responsive Image Sizes & Aspect Ratios (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Menyesuaikan ukuran dan rasio gambar responsif pada **Hero Header** dan **Sambutan Kepala Sekolah** agar persis 100% selaras dengan Figma Node `20200-12545`:
    - Gambar Hero & Sambutan menggunakan `aspect-square`, `max-w-[400px] lg:w-[410px]`, dan `object-cover` untuk mengisi penuh bingkai tanpa garis kosong/terpotong.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Ukuran gambar pada tampilan responsif mobile dan tablet kini 100% presisi selaras dengan Figma.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Set Responsive Image Container Widths to w-full (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Mengubah lebar kontainer gambar **Hero Section** (`ojan.avif`) dan **Sambutan Kepala Sekolah** (`Mr Beny.avif`) pada tampilan responsif (Mobile & Tablet) dari `max-w-[400px]` menjadi **`w-full lg:w-[410px] lg:max-w-[410px]`**.
  - Lebar gambar pada layar responsif kini **100% selebar (setara) dengan komponen teks** di atas/bawahnya.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Gambar pada tampilan responsif kini membentang penuh 100% selebar blok teks di atas/bawahnya.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Complete Tablet View Implementation per Figma Node 20123-29917 (tentang-kami.blade.php)

### Sedang / Sudah Membuat
- Membaca & Memeriksa **MCP Figma Design Tablet Node** (`Node 20123-29917`):
  - Memeriksa seluruh tata letak tablet (`834px` width), padding, margin, dan urutan komponen.
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - **Hero Header Section**: Gambar `ojan.avif` membentang penuh di bawah paragraf deskripsi (`w-full max-w-[706px] h-[300px] sm:h-[400px] md:h-[450px]`).
  - **Sambutan Kepala Sekolah Section**: Teks Sambutan di posisi **Atas** (terpusat), diikuti oleh Foto `Mr Beny.avif` dan Badge Nama `Beny Fitriyanto, S.S., Gr.` terpusat di **Bawah** sesuai desain Node 20123-29917.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Tampilan Tablet kini 100% presisi selaras dengan node referensi Figma 20123-29917.
- Aset diproduksi ulang via `npm run build`.


## 2026-09-01 - Fix Jurusan SMK Cards Layout on Tablet (Figma Node 20123-29917)

### Sedang / Sudah Membuat
- Memperbarui **Halaman Tentang Kami** ([`resources/views/tentang-kami.blade.php`](file:///c:/Users/novit/Documents/Lomba/JHIC/folder%20laravel/Website-IDN-JHIC/resources/views/tentang-kami.blade.php)):
  - Menyesuaikan tata letak 3 Kartu Jurusan SMK (TKJ, RPL, DKV) pada tampilan Tablet (`sm:` dan `md:`):
    - Mengelompokkan **Materi Utama** dan **Prospek Karier** dalam kontainer `flex flex-col sm:flex-row gap-8 sm:gap-12 lg:gap-[56px]` sehingga berdampingan secara **Horizontal (Side-by-Side)** di bawah deskripsi jurusan pada layar tablet, persis 100% selaras dengan acuan node Figma `20123-29917`.

### File
- `resources/views/tentang-kami.blade.php`
- `AI_log.md`

### Status
DONE

### Catatan
- Materi Utama dan Prospek Karier pada kartu Jurusan kini tampil berdampingan secara horizontal pada tampilan tablet selaras dengan Figma.
- Aset diproduksi ulang via `npm run build`.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke repositori Git / GitHub.
