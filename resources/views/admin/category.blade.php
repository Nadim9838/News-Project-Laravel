<x-admin_layout>
    <div class="container">
        <!-- View Category Modal -->
        <div class="modal fade" id="viewCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Category Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="categoryDetailsContent">
                        <!-- Content will be loaded via AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addCategoryForm" enctype="multipart/form-data">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category_name" class="form-control" id="category_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editCategoryForm" enctype="multipart/form-data">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_category_id" name="id">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category_name" class="form-control" id="edit_category_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-control form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Category Management</h4>
                <div class="d-flex">
                    <div class="input-group me-3" style="width: 300px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search categories...">
                        <button class="btn btn-outline-primary" type="button" id="searchBtn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fa fa-plus"></i> Add New Category
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="categories-container">
                    @include('partials.categories_table', ['categories' => $categories])
                </div>
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

            // Load categories with AJAX
            function loadCategorys(params = {}) {
              // Ensure default sorting values
              params.sort = params.sort || 'id';
              params.direction = ['asc', 'desc'].includes(params.direction) ? params.direction : 'desc';
              
              $('#categories-container').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
              
              $.ajax({
                  url: "{{ route('category.index') }}",
                  data: params,
                  success: function(response) {
                      $('#categories-container').html(response.html);
                  },
                  error: function(xhr) {
                      let errorMsg = 'Error loading categories';
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
                loadCategorys({
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
                
                loadCategorys({
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
                  
                  loadCategorys({
                      search: $('#searchInput').val(),
                      sort: sortField,
                      direction: sortDirection
                  });
              });

            // Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                
                loadCategorys({
                    search: $('#searchInput').val(),
                    sort: "{{ request('sort') }}",
                    direction: "{{ request('direction') }}",
                    page: page
                });
            });

            // Add new category
            $('#addCategoryForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('category.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#addCategoryForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function(response) {
                        $('#addCategoryModal').modal('hide');
                        $('#addCategoryForm')[0].reset();
                        loadCategorys();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error creating category');
                        }
                    },
                    complete: function() {
                        $('#addCategoryForm button[type="submit"]').prop('disabled', false).html('Save Category');
                    }
                });
            });

            // View category details
            $(document).on('click', '.view-category-btn', function() {
                const categoryId = $(this).data('id');
                
                $.ajax({
                    url: `/category/${categoryId}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#categoryDetailsContent').html('<div class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
                    },
                    success: function(response) {
                        const category = response.data;
                        $('#categoryDetailsContent').html(`
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Category</th>
                                    <td>${category.category_name}</td>
                                </tr>
                                <tr>
                                    <th>Total Post</th>
                                    <td>${category.total_post}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>${(category.status == 1) ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>'}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>${new Date(category.created_at).toLocaleString()}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>${new Date(category.updated_at).toLocaleString()}</td>
                                </tr>
                            </table>
                        `);
                        $('#viewCategoryModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading category details');
                    }
                });
            });

            // Edit category - load data
            $(document).on('click', '.edit-category-btn', function() {
                const categoryId = $(this).data('id');
                
                $.ajax({
                    url: `/category/${categoryId}/edit`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#editCategoryForm input, #editCategoryForm textarea').val('');
                        $('#currentImage').attr('src', '');
                    },
                    success: function(response) {
                        const category = response.data;
                        $('#edit_category_id').val(category.id);
                        $('#edit_category_name').val(category.category_name);
                        $('#edit_status').val(category.status);
                        $('#editCategoryModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading category for editing');
                    }
                });
            });

            // Update category
            $('#editCategoryForm').submit(function(e) {
                e.preventDefault();
                const categoryId = $('#edit_category_id').val();
                let formData = new FormData(this);
                
                $.ajax({
                    url: `/category/${categoryId}`,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#editCategoryForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                    },
                    success: function(response) {
                        $('#editCategoryModal').modal('hide');
                        loadCategorys();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error updating category');
                        }
                    },
                    complete: function() {
                        $('#editCategoryForm button[type="submit"]').prop('disabled', false).html('Update Category');
                    }
                });
            });

            // Delete category
            $(document).on('click', '.delete-category-btn', function() {
                const categoryId = $(this).data('id');
                
                if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                    $.ajax({
                        url: `/category/${categoryId}`,
                        type: 'DELETE',
                        beforeSend: function() {
                            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                        },
                        success: function(response) {
                            loadCategorys();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error deleting category');
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