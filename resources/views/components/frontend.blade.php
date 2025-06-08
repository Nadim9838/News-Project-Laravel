<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>City News</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.css') }} ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <div class="container">
        <div class="row">
            <div class=" col-md-offset-4 col-md-4">
                @if($settings->website_logo)
                    <a href="/" id="logo"><img src="{{ asset('storage/'.$settings->website_logo) }}" alt=""></a>
                @else
                    <a href="/" id="logo"><h1>City News</h1></a>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                    @php $catId = request()->route('id', 0); @endphp
                    <li><a href="{{ route('home') }}" class="{{ request()->is('home') ? 'active' : '' }}">Home</a></li>
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                        <li><a class="{{ $category->id == $catId && request()->is('category') ? 'active' : '' }}" href="{{ route('category.news', $category->id) }}">{{ $category->category_name }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->

<div id="main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="post-container">
            {{ $slot }}
          </div>
        </div>
        <div id="sidebar" class="col-md-4">
            <div class="search-box-container">
                <h4>Search</h4>
                <form class="search-post" action="{{ route('search.news') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Search ....." value="{{ request('query') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-danger">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="recent-post-container">
                <h4>Recent Posts</h4>
                @foreach($latestPost as $post)  
                <div class="recent-post">
                    <a class="post-img" href="">
                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}"/>
                    </a>
                    <div class="post-content">
                        <h5><a href="{{ route('category.news', $post->category->id) }}">{{ $post->title }}</a></h5>
                        <span>
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            <a href="{{ route('category.news', $post->category->id) }}"> {{ $post->category->category_name }} </a>
                        </span>
                        <span>
                            <i class="fa fa-calendar" aria-hidden="true"></i> {{ $post->created_at->format('M d, Y') }}
                        </span>
                        <a class="read-more" href="{{ route('single.news', $post->id) }}">read more</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
</div>
<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{ $settings->footer_desc ? $settings->footer_desc : '© All Rights Reserved City News' }}
            </div>
        </div>
    </div>
</div>
</body>
</html>

