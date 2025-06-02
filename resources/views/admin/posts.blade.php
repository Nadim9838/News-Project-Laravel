<x-admin_layout>
    <!-- View Post Modal -->
    <div class="modal fade" id="viewPostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Post Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="postDetailsContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Post Modal -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addPostForm" enctype="multipart/form-data">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Post Modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPostForm" enctype="multipart/form-data">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Edit Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_post_id" name="id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                            <img id="currentImage" src="" class="img-thumbnail mt-2" width="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Post Management</h4>
            <div class="d-flex">
                <div class="input-group me-3" style="width: 300px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search posts...">
                    <button class="btn btn-outline-primary" type="button" id="searchBtn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostModal">
                    <i class="fa fa-plus"></i> Add New Post
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="posts-container">
                @include('partials.posts_table', ['posts' => $posts])
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            };

            // CSRF Token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load posts with AJAX
            function loadPosts(params = {}) {
              // Ensure default sorting values
              params.sort = params.sort || 'id';
              params.direction = ['asc', 'desc'].includes(params.direction) ? params.direction : 'desc';
              
              $('#posts-container').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
              
              $.ajax({
                  url: "{{ route('posts.index') }}",
                  data: params,
                  success: function(response) {
                      $('#posts-container').html(response.html);
                  },
                  error: function(xhr) {
                      let errorMsg = 'Error loading posts';
                      if (xhr.responseJSON && xhr.responseJSON.message) {
                          errorMsg += ': ' + xhr.responseJSON.message;
                      }
                      toastr.error(errorMsg);
                      console.error('AJAX Error:', xhr.responseText);
                  }
              });
            }

            /// Search functionality - improved version
            $('#searchBtn').click(function() {
                loadPosts({
                    search: $('#searchInput').val(),
                    sort: "{{ request('sort', 'id') }}",
                    direction: "{{ request('direction', 'desc') }}"
                });
            });

            $('#searchInput').keypress(function(e) {
                if (e.which === 13) { // Enter key
                    performSearch();
                }
            });

            function performSearch() {
                const searchQuery = $('#searchInput').val().trim();
                
                loadPosts({
                    search: searchQuery,
                    sort: "{{ request('sort') }}",
                    direction: "{{ request('direction') }}"
                });
            }

            // Sorting
            $(document).on('click', '.sortable', function() {
                  const sortField = $(this).data('sort');
                  let sortDirection = 'asc';
                  
                  // Toggle direction if same field is clicked again
                  if ("{{ request('sort') }}" === sortField && "{{ request('direction') }}" === 'asc') {
                      sortDirection = 'desc';
                  }
                  
                  loadPosts({
                      search: $('#searchInput').val(),
                      sort: sortField,
                      direction: sortDirection
                  });
              });

            // Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                
                loadPosts({
                    search: $('#searchInput').val(),
                    sort: "{{ request('sort') }}",
                    direction: "{{ request('direction') }}",
                    page: page
                });
            });

            // Add new post
            $('#addPostForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('posts.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#addPostForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function(response) {
                        $('#addPostModal').modal('hide');
                        $('#addPostForm')[0].reset();
                        loadPosts();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error creating post');
                        }
                    },
                    complete: function() {
                        $('#addPostForm button[type="submit"]').prop('disabled', false).html('Save Post');
                    }
                });
            });

            // View post details
            $(document).on('click', '.view-post-btn', function() {
                const postId = $(this).data('id');
                
                $.ajax({
                    url: `/posts/${postId}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#postDetailsContent').html('<div class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
                    },
                    success: function(response) {
                        const post = response.data;
                        $('#postDetailsContent').html(`
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/') }}/${post.image}" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Title</th>
                                    <td>${post.title}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>${post.description}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>${new Date(post.created_at).toLocaleString()}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>${new Date(post.updated_at).toLocaleString()}</td>
                                </tr>
                            </table>
                        `);
                        $('#viewPostModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading post details');
                    }
                });
            });

            // Edit post - load data
            $(document).on('click', '.edit-post-btn', function() {
                const postId = $(this).data('id');
                
                $.ajax({
                    url: `/posts/${postId}/edit`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#editPostForm input, #editPostForm textarea').val('');
                        $('#currentImage').attr('src', '');
                    },
                    success: function(response) {
                        const post = response.data;
                        $('#edit_post_id').val(post.id);
                        $('#edit_title').val(post.title);
                        $('#edit_description').val(post.description);
                        $('#currentImage').attr('src', `{{ asset('storage/') }}/${post.image}`);
                        $('#editPostModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading post for editing');
                    }
                });
            });

            // Update post
            $('#editPostForm').submit(function(e) {
                e.preventDefault();
                const postId = $('#edit_post_id').val();
                let formData = new FormData(this);
                
                $.ajax({
                    url: `/posts/${postId}`,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#editPostForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                    },
                    success: function(response) {
                        $('#editPostModal').modal('hide');
                        loadPosts();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error updating post');
                        }
                    },
                    complete: function() {
                        $('#editPostForm button[type="submit"]').prop('disabled', false).html('Update Post');
                    }
                });
            });

            // Delete post
            $(document).on('click', '.delete-post-btn', function() {
                const postId = $(this).data('id');
                
                if (confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
                    $.ajax({
                        url: `/posts/${postId}`,
                        type: 'DELETE',
                        beforeSend: function() {
                            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                        },
                        success: function(response) {
                            loadPosts();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error deleting post');
                        },
                        complete: function() {
                            $(this).prop('disabled', false).html('<i class="fa fa-trash"></i> Delete');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</x-admin_layout>