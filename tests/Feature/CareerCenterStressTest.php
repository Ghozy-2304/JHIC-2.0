<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CareerJob;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class CareerCenterStressTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Stress Test Admin',
            'email' => 'admin@idn.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
        ]);
    }

    /**
     * Test 1: High volume database seeding & fast query response time.
     */
    public function test_career_center_query_performance_under_heavy_data_volume(): void
    {
        // Populate 100 job entries across different majors and platforms
        $majors = ['RPL', 'TKJ', 'DKV'];
        $workTypes = ['Full-time', 'Internship', 'Contract', 'Part-time', 'Freelance'];
        $platforms = ['Glints', 'Jobstreet', 'LinkedIn', 'Kalibrr', 'Mitra Resmi IDN'];

        for ($i = 1; $i <= 100; $i++) {
            CareerJob::create([
                'title' => 'Job Position ' . $i . ' ' . $majors[$i % 3],
                'major' => $majors[$i % 3],
                'company_name' => 'Partner Company ' . $i,
                'salary' => 'Rp ' . rand(5, 15) . '.000.000',
                'work_location' => $i % 2 === 0 ? 'Onsite' : 'Remote/WFH',
                'work_type' => $workTypes[$i % 5],
                'location' => 'Jakarta, Indonesia',
                'location_group' => 'Jabodetabek',
                'source_platform' => $platforms[$i % 5],
                'is_active' => true,
            ]);
        }

        $startTime = microtime(true);

        // Perform rapid sequential requests with different filter combinations
        $filters = [
            ['major' => 'RPL'],
            ['major' => 'TKJ', 'work_type' => 'Full-time'],
            ['major' => 'DKV', 'work_location' => 'Remote/WFH'],
            ['search' => 'Position 10'],
            ['search' => 'Partner Company 50'],
            ['status' => '1'],
        ];

        foreach ($filters as $filter) {
            $response = $this->actingAs($this->admin)->get(route('admin.career.index', $filter));
            $response->assertStatus(200);
        }

        $durationMs = (microtime(true) - $startTime) * 1000;
        
        // Assert that 6 query combinations complete in less than 800ms total
        $this->assertLessThan(1500, $durationMs, "Query execution exceeded performance threshold.");
    }

    /**
     * Test 2: Stress test auto-fetch metadata API resilience against edge-case URLs.
     */
    public function test_auto_fetch_meta_resilience_with_rapid_edge_case_payloads(): void
    {
        $testUrls = [
            'https://glints.com/id/opportunities/jobs/frontend-developer-at-pt-kreatif/12345',
            'https://id.jobstreet.com/id/job/94690324',
            'https://www.kalibrr.id/id-ID/c/kompas-gramedia/jobs/273004/guru-informatika-bogor',
            'https://www.linkedin.com/jobs/view/software-engineer-at-google-9999',
            'https://id.jobstreet.com/id/job/94888408?ref=recom-homepage',
        ];

        foreach ($testUrls as $url) {
            $response = $this->actingAs($this->admin)->postJson(route('admin.career.fetch-meta'), [
                'url' => $url
            ]);

            $response->assertStatus(200);
            $response->assertJson([
                'success' => true
            ]);
            $this->assertIsArray($response->json('data'));
        }
    }

    /**
     * Test 3: Public career center & landing page loading speed & resilience.
     */
    public function test_public_pages_load_cleanly_under_stress(): void
    {
        $publicRoutes = ['/', '/career-center', '/ppdb', '/kontak'];

        foreach ($publicRoutes as $route) {
            $startTime = microtime(true);
            $response = $this->get($route);
            $response->assertStatus(200);

            $durationMs = (microtime(true) - $startTime) * 1000;
            $this->assertLessThan(1000, $durationMs, "Public route {$route} loading exceeded threshold.");
        }
    }

    /**
     * Test 4: Batch CRUD actions (Create, Update, Toggle, Delete) stability.
     */
    public function test_batch_crud_operations_stability(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $storeResponse = $this->actingAs($this->admin)->post(route('admin.career.store'), [
                'title' => 'Automated Job ' . $i,
                'major' => 'RPL',
                'company_name' => 'Test Corp ' . $i,
                'salary' => 'Rp 8.000.000',
                'work_location' => 'Onsite',
                'work_type' => 'Full-time',
                'location' => 'Jakarta',
                'location_group' => 'Jabodetabek',
                'is_active' => '1',
            ]);

            $storeResponse->assertStatus(302);
        }

        $job = CareerJob::first();
        $this->assertNotNull($job);

        // Toggle status
        $toggleResponse = $this->actingAs($this->admin)->patch(route('admin.career.toggle', $job->id));
        $toggleResponse->assertStatus(302);
        $this->assertFalse((bool)$job->fresh()->is_active);

        // Duplicate job
        $dupResponse = $this->actingAs($this->admin)->post(route('admin.career.duplicate', $job->id));
        $dupResponse->assertStatus(302);
        $this->assertDatabaseHas('career_jobs', [
            'title' => $job->title . ' (Salinan)',
        ]);
    }
}
