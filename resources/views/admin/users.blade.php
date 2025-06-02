<x-admin_layout>
    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userDetailsContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addUserForm" enctype="multipart/form-data">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input type="number" maxlength="10" class="form-control" id="mobile" name="mobile" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">User Role <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-control form-select" required>
                                <option value="">Select User Role</option>
                                <option value="1">User</option>
                                <option value="0">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUserForm" enctype="multipart/form-data">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_user_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input type="number" maxlength="10" class="form-control" id="edit_mobile" name="mobile" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="edit_confirm_password" name="password_confirmation">
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">User Role <span class="text-danger">*</span></label>
                            <select name="role" id="edit_role" class="form-control form-select" required>
                                <option value="">Select User Role</option>
                                <option value="1">User</option>
                                <option value="0">Admin</option>
                            </select>
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
                        <button type="submit" class="btn btn-warning">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>User Management</h4>
            <div class="d-flex">
                <div class="input-group me-3" style="width: 300px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
                    <button class="btn btn-outline-primary" type="button" id="searchBtn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa fa-plus"></i> Add New User
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="users-container">
                @include('partials.users_table', ['users' => $users])
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

            // Load users with AJAX
            function loadUsers(params = {}) {
              // Ensure default sorting values
              params.sort = params.sort || 'id';
              params.direction = ['asc', 'desc'].includes(params.direction) ? params.direction : 'desc';
              
              $('#users-container').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
              
              $.ajax({
                  url: "{{ route('users.index') }}",
                  data: params,
                  success: function(response) {
                      $('#users-container').html(response.html);
                  },
                  error: function(xhr) {
                      let errorMsg = 'Error loading users';
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
                loadUsers({
                    search: $('#searchInput').val(),
                    sort: "{{ request('sort', 'id') }}",
                    direction: "{{ request('direction', 'desc') }}"
                });
            });

            $('#searchInput').keypress(function(e) {
                if (e.which === 13) {
                    performSearch();
                }
            });

            function performSearch() {
                const searchQuery = $('#searchInput').val().trim();
                
                loadUsers({
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
                  
                  loadUsers({
                      search: $('#searchInput').val(),
                      sort: sortField,
                      direction: sortDirection
                  });
              });

            // Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                
                loadUsers({
                    search: $('#searchInput').val(),
                    sort: "{{ request('sort') }}",
                    direction: "{{ request('direction') }}",
                    page: page
                });
            });

            // Add new user
            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#addUserForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function(response) {
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        loadUsers();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error creating user');
                        }
                    },
                    complete: function() {
                        $('#addUserForm button[type="submit"]').prop('disabled', false).html('Save User');
                    }
                });
            });

            // View user details
            $(document).on('click', '.view-user-btn', function() {
                const userId = $(this).data('id');
                
                $.ajax({
                    url: `/users/${userId}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#userDetailsContent').html('<div class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
                    },
                    success: function(response) {
                        const user = response.data;
                        $('#userDetailsContent').html(`
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>${user.name}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>${user.email}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>${user.mobile}</td>
                                </tr>
                                <tr>
                                    <th>User Role</th>
                                    <td>${(user.role == 1) ? 'Admin' : 'User'}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>${(user.status == 1) ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>'}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>${new Date(user.created_at).toLocaleString()}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>${new Date(user.updated_at).toLocaleString()}</td>
                                </tr>
                            </table>
                        `);
                        $('#viewUserModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading user details');
                    }
                });
            });

            // Edit user - load data
            $(document).on('click', '.edit-user-btn', function() {
                const userId = $(this).data('id');
                
                $.ajax({
                    url: `/users/${userId}/edit`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#editUserForm input, #editUserForm textarea').val('');

                    },
                    success: function(response) {
                        const user = response.data;
                        $('#edit_user_id').val(user.id);
                        $('#edit_name').val(user.name);
                        $('#edit_email').val(user.email);
                        $('#edit_mobile').val(user.mobile);
                        $('#edit_password').val(user.password);
                        $('#edit_confirm_password').val(user.password);
                        $('#edit_role').val(user.role);
                        $('#edit_status').val(user.status);
                        $('#editUserModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading user for editing');
                    }
                });
            });

            // Update user
            $('#editUserForm').submit(function(e) {
                e.preventDefault();
                const userId = $('#edit_user_id').val();
                let formData = new FormData(this);
                
                $.ajax({
                    url: `/users/${userId}`,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#editUserForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                    },
                    success: function(response) {
                        $('#editUserModal').modal('hide');
                        loadUsers();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error updating user');
                        }
                    },
                    complete: function() {
                        $('#editUserForm button[type="submit"]').prop('disabled', false).html('Update User');
                    }
                });
            });

            // Delete user
            $(document).on('click', '.delete-user-btn', function() {
                const userId = $(this).data('id');
                
                if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                    $.ajax({
                        url: `/users/${userId}`,
                        type: 'DELETE',
                        beforeSend: function() {
                            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                        },
                        success: function(response) {
                            loadUsers();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error deleting user');
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