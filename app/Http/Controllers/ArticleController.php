<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Fetch 3 other articles to show in the related articles sidebar
        $relatedArticles = Article::where('slug', '!=', $slug)
                                  ->latest('published_at')
                                  ->take(3)
                                  ->get();
                                  
        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
