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
        $parsedUrl = parse_url($url);
        $host = strtolower($parsedUrl['host'] ?? '');
        $path = trim($parsedUrl['path'] ?? '', '/');
        $segments = explode('/', $path);

        // 1. Deteksi platform sumber
        $sourcePlatform = 'Website Resmi Perusahaan';
        if (str_contains($host, 'glints')) {
            $sourcePlatform = 'Glints';
        } elseif (str_contains($host, 'jobstreet') || str_contains($host, 'seek')) {
            $sourcePlatform = 'Jobstreet';
        } elseif (str_contains($host, 'linkedin')) {
            $sourcePlatform = 'LinkedIn';
        } elseif (str_contains($host, 'kalibrr')) {
            $sourcePlatform = 'Kalibrr';
        } elseif (str_contains($host, 'kitalulus')) {
            $sourcePlatform = 'KitaLulus';
        } elseif (str_contains($host, 'dealls')) {
            $sourcePlatform = 'Dealls';
        } elseif (str_contains($host, 'idn.sch.id')) {
            $sourcePlatform = 'Mitra Resmi IDN';
        }

        $title = '';
        $companyName = '';
        $companyLogoUrl = '';
        $salary = '';
        $description = '';
        $location = 'Jakarta, Indonesia';
        $locationGroup = 'Jabodetabek';
        $major = 'RPL';
        $workType = 'Full-time';
        $workLocation = 'Onsite';

        // 2. Parse URL Slug sebagai fallback utama (Pasti terisi bahkan jika di-block Firewall Cloudflare)
        if (str_contains($host, 'glints')) {
            foreach ($segments as $idx => $seg) {
                if ($seg === 'jobs' && isset($segments[$idx + 1])) {
                    $rawSlug = $segments[$idx + 1];
                    // Clean GUID if present
                    $rawSlug = preg_replace('/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', '', $rawSlug);
                    $rawSlug = trim($rawSlug, '-');
                    if (preg_match('/^(.*?)-(?:at|di)-(.*)$/i', $rawSlug, $m)) {
                        $title = ucwords(str_replace('-', ' ', $m[1]));
                        $companyName = ucwords(str_replace('-', ' ', $m[2]));
                    } else {
                        $title = ucwords(str_replace('-', ' ', $rawSlug));
                    }
                    break;
                }
            }
        } elseif (str_contains($host, 'jobstreet') || str_contains($host, 'seek')) {
            foreach ($segments as $idx => $seg) {
                if (($seg === 'job' || $seg === 'jobs') && isset($segments[$idx + 1])) {
                    $rawSlug = $segments[$idx + 1];
                    // Remove leading or trailing IDs
                    $rawSlug = preg_replace('/^\d+-/', '', $rawSlug);
                    $rawSlug = preg_replace('/-\d+$/', '', $rawSlug);
                    if (!preg_match('/^\d+$/', $rawSlug)) {
                        if (preg_match('/^(.*?)-(?:at|di)-(.*)$/i', $rawSlug, $m)) {
                            $title = ucwords(str_replace('-', ' ', $m[1]));
                            $companyName = ucwords(str_replace('-', ' ', $m[2]));
                        } else {
                            $title = ucwords(str_replace('-', ' ', $rawSlug));
                        }
                    }
                    break;
                }
            }
        } elseif (str_contains($host, 'linkedin')) {
            foreach ($segments as $idx => $seg) {
                if ($seg === 'view' && isset($segments[$idx + 1])) {
                    $rawSlug = preg_replace('/-\d+$/', '', $segments[$idx + 1]);
                    if (!preg_match('/^\d+$/', $rawSlug)) {
                        if (preg_match('/^(.*?)-(?:at|di)-(.*)$/i', $rawSlug, $m)) {
                            $title = ucwords(str_replace('-', ' ', $m[1]));
                            $companyName = ucwords(str_replace('-', ' ', $m[2]));
                        } else {
                            $title = ucwords(str_replace('-', ' ', $rawSlug));
                        }
                    }
                    break;
                }
            }
        } elseif (str_contains($host, 'kalibrr')) {
            foreach ($segments as $idx => $seg) {
                if ($seg === 'c' && isset($segments[$idx + 1])) {
                    $companyName = ucwords(str_replace('-', ' ', $segments[$idx + 1]));
                }
                if ($seg === 'jobs' && isset($segments[$idx + 2])) {
                    $title = ucwords(str_replace('-', ' ', $segments[$idx + 2]));
                } elseif ($seg === 'jobs' && isset($segments[$idx + 1]) && !is_numeric($segments[$idx + 1])) {
                    $title = ucwords(str_replace('-', ' ', $segments[$idx + 1]));
                }
            }
        }

        if (preg_match('/^\d+$/', trim($title))) {
            $title = '';
        }
        if (preg_match('/^\d+$/', trim($companyName))) {
            $companyName = '';
        }

        if (!$title && !empty($segments)) {
            $lastSeg = end($segments);
            $cleanSeg = preg_replace('/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|\d+$/i', '', $lastSeg);
            $cleanSeg = trim(str_replace(['-', '_'], ' ', $cleanSeg));
            if ($cleanSeg && strlen($cleanSeg) > 2 && !preg_match('/^\d+$/', $cleanSeg)) {
                $title = ucwords($cleanSeg);
            }
        }

        // 3. Tarik HTML dengan headers browser asli
        try {
            $response = Http::timeout(6)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                    'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                ])
                ->get($url);

            if ($response->successful() && !str_contains($response->body(), 'Firewall') && !str_contains($response->body(), 'Access Denied')) {
                $html = $response->body();

                // Check JSON-LD (JobPosting Schema)
                if (preg_match_all('/<script[^>]+type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $ldMatches)) {
                    foreach ($ldMatches[1] as $ldText) {
                        $ldJson = json_decode($ldText, true);
                        if (is_array($ldJson)) {
                            if (isset($ldJson['@type']) && $ldJson['@type'] === 'JobPosting') {
                                if (!empty($ldJson['title'])) $title = html_entity_decode($ldJson['title'], ENT_QUOTES);
                                if (!empty($ldJson['hiringOrganization']['name'])) $companyName = html_entity_decode($ldJson['hiringOrganization']['name'], ENT_QUOTES);
                                if (!empty($ldJson['description'])) $description = Str::limit(strip_tags($ldJson['description']), 2500);
                                if (!empty($ldJson['jobLocation']['address']['addressLocality'])) {
                                    $location = $ldJson['jobLocation']['address']['addressLocality'];
                                }
                                if (isset($ldJson['baseSalary'])) {
                                    if (is_string($ldJson['baseSalary'])) {
                                        $salary = $ldJson['baseSalary'];
                                    } elseif (is_array($ldJson['baseSalary'])) {
                                        $val = $ldJson['baseSalary']['value'] ?? $ldJson['baseSalary'];
                                        if (is_array($val)) {
                                            $min = $val['minValue'] ?? null;
                                            $max = $val['maxValue'] ?? null;
                                            $curr = $val['currency'] ?? 'IDR';
                                            if ($min && $max) {
                                                $salary = ($curr === 'IDR' ? 'Rp ' : $curr . ' ') . number_format($min) . ' - ' . number_format($max);
                                            } elseif ($min) {
                                                $salary = ($curr === 'IDR' ? 'Rp ' : $curr . ' ') . number_format($min);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Check SEEK / Jobstreet React Apollo State
                if (!$salary && preg_match('/"salary"\s*:\s*\{[^}]*"label"\s*:\s*"([^"]+)"/u', $html, $mSal)) {
                    $salText = str_replace(['\u00a0', "\xc2\xa0", "\u2013", "&ndash;"], [' ', ' ', '-', '-'], $mSal[1]);
                    $salText = html_entity_decode($salText, ENT_QUOTES, 'UTF-8');
                    $salary = trim($salText);
                }

                if ((!$companyName || str_contains(strtolower($companyName), 'jobstreet')) && preg_match('/"advertiser"\s*:\s*\{[^}]*"name"\s*:\s*"([^"]+)"/u', $html, $mAdv)) {
                    $compText = str_replace(['\u00a0', "\xc2\xa0"], ' ', $mAdv[1]);
                    $compText = html_entity_decode($compText, ENT_QUOTES, 'UTF-8');
                    if ($compText && !str_contains(strtolower($compText), 'jobstreet')) {
                        $companyName = trim($compText);
                    }
                }

                // Check OpenGraph / Meta HTML
                preg_match('/<meta[^>]+property=["\']og:title["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogTitle);
                preg_match('/<meta[^>]+property=["\']og:description["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogDesc);
                preg_match('/<meta[^>]+property=["\']og:site_name["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogSite);
                preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $rawTitle);

                $extractedTitle = !empty($ogTitle[1]) ? html_entity_decode($ogTitle[1], ENT_QUOTES) : (!empty($rawTitle[1]) ? html_entity_decode($rawTitle[1], ENT_QUOTES) : '');
                $extractedDesc = !empty($ogDesc[1]) ? html_entity_decode($ogDesc[1], ENT_QUOTES) : '';
                $extractedSite = !empty($ogSite[1]) ? html_entity_decode($ogSite[1], ENT_QUOTES) : '';

                if (!$description && $extractedDesc) {
                    $description = Str::limit(strip_tags($extractedDesc), 2500);
                }

                if ($extractedTitle) {
                    $cleanTitle = preg_replace('/(\||-|–)\s*(Glints|Jobstreet|LinkedIn|Kalibrr|KitaLulus|Dealls|Cari Lowongan).*/i', '', $extractedTitle);
                    $cleanTitle = trim($cleanTitle);

                    // Check "Job Title Job in Location" pattern (Jobstreet)
                    if (preg_match('/^(.*?)\s+Job\s+(?:in|di)\s+(.*)$/i', $cleanTitle, $mJobIn)) {
                        if (!$title || preg_match('/^\d+$/', $title)) {
                            $title = trim($mJobIn[1]);
                        }
                        if ($mJobIn[2] && (!$location || $location === 'Jakarta, Indonesia')) {
                            $location = trim($mJobIn[2]);
                        }
                    } elseif (preg_match('/^(.*?)\s+(?:at|di|pada|@)\s+(.*)$/i', $cleanTitle, $m)) {
                        if (!$title || preg_match('/^\d+$/', $title)) $title = trim($m[1]);
                        if (!$companyName || str_contains(strtolower($companyName), 'jobstreet')) $companyName = trim($m[2]);
                    } elseif (preg_match('/^(.*?)\s+(?:-|–|\|)\s+(.*)$/i', $cleanTitle, $m)) {
                        if (!$title || preg_match('/^\d+$/', $title)) $title = trim($m[1]);
                        if (!$companyName || str_contains(strtolower($companyName), 'jobstreet')) $companyName = trim($m[2]);
                    } else {
                        if (!$title || preg_match('/^\d+$/', $title)) $title = trim($cleanTitle);
                    }
                }

                // Extract company name from description if empty or generic
                if (!$companyName || in_array(strtolower(trim($companyName)), ['jobstreet', 'jobstreet indonesia', 'glints', 'linkedin', 'kalibrr', 'website resmi perusahaan'])) {
                    $searchContext = $extractedDesc . ' ' . $extractedTitle;
                    if (preg_match('/(?:job opportunities at|careers at|working at|bekerja di|lowongan di|at|di|pada|@)\s+([A-Z0-9\.\s\-&]+(?:Group|Indonesia|Persada|Tbk|PT|CV|Inc|Ltd|Healthcare|Hospital|Teknologi|Solution|Solutions|Services|Studio|Media)?)/i', $searchContext, $mComp)) {
                        $cName = trim(explode(',', $mComp[1])[0]);
                        $cName = trim(explode('.', $cName)[0]);
                        if (strlen($cName) > 2 && !preg_match('/^\d+$/', $cName)) {
                            $companyName = ucwords(strtolower($cName));
                        }
                    }
                }
                // Extract company logo URL from HTML (Jobstreet, Glints, Seek, Kalibrr, JSON-LD)
                if (preg_match_all('/<script[^>]+type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $ldMatches)) {
                    foreach ($ldMatches[1] as $ldText) {
                        $ldJson = json_decode($ldText, true);
                        if (isset($ldJson['hiringOrganization']['logo'])) {
                            $logo = $ldJson['hiringOrganization']['logo'];
                            $companyLogoUrl = is_array($logo) ? ($logo['url'] ?? '') : $logo;
                            if ($companyLogoUrl) break;
                        }
                    }
                }

                if (!$companyLogoUrl && preg_match('/"branding"\s*:\s*\{[^}]*"logoUrl"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/"branding"\s*:\s*\{[^}]*"logo"\s*:\s*\{[^}]*"url"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/"advertiser"\s*:\s*\{[^}]*"logoUrl"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/"companyLogo"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/"logo"\s*:\s*\{[^}]*"url"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/"logoUrl"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/"logo"\s*:\s*"([^"]+)"/i', $html, $mLogo)) {
                    $companyLogoUrl = str_replace(['\u002F', '\/'], '/', stripslashes($mLogo[1]));
                }
                if (!$companyLogoUrl && preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogImg)) {
                    $img = $ogImg[1];
                    if (!str_contains($img, 'shared-web/banner') && !str_contains($img, 'glints-logo') && !str_contains($img, 'jobstreet-logo') && !str_contains($img, 'seek-logo') && !str_contains($img, 'default')) {
                        $companyLogoUrl = $img;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Silently fallback to URL slug detection
        }

        // 4. Deteksi Gaji dari Judul / Deskripsi jika belum ada
        if (!$salary && ($title || $description)) {
            $searchText = $title . ' ' . $description;
            if (preg_match('/(?:Rp|IDR|\$)\s*\d+[\d\.,]*\s*(?:juta|jt|ribu|rb|k|m)?\s*(?:-|s\/d|to|sampai)\s*(?:Rp|IDR|\$)?\s*\d+[\d\.,]*\s*(?:juta|jt|ribu|rb|k|m)?/i', $searchText, $salMatch)) {
                $salary = trim($salMatch[0]);
            } elseif (preg_match('/(?:Rp|IDR|\$)\s*\d+[\d\.,]*\s*(?:juta|jt|ribu|rb|k)/i', $searchText, $salMatch)) {
                $salary = trim($salMatch[0]);
            } elseif (preg_match('/(\d+(?:[\.,]\d+)?\s*(?:-|s\/d|to)\s*\d+(?:[\.,]\d+)?\s*juta)/i', $searchText, $salMatch)) {
                $salary = 'Rp ' . trim($salMatch[1]);
            }
        }

        // Format Akronim UI/UX / RPL / TKJ / DKV
        $title = preg_replace_callback('/\b(Ui\s*Ux|Rpl|Tkj|Dkv|It|Api|Php|Sql|Css|Html|Sdk|Wfh)\b/i', function($m) {
            $val = strtoupper(str_replace(' ', '', $m[0]));
            if ($val === 'UIUX') return 'UI/UX';
            return $val;
        }, $title);

        if ($companyName) {
            $companyName = preg_replace_callback('/\b(Pt|Cv|Tb|Tbk|Inc|Llc|Ltd)\b/i', function($m) {
                return strtoupper($m[0]);
            }, $companyName);
        }

        // 5. Smart Guess Jurusan
        $fullText = strtolower($title . ' ' . $description);
        if (preg_match('/(developer|software|frontend|backend|fullstack|full-stack|full stack|mobile|flutter|react|vue|laravel|php|python|java|golang|android|ios|web|programmer|coding|code|api|database|sqa|tester|qa)/i', $fullText)) {
            $major = 'RPL';
        } elseif (preg_match('/(network|jaringan|sysadmin|devops|cloud|cisco|mikrotik|server|it support|cyber|security|infrastruktur|telekomunikasi)/i', $fullText)) {
            $major = 'TKJ';
        } elseif (preg_match('/(design|designer|ui|ux|graphic|grafis|video|animator|illustrat|motion|creative|figma|3d|photoshop|content|editor)/i', $fullText)) {
            $major = 'DKV';
        } else {
            $major = 'RPL'; // Default fallback jika tidak cocok dengan ketiganya
        }

        // 6. Smart Guess Tipe & Mode Kerja
        if (preg_match('/(intern|magang|internship|pkl)/i', $fullText)) {
            $workType = 'Internship';
        } elseif (preg_match('/(contract|kontrak)/i', $fullText)) {
            $workType = 'Contract';
        } elseif (preg_match('/(part time|paruh waktu)/i', $fullText)) {
            $workType = 'Part-time';
        } elseif (preg_match('/(freelance|lepas)/i', $fullText)) {
            $workType = 'Freelance';
        }

        if (preg_match('/(remote|wfh|jarak jauh)/i', $fullText)) {
            $workLocation = 'Remote/WFH';
        } elseif (preg_match('/(hybrid)/i', $fullText)) {
            $workLocation = 'Hybrid';
        }

        if (preg_match('/(jakarta|bogor|depok|tangerang|bekasi)/i', $fullText)) {
            $locationGroup = 'Jabodetabek';
            $location = 'Jakarta, Indonesia';
        } elseif (preg_match('/(bandung|surabaya|semarang|yogyakarta|jogja|solo|malang)/i', $fullText)) {
            $locationGroup = 'Jawa';
            $location = 'Jawa Barat / Jawa Tengah';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $title ?: '',
                'company_name' => $companyName ?: '',
                'company_logo_url' => $companyLogoUrl ?: '',
                'source_platform' => $sourcePlatform,
                'major' => $major,
                'work_type' => $workType,
                'work_location' => $workLocation,
                'location' => $location,
                'location_group' => $locationGroup,
                'salary' => $salary ?: '',
                'requirements' => $description ?: '',
                'apply_url' => $url,
            ],
        ]);
    }

    /**
     * Proxies external logo URL to base64 DataURL for client-side Cropper without CORS issues.
     */
    public function proxyLogo(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);

        $url = trim($request->input('url'));
        try {
            $res = Http::timeout(6)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                ])
                ->get($url);

            if ($res->successful()) {
                $mime = $res->header('Content-Type') ?: 'image/png';
                $base64 = base64_encode($res->body());
                return response()->json([
                    'success' => true,
                    'dataUrl' => "data:{$mime};base64,{$base64}"
                ]);
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil logo dari URL eksternal.'
        ], 400);
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
            'company_logo_url' => 'nullable|string|max:1000',
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
        } elseif ($request->filled('company_logo_url')) {
            $logoUrl = $request->input('company_logo_url');
            try {
                $imgRes = Http::timeout(5)->get($logoUrl);
                if ($imgRes->successful()) {
                    $uploadDir = public_path('assets/uploads/partners');
                    if (!File::exists($uploadDir)) {
                        File::makeDirectory($uploadDir, 0755, true, true);
                    }
                    $ext = 'png';
                    $contentType = $imgRes->header('Content-Type');
                    if (str_contains($contentType, 'jpeg') || str_contains($contentType, 'jpg')) $ext = 'jpg';
                    elseif (str_contains($contentType, 'webp')) $ext = 'webp';
                    elseif (str_contains($contentType, 'svg')) $ext = 'svg';

                    $fileName = time() . '_' . Str::random(6) . '.' . $ext;
                    File::put($uploadDir . '/' . $fileName, $imgRes->body());
                    $logoPath = 'assets/uploads/partners/' . $fileName;
                } else {
                    $logoPath = $logoUrl;
                }
            } catch (\Throwable $e) {
                $logoPath = $logoUrl;
            }
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
            'company_logo_url' => 'nullable|string|max:1000',
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
        } elseif ($request->filled('company_logo_url')) {
            $logoUrl = $request->input('company_logo_url');
            try {
                $imgRes = Http::timeout(5)->get($logoUrl);
                if ($imgRes->successful()) {
                    $uploadDir = public_path('assets/uploads/partners');
                    if (!File::exists($uploadDir)) {
                        File::makeDirectory($uploadDir, 0755, true, true);
                    }
                    $ext = 'png';
                    $contentType = $imgRes->header('Content-Type');
                    if (str_contains($contentType, 'jpeg') || str_contains($contentType, 'jpg')) $ext = 'jpg';
                    elseif (str_contains($contentType, 'webp')) $ext = 'webp';
                    elseif (str_contains($contentType, 'svg')) $ext = 'svg';

                    $fileName = time() . '_' . Str::random(6) . '.' . $ext;
                    File::put($uploadDir . '/' . $fileName, $imgRes->body());
                    $career->company_img = 'assets/uploads/partners/' . $fileName;
                } else {
                    $career->company_img = $logoUrl;
                }
            } catch (\Throwable $e) {
                $career->company_img = $logoUrl;
            }
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
