<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\CareerJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllPagesCoverageTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Article $sampleArticle;
    private CareerJob $sampleJob;

    protected function setUp(): void
    {
        parent::setUp();

        // Fake external HTTP services
        \Illuminate\Support\Facades\Http::fake([
            'fast-api-g0de.onrender.com/*' => \Illuminate\Support\Facades\Http::response([
                'conversation_id' => 'test-conv-123',
                'reply' => 'Halo! Ada yang bisa kami bantu seputar SMK IDN Boarding School?'
            ], 200),
        ]);

        // Create Admin
        $this->admin = User::factory()->create([
            'name' => 'Super Admin IDN',
            'email' => 'admin@idn.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
        ]);

        // Create sample data for detail pages
        $this->sampleArticle = Article::create([
            'title' => 'Prestasi Santri IDN di Ajang Internasional 2026',
            'slug' => 'prestasi-santri-idn-di-ajang-internasional-2026',
            'category' => 'Prestasi',
            'read_time' => '4 Menit Baca',
            'published_at' => '2026-09-25',
            'content' => '<p>Santri IDN meraih medali emas internasional.</p>',
            'author' => 'Tim Media IDN',
            'image' => 'assets/img/article-sample.jpg',
        ]);

        $this->sampleJob = CareerJob::create([
            'title' => 'Full Stack Developer',
            'major' => 'RPL',
            'company_name' => 'PT Datacaraka Solusindo',
            'salary' => 'Rp 8.000.000',
            'work_location' => 'Onsite',
            'work_type' => 'Full-time',
            'location' => 'Jakarta, Indonesia',
            'location_group' => 'Jabodetabek',
            'is_active' => true,
        ]);
    }

    /**
     * Uji 1: Seluruh Halaman Publik Publikasi (Front-End Pages)
     */
    public function test_all_public_frontend_pages_render_successfully(): void
    {
        $publicPages = [
            '/' => 'SMK IDN Boarding School',
            '/tentang-kami' => 'Tentang Kami',
            '/program/rpl' => 'Software',
            '/program/tkj' => 'Network',
            '/program/dkv' => 'Design',
            '/ppdb' => 'Pendaftaran',
            '/career-center' => 'Career Center',
            '/artikel' => 'Artikel',
            '/artikel/' . $this->sampleArticle->slug => $this->sampleArticle->title,
            '/kontak' => 'Kontak',
            '/sitemap.xml' => 'urlset',
        ];

        foreach ($publicPages as $path => $expectedText) {
            $response = $this->get($path);
            $response->assertStatus(200);
            if ($expectedText) {
                $response->assertSee($expectedText);
            }
        }
    }

    /**
     * Uji 2: Pengalihan Akses Tamu pada Halaman Terproteksi Admin
     */
    public function test_guest_is_redirected_to_login_for_all_admin_routes(): void
    {
        $adminProtectedRoutes = [
            '/admin',
            '/admin/dashboard',
            '/admin/articles',
            '/admin/articles/create',
            '/admin/articles/' . $this->sampleArticle->id . '/edit',
            '/admin/career',
            '/admin/career/create',
            '/admin/career/' . $this->sampleJob->id . '/edit',
        ];

        foreach ($adminProtectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(302);
            $response->assertRedirect(route('admin.login'));
        }
    }

    /**
     * Uji 3: Login Form Admin & Proses Otentikasi
     */
    public function test_admin_login_form_and_authentication(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);

        $loginResponse = $this->post('/admin/login', [
            'email' => 'admin@idn.sch.id',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(302);
        $loginResponse->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * Uji 4: Seluruh Halaman Panel Admin saat Terotentikasi (Super Admin)
     */
    public function test_all_admin_panel_pages_render_successfully_for_authenticated_admin(): void
    {
        $adminPages = [
            '/admin/dashboard' => 'Dashboard',
            '/admin/articles' => 'Artikel',
            '/admin/articles/create' => 'Tambah Artikel',
            '/admin/articles/' . $this->sampleArticle->id . '/edit' => 'Edit Artikel',
            '/admin/career' => 'Lowongan',
            '/admin/career/create' => 'Tambah Lowongan',
            '/admin/career/' . $this->sampleJob->id . '/edit' => 'Edit Lowongan',
        ];

        foreach ($adminPages as $path => $expectedText) {
            $response = $this->actingAs($this->admin)->get($path);
            $response->assertStatus(200);
            if ($expectedText) {
                $response->assertSee($expectedText);
            }
        }
    }

    /**
     * Uji 5: API Endpoints (Chatbot & Metadata Auto-Fetch)
     */
    public function test_api_endpoints_work_properly(): void
    {
        // Chatbot conversation initiation
        $convResponse = $this->postJson('/api/chatbot/conversations');
        $convResponse->assertStatus(200);

        // Auto fetch metadata
        $metaResponse = $this->actingAs($this->admin)->postJson('/admin/career/fetch-meta', [
            'url' => 'https://id.jobstreet.com/id/job/94690324'
        ]);
        $metaResponse->assertStatus(200);
        $metaResponse->assertJson(['success' => true]);
    }
}
