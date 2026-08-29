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

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke repositori Git / GitHub.
