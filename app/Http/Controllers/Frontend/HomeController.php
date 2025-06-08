<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\Post;

class HomeController extends Controller
{
    protected $perPage = 10;

     /**
     * Home page
     */
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'author'])->latest()->paginate($this->perPage);
        
        return view('frontend.home', compact('posts'));
    }

    /**
     * Show category wise news
     */
    public function categoryWiseNews($categoryId) {
        $category = Category::findOrFail($categoryId);
        
        $posts = Post::with(['category', 'author'])
                    ->where('category_id', $categoryId)
                    ->latest()
                    ->paginate($this->perPage);

        return view('frontend.category', compact('posts', 'category'));
    }
    
    /**
     * Show author wise news
     */
    public function authorWiseNews($userId) {
        $author = User::findOrFail($userId);
        
        $posts = Post::with(['category', 'author'])
                    ->where('user_id', $userId)
                    ->latest()
                    ->paginate($this->perPage);

        return view('frontend.author', compact('posts', 'author'));
    }

    /**
     * Show single news
     */
    public function singleNews($postId) {
        $post = Post::findOrFail($postId);
        
        $post = Post::with(['category', 'author'])->where('id', $postId)->first();
        return view('frontend.single_news', compact('post'));
    }

    
    /**
     * Search news
     */
    public function searchNews(Request $request)
    {
        $query = $request->input('query');
        
        $posts = Post::where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->with(['category', 'author'])
                    ->paginate(10);
        
        return view('frontend.search_news', compact('posts', 'query'));
    }
}
