<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => 'IDN Relawan dan Markaz Bersama As-Sunnah Salurkan Bantuan Bencana Banjir di Bali',
            'slug' => 'idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali',
            'image' => 'main_bali.png',
            'category' => 'Event',
            'read_time' => '5 menit',
            'published_at' => '2025-09-18',
            'content' => "<p>Bali selalu memberikan info menarik tentang destinasi wisata alamnya yang beragam. Namun kabar kali ini datang cukup memprihatinkan setelah Bali diguyur hujan deras berkepanjangan pada pertengahan bulan September 2025. Alhasil banjir besar dan longsor tidak terelakkan. Kabarnya pada banjir besar ini turut jatuh korban jiwa dan mengisolasi para warga serta menyebabkan berbagai kerusakan.</p>

<p>Banjir besar yang melanda sejumlah kawasan di Denpasar, Bali, mengundang kepedulian banyak pihak. Salah satunya datang dari Markaz Bersama As-Sunnah (MBA) bersama lembaga-lembaga yang tergabung di dalamnya. Diwakilkan oleh tim Potensi Lokal Bali Mengaji, aksi tanggap bencana dilakukan selama tiga hari, 14–16 September 2025. Bantuan-bantuan dari 29 lembaga yang berkolaborasi dengan MBA, termasuk IDN Relawan, disalurkan kepada masyarakat.</p>

<p>Dalam pantauan di lokasi, tim relawan melakukan pembersihan puing rumah warga yang rusak diterjang banjir. Aksi land clearing ini menyasar jalan pemukiman, halaman rumah, dan area publik agar akses warga kembali normal. Sampah dan material yang menumpuk dipindahkan ke lokasi pembuangan yang lebih aman.</p>

<p>Tak hanya fokus pada pembersihan, tim relawan juga mendistribusikan bantuan kebutuhan mendesak. Selama tiga hari giat, sebanyak 1.260 porsi makanan siap saji disalurkan kepada korban banjir. Anak-anak sekolah yang kehilangan buku dan perlengkapan belajar juga menerima 50 paket alat tulis untuk mendukung kelanjutan aktivitas belajar mereka.</p>

<p>Dalam rilis resminya, pihak Markaz Bersama Assunnah menyampaikan terima kasih kepada seluruh lembaga yang telah berkolaborasi. “Jazakumullahu khairan wa barakallahu fiikum kepada semua pihak yang mendukung program Tanggap Bencana Banjir Denpasar Bali 2025. Semoga apa yang para lembaga berikan bermanfaat bagi mereka dan mendapatkan ganjaran dari Allah Subhaanahu wa Ta`ala,” ujar Kang Badi, salah satu relawan MBA.</p>

<p>Aksi selama tiga hari ini menjadi bukti bahwa kolaborasi dan solidaritas komunitas muslim Bali dari lintas lembaga mampu menghadirkan dampak nyata bagi masyarakat terdampak bencana. Semoga kawasan Denpasar Bali segera pulih dan setiap warga dapat beraktivitas kembali seperti biasanya.</p>

<p>IDN Relawan merupakan salah satu unit dari Yayasan IDN yang bergerak di bidang sosial. Di sisi lain IDN Boarding School juga turut aktif membentuk siswa-siswanya memiliki jiwa sosial dan kepedulian yang tinggi. Simak pada artikel berikut: <a href=\"https://idn.sch.id/aksi-sosial-siswa-sekolah-it-ditantang-terjun-membantu-pekerjaan-masyarakat-sekitar/\" target=\"_blank\">Aksi Sosial Siswa IDN Boarding School Ditantang Terjun Membantu Pekerjaan Masyarakat Solo</a>.</p>"
        ]);

        Article::create([
            'title' => 'Tim Basket SMP IDN Juara 1 JABODETABEK di Hexagon Fest An Nahl Ciangsana',
            'slug' => 'tim-basket-smp-idn-juara-1-jabodetabek-di-hexagon-fest-an-nahl-ciangsana',
            'image' => 'rel_basket.png',
            'category' => 'Prestasi',
            'read_time' => '3 menit',
            'published_at' => '2025-10-02',
            'content' => '<p>Tim Basket SMP IDN kembali menorehkan prestasi gemilang dengan meraih Juara 1 dalam turnamen basket tingkat JABODETABEK di ajang Hexagon Fest yang diselenggarakan oleh Sekolah An Nahl Ciangsana. Kemenangan ini diraih berkat kerja keras tim dan bimbingan pelatih yang intensif.</p>'
        ]);

        Article::create([
            'title' => 'Deklarasi Anti-Bullying dan Stop Kekerasan IDN Boarding School.',
            'slug' => 'deklarasi-anti-bullying-dan-stop-kekerasan-idn-boarding-school',
            'image' => 'rel_bullying.png',
            'category' => 'Prestasi',
            'read_time' => '4 menit',
            'published_at' => '2025-09-30',
            'content' => '<p>Dalam upaya menciptakan lingkungan belajar yang aman, nyaman, dan bebas dari segala bentuk intimidasi, IDN Boarding School secara resmi menggelar Deklarasi Anti-Bullying dan Stop Kekerasan. Seluruh guru, staf, dan siswa menandatangani komitmen bersama untuk saling menghargai.</p>'
        ]);

        Article::create([
            'title' => 'Juara 1 Lomba Jenius Medlab 2025',
            'slug' => 'juara-1-lomba-jenius-medlab-2025',
            'image' => 'rel_medlab.png',
            'category' => 'Prestasi',
            'read_time' => '2 menit',
            'published_at' => '2025-08-11',
            'content' => '<p>Siswa IDN Boarding School berhasil menyabet gelar Juara 1 pada ajang Lomba Jenius Medlab 2025. Kompetisi bergengsi ini menguji kemampuan siswa dalam bidang teknologi laboratorium medis dan pengembangan inovasi kesehatan berbasis IT.</p>'
        ]);
    }
}
