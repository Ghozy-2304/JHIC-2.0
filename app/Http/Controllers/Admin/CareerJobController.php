<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CareerJobController extends Controller
{
    /**
     * Tampilkan daftar seluruh lowongan pekerjaan & magang.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $major = $request->query('major');
        $status = $request->query('status');

        $query = CareerJob::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($major && $major !== 'Semua') {
            $query->where('major', $major);
        }

        if ($status !== null && $status !== '') {
            if ($status === 'expired') {
                $query->whereNotNull('expires_at')->where('expires_at', '<=', now());
            } elseif ($status === '1') {
                $query->active();
            } elseif ($status === '0') {
                $query->where('is_active', false);
            }
        }

        $jobs = $query->orderBy('is_active', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        $majors = ['RPL', 'TKJ', 'DKV'];

        // Quick metrics for dashboard cards
        $totalCount = CareerJob::count();
        $activeCount = CareerJob::active()->count();
        $internCount = CareerJob::where('work_type', 'Internship')->count();
        $expiredCount = CareerJob::whereNotNull('expires_at')->where('expires_at', '<=', now())->count();

        return view('admin.career.index', compact(
            'jobs',
            'search',
            'major',
            'status',
            'majors',
            'totalCount',
            'activeCount',
            'internCount',
            'expiredCount'
        ));
    }

    /**
     * Tampilkan form penambahan lowongan kerja baru.
     */
    public function create()
    {
        return view('admin.career.create');
    }

    /**
     * Otomatis tarik metadata OpenGraph dari URL lowongan (Glints, Jobstreet, LinkedIn, dll).
     */
    public function fetchMeta(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = trim($request->input('url'));
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        // 1. Deteksi platform sumber
        $sourcePlatform = 'Website Resmi Perusahaan';
        if (str_contains($host, 'glints.com')) {
            $sourcePlatform = 'Glints';
        } elseif (str_contains($host, 'jobstreet.co.id') || str_contains($host, 'jobstreet.com') || str_contains($host, 'seek.com')) {
            $sourcePlatform = 'Jobstreet';
        } elseif (str_contains($host, 'linkedin.com')) {
            $sourcePlatform = 'LinkedIn';
        } elseif (str_contains($host, 'kalibrr.com')) {
            $sourcePlatform = 'Kalibrr';
        } elseif (str_contains($host, 'kitalulus.com')) {
            $sourcePlatform = 'KitaLulus';
        } elseif (str_contains($host, 'dealls.com')) {
            $sourcePlatform = 'Dealls';
        } elseif (str_contains($host, 'idn.sch.id')) {
            $sourcePlatform = 'Mitra Resmi IDN';
        }

        $title = '';
        $companyName = '';
        $description = '';
        $location = 'Jakarta, Indonesia';
        $locationGroup = 'Jabodetabek';
        $major = 'RPL';
        $workType = 'Full-time';
        $workLocation = 'Onsite';

        try {
            $response = Http::timeout(6)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                ])
                ->get($url);

            if ($response->successful()) {
                $html = $response->body();

                // Parse OpenGraph / Meta tags
                preg_match('/<meta[^>]+property=["\']og:title["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogTitle);
                preg_match('/<meta[^>]+property=["\']og:description["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogDesc);
                preg_match('/<meta[^>]+property=["\']og:site_name["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogSite);
                preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $rawTitle);

                $extractedTitle = !empty($ogTitle[1]) ? html_entity_decode($ogTitle[1], ENT_QUOTES) : (!empty($rawTitle[1]) ? html_entity_decode($rawTitle[1], ENT_QUOTES) : '');
                $extractedDesc = !empty($ogDesc[1]) ? html_entity_decode($ogDesc[1], ENT_QUOTES) : '';
                $extractedSite = !empty($ogSite[1]) ? html_entity_decode($ogSite[1], ENT_QUOTES) : '';

                $description = Str::limit(strip_tags($extractedDesc), 300);

                // Smart extraction of Title & Company Name
                if ($extractedTitle) {
                    // Patterns like "Frontend Developer at PT Maju Terus | Glints"
                    // or "Lowongan Frontend Developer di PT Maju Terus"
                    $cleanTitle = preg_replace('/(\||-|–)\s*(Glints|Jobstreet|LinkedIn|Kalibrr|KitaLulus|Dealls).*/i', '', $extractedTitle);

                    if (preg_match('/^(.*?)\s+(?:at|di|pada|@)\s+(.*)$/i', $cleanTitle, $matches)) {
                        $title = trim($matches[1]);
                        $companyName = trim($matches[2]);
                    } elseif (preg_match('/^(.*?)\s+(?:-|–|\|)\s+(.*)$/i', $cleanTitle, $matches)) {
                        $title = trim($matches[1]);
                        $companyName = trim($matches[2]);
                    } else {
                        $title = trim($cleanTitle);
                        $companyName = $extractedSite ?: 'Mitra Industri';
                    }
                }

                // Smart Guess: Jurusan IDN
                $fullText = strtolower($title . ' ' . $description);
                if (preg_match('/(network|jaringan|sysadmin|devops|cloud|cisco|mikrotik|server|it support|cyber|security|infrastruktur)/i', $fullText)) {
                    $major = 'TKJ';
                } elseif (preg_match('/(design|designer|ui|ux|graphic|grafis|video|animator|illustrat|motion|creative|figma)/i', $fullText)) {
                    $major = 'DKV';
                } else {
                    $major = 'RPL';
                }

                // Smart Guess: Tipe Kerja
                if (preg_match('/(intern|magang|internship)/i', $fullText)) {
                    $workType = 'Internship';
                } elseif (preg_match('/(contract|kontrak)/i', $fullText)) {
                    $workType = 'Contract';
                } elseif (preg_match('/(part time|paruh waktu)/i', $fullText)) {
                    $workType = 'Part-time';
                } elseif (preg_match('/(freelance|lepas)/i', $fullText)) {
                    $workType = 'Freelance';
                }

                // Smart Guess: Lokasi & Mode Kerja
                if (preg_match('/(remote|wfh|jarak jauh)/i', $fullText)) {
                    $workLocation = 'Remote/WFH';
                } elseif (preg_match('/(hybrid)/i', $fullText)) {
                    $workLocation = 'Hybrid';
                }

                // Smart Guess: Wilayah Group
                if (preg_match('/(jakarta|bogor|depok|tangerang|bekasi)/i', $fullText)) {
                    $locationGroup = 'Jabodetabek';
                    $location = 'Jabodetabek, Indonesia';
                } elseif (preg_match('/(bandung|surabaya|semarang|yogyakarta|jogja|solo|malang)/i', $fullText)) {
                    $locationGroup = 'Jawa';
                    $location = 'Jawa Barat / Jawa Tengah / Jawa Timur';
                }
            }
        } catch (\Throwable $e) {
            // Silently fallback to partial detection
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $title ?: 'Posisi Pekerjaan',
                'company_name' => $companyName ?: 'Perusahaan Mitra',
                'source_platform' => $sourcePlatform,
                'major' => $major,
                'work_type' => $workType,
                'work_location' => $workLocation,
                'location' => $location,
                'location_group' => $locationGroup,
                'requirements' => $description,
                'apply_url' => $url,
            ],
        ]);
    }

    /**
     * Simpan lowongan kerja baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'major' => 'required|string|in:RPL,TKJ,DKV',
            'company_name' => 'required|string|max:255',
            'salary' => 'nullable|string|max:100',
            'work_location' => 'required|string|in:Onsite,Hybrid,Remote/WFH',
            'work_type' => 'required|string|in:Full-time,Part-time,Contract,Internship,Freelance',
            'location' => 'required|string|max:255',
            'location_group' => 'required|string|in:Jabodetabek,Jawa,Kalimantan,Sumatra,Sulawesi,Papua,Other',
            'posted_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'apply_url' => 'nullable|url|max:500',
            'source_platform' => 'nullable|string|max:60',
            'requirements' => 'nullable|string|max:3000',
            'company_logo_char' => 'nullable|string|max:2',
            'company_img' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'title.required' => 'Posisi pekerjaan wajib diisi.',
            'major.required' => 'Pilih jurusan yang sesuai.',
            'company_name.required' => 'Nama perusahaan / mitra industri wajib diisi.',
            'location.required' => 'Lokasi penempatan wajib diisi.',
            'company_img.image' => 'Logo perusahaan harus berupa file gambar.',
        ]);

        $logoPath = null;
        if ($request->hasFile('company_img')) {
            $file = $request->file('company_img');
            $uploadDir = public_path('assets/uploads/partners');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }
            $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $logoPath = 'assets/uploads/partners/' . $fileName;
        }

        $logoChar = $validated['company_logo_char'] ?? strtoupper(substr($validated['company_name'], 0, 1));

        $postedAt = !empty($validated['posted_at']) ? Carbon::parse($validated['posted_at']) : Carbon::now();
        $expiresAt = !empty($validated['expires_at']) ? Carbon::parse($validated['expires_at']) : null;

        // Auto detect source platform if empty
        $sourcePlatform = $validated['source_platform'] ?? null;
        if (!$sourcePlatform && !empty($validated['apply_url'])) {
            $host = strtolower(parse_url($validated['apply_url'], PHP_URL_HOST) ?? '');
            if (str_contains($host, 'glints')) $sourcePlatform = 'Glints';
            elseif (str_contains($host, 'jobstreet') || str_contains($host, 'seek')) $sourcePlatform = 'Jobstreet';
            elseif (str_contains($host, 'linkedin')) $sourcePlatform = 'LinkedIn';
            elseif (str_contains($host, 'kalibrr')) $sourcePlatform = 'Kalibrr';
            elseif (str_contains($host, 'kitalulus')) $sourcePlatform = 'KitaLulus';
            else $sourcePlatform = 'Website Resmi Perusahaan';
        }

        CareerJob::create([
            'title' => $validated['title'],
            'major' => $validated['major'],
            'company_name' => $validated['company_name'],
            'salary' => $validated['salary'] ?: 'Kompetitif',
            'work_location' => $validated['work_location'],
            'work_type' => $validated['work_type'],
            'location' => $validated['location'],
            'location_group' => $validated['location_group'],
            'posted_at' => $postedAt,
            'expires_at' => $expiresAt,
            'posted_time' => 'Baru saja',
            'post_time_category' => 'Hari ini',
            'apply_url' => $validated['apply_url'] ?? null,
            'source_platform' => $sourcePlatform ?: 'Mitra Resmi IDN',
            'requirements' => $validated['requirements'] ?? null,
            'company_logo_char' => $logoChar,
            'company_img' => $logoPath,
            'company_bg' => 'bg-[#0c61cf]',
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.career.index')
            ->with('success', 'Lowongan pekerjaan baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan formulir edit lowongan.
     */
    public function edit(CareerJob $career)
    {
        return view('admin.career.edit', compact('career'));
    }

    /**
     * Perbarui data lowongan.
     */
    public function update(Request $request, CareerJob $career)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'major' => 'required|string|in:RPL,TKJ,DKV',
            'company_name' => 'required|string|max:255',
            'salary' => 'nullable|string|max:100',
            'work_location' => 'required|string|in:Onsite,Hybrid,Remote/WFH',
            'work_type' => 'required|string|in:Full-time,Part-time,Contract,Internship,Freelance',
            'location' => 'required|string|max:255',
            'location_group' => 'required|string|in:Jabodetabek,Jawa,Kalimantan,Sumatra,Sulawesi,Papua,Other',
            'posted_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'apply_url' => 'nullable|url|max:500',
            'source_platform' => 'nullable|string|max:60',
            'requirements' => 'nullable|string|max:3000',
            'company_logo_char' => 'nullable|string|max:2',
            'company_img' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('company_img')) {
            $file = $request->file('company_img');
            $uploadDir = public_path('assets/uploads/partners');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }
            $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $career->company_img = 'assets/uploads/partners/' . $fileName;
        }

        $career->title = $validated['title'];
        $career->major = $validated['major'];
        $career->company_name = $validated['company_name'];
        $career->salary = $validated['salary'] ?: 'Kompetitif';
        $career->work_location = $validated['work_location'];
        $career->work_type = $validated['work_type'];
        $career->location = $validated['location'];
        $career->location_group = $validated['location_group'];
        $career->apply_url = $validated['apply_url'] ?? null;
        $career->source_platform = !empty($validated['source_platform']) ? $validated['source_platform'] : ($career->source_platform ?: 'Mitra Resmi IDN');
        $career->requirements = $validated['requirements'] ?? $career->requirements;

        if (!empty($validated['posted_at'])) {
            $career->posted_at = Carbon::parse($validated['posted_at']);
        }
        $career->expires_at = !empty($validated['expires_at']) ? Carbon::parse($validated['expires_at']) : null;

        if (!empty($validated['company_logo_char'])) {
            $career->company_logo_char = $validated['company_logo_char'];
        }
        $career->is_active = $request->boolean('is_active');
        $career->save();

        return redirect()->route('admin.career.index')
            ->with('success', 'Data lowongan berhasil diperbarui!');
    }

    /**
     * Duplikat data lowongan pekerjaan dalam 1-klik.
     */
    public function duplicate(CareerJob $career)
    {
        $clone = $career->replicate([
            'created_at',
            'updated_at',
        ]);

        $clone->title = $career->title . ' (Salinan)';
        $clone->posted_at = Carbon::now();
        $clone->is_active = false; // default draft
        $clone->save();

        return redirect()->route('admin.career.edit', $clone->id)
            ->with('success', "Lowongan berhasil diduplikat sebagai draf. Silakan lakukan penyesuaian.");
    }

    /**
     * Hapus lowongan dari database.
     */
    public function destroy(CareerJob $career)
    {
        $career->delete();

        return redirect()->route('admin.career.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }

    /**
     * Toggle status aktif / tutup lowongan secara cepat.
     */
    public function toggle(CareerJob $career)
    {
        $career->is_active = !$career->is_active;
        $career->save();

        $statusText = $career->is_active ? 'diaktifkan kembali' : 'ditutup';
        return back()->with('success', "Lowongan “{$career->title}” berhasil {$statusText}.");
    }
}
