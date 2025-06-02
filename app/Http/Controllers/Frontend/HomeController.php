<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * To share categories data into frontend layout
     */
    public function __construct()
    {
        $this->shareCategories();
    }

    /**
     * Get categories
     */
    protected function shareCategories()
    {
        view()->share('categories', Category::where('status', 1)->get());
    }

    /**
     * Home page
     */
    public function index() {
        $categories = Category::where('status', 1)->get();
        return view('frontend.home', compact('categories'));
    }
}
