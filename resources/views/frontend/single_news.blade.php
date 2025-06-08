<x-frontend>
  <h2 class="page-heading"> {{ $post->category->category_name }} </h2>
  <div class="post-content single-post">
    <h3>{{ $post->title }}</h3>
    <div class="post-information">
      <span>
          <i class="fa fa-tags" aria-hidden="true"></i>
          <a href="{{ route('category.news', $post->category->id) }}"> {{ $post->category->category_name }}</a>
      </span>
      <span>
          <i class="fa fa-user" aria-hidden="true"></i>
          <a href="{{ route('author.news', $post->author->id) }}"> {{ $post->author->name }}</a>
      </span>
      <span>
          <i class="fa fa-calendar" aria-hidden="true"></i>
          {{ $post->created_at->format('M d, Y') }}
      </span>
    </div>
    <img class="single-feature-image" src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}"/>
    <p class="description">
        {{ $post->description }}
    </p>
  </div>
</x-frontend>