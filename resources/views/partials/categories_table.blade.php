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
                <th class="sortable" data-sort="category">Category
                    @if(request('sort') == 'category')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                 <th class="sortable" data-sort="total_post">Total Post
                    @if(request('sort') == 'total_post')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                 <th class="sortable" data-sort="status">Status
                    @if(request('sort') == 'status')
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
            @forelse ($categories as $index => $category)
                <tr>
                    <td class="text-center">{{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                    <td class="text-center">{{ Str::limit($category->category_name, 50) }}</td>
                    <td class="text-center"> {{ $category->total_post }}</td>
                    <td class="text-center"> @if($category->status == 1)
                        <span class="badge text-bg-success">Active</span>
                        @else
                        <span class="badge text-bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary view-category-btn" data-id="{{ $category->id }}" title="View">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning edit-category-btn" data-id="{{ $category->id }}" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-category-btn" data-id="{{ $category->id }}" title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No categories found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($categories->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
        </div>
        <div class="pagination-container">
            {{ $categories->withQueryString()->links() }}
        </div>
    </div>
@endif