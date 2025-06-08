<x-frontend>
  <h2 class="page-heading">Search: {{ $query }} </h2>
  @forelse($posts as $post)
    <div class="post-content">
      <div class="row">
        <div class="col-md-4">
          <a class="post-img" href="{{ route('single.news', $post->id) }}"><img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}"/></a>
        </div>
        <div class="col-md-8">
          <div class="inner-content clearfix">
            <h3><a href="{{ route('single.news', $post->id) }}"> {{ $post->title }}</a></h3>
            <div class="post-information">
              <span>
                <i class="fa fa-tags" aria-hidden="true"></i>
                <a href="{{ route('category.news', $post->category->id) }}"> {{ $post->category->category_name }} </a>
              </span>
              <span>
                <i class="fa fa-user" aria-hidden="true"></i>
                <a href="{{ route('author.news', $post->author->id) }}"> {{ $post->author->name }} </a>
              </span>
              <span>
                <i class="fa fa-calendar" aria-hidden="true"></i> {{ $post->created_at->format('M d, Y') }}
              </span>
            </div>
            <p class="description">{{ Str::limit(strip_tags($post->description), 150) }}</p>
            <a class='read-more pull-right' href='{{ route('single.news', $post->id) }}'>read more</a>
          </div>
        </div>
      </div>
    </div>
    @empty
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">No posts found.</p>
        </div>
    @endforelse
  {{ $posts->links() }}
</x-frontend>