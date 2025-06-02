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
                <th class="sortable" data-sort="name">Name
                    @if(request('sort') == 'name')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th class="sortable" data-sort="email">Email
                    @if(request('sort') == 'email')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th class="sortable" data-sort="mobile">Mobile
                    @if(request('sort') == 'mobile')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th class="sortable" data-sort="role">Role
                    @if(request('sort') == 'role')
                        <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @else
                        <i class="fa fa-sort ms-1"></i>
                    @endif
                </th>
                <th class="sortable" data-sort="status">Staus
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
            @forelse ($users as $index => $user)
                <tr>
                    <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                    <td class="text-center">{{ Str::limit($user->name, 30) }}</td>
                    <td class="text-center">{{ Str::limit($user->email, 50) }}</td>
                    <td class="text-center">{{ Str::limit($user->mobile, 20) }}</td>
                    <td class="text-center"> @if($user->role == 1)
                        <span class="badge text-bg-warning">Admin</span>
                        @else
                        <span class="badge text-bg-warning">User</span>
                        @endif
                    </td>
                    <td class="text-center"> @if($user->status == 1)
                        <span class="badge text-bg-success">Active</span>
                        @else
                        <span class="badge text-bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary view-user-btn" data-id="{{ $user->id }}" title="View">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning edit-user-btn" data-id="{{ $user->id }}" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-user-btn" data-id="{{ $user->id }}" title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
        </div>
        <div class="pagination-container">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endif