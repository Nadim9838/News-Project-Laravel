<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="10%" class="sortable text-center" data-sort="id">Sr. No.
                    @if(request('sort') == 'id')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th width="15%">Image</th>
                <th class="sortable" data-sort="title">Title
                    @if(request('sort') == 'title')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th class="sortable" data-sort="description">Description
                    @if(request('sort') == 'description')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th width="12%" class="sortable text-center" data-sort="created_at">Date
                    @if(request('sort') == 'created_at')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th width="15%" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $index => $post)
                <tr>
                    <td class="text-center">{{ ($posts->currentPage() - 1) * $posts->perPage() + $index + 1 }}</td>
                    <td class="text-center">
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail" style="max-height: 60px;">
                    </td>
                    <td title="{{ $post->title }}">{{ Str::limit($post->title, 30) }}</td>
                    <td title="{{ $post->description }}">{{ Str::limit($post->description, 50) }}</td>
                    <td class="text-center">{{ $post->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary view-post-btn" data-id="{{ $post->id }}" title="View">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning edit-post-btn" data-id="{{ $post->id }}" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-post-btn" data-id="{{ $post->id }}" title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No posts found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($posts->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries
        </div>
        <div class="pagination-container">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
@endif