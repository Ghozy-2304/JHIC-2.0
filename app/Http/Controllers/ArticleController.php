<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'Semua');
        $search = $request->query('search');

        // If user is actively searching or filtering by specific category, execute dynamic query
        if ($search || ($selectedCategory && $selectedCategory !== 'Semua')) {
            $query = Article::query();

            if ($selectedCategory && $selectedCategory !== 'Semua') {
                if (in_array(strtolower($selectedCategory), ['news & event', 'news', 'event', 'news & events'])) {
                    $query->whereIn('category', ['News & Event', 'News', 'Event', 'Berita', 'Pengumuman']);
                } else {
                    $query->where('category', $selectedCategory);
                }
            }

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            $featuredArticle = null;
            $gridQuery = clone $query;

            $articles = $gridQuery->orderBy('published_at', 'desc')
                ->paginate(9)
                ->withQueryString();
        } else {
            // Fetch featured article and paginated grid
            $featuredArticle = Article::where('slug', 'izin-operasional-smk-idn-bogor-resmi-terbit')->first()
                ?? Article::latest('published_at')->first();

            $gridQuery = Article::query();
            if ($featuredArticle) {
                $gridQuery->where('id', '!=', $featuredArticle->id);
            }

            $articles = $gridQuery->orderBy('published_at', 'desc')
                ->paginate(9);
        }

        $categories = ['Semua', 'Prestasi', 'News & Event'];

        return view('articles.index', compact('featuredArticle', 'articles', 'categories', 'selectedCategory', 'search'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $relatedArticles = Article::where('slug', '!=', $slug)
                                  ->orderBy('published_at', 'desc')
                                  ->take(3)
                                  ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
