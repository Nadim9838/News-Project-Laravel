<x-admin_layout>
    <!-- View Settings Modal -->
    <div class="modal fade" id="viewSettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Settings Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="settingDetailsContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Settings Modal -->
    <div class="modal fade" id="addSettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addSettingsForm" enctype="multipart/form-data">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="website_name" class="form-label">Website Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="website_name" name="website_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="footer_desc" class="form-label">Footer Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="footer_desc" name="footer_desc" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="website_logo" class="form-label">Website Logo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="website_logo" name="website_logo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Settings Modal -->
    <div class="modal fade" id="editSettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editSettingsForm" enctype="multipart/form-data">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Edit Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_setting_id" name="id">
                        <div class="mb-3">
                            <label for="edit_website_name" class="form-label">Website Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_website_name" name="website_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_footer_desc" class="form-label">Footer Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_footer_desc" name="footer_desc" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_website_logo" class="form-label">Website Logo</label>
                            <input type="file" class="form-control" id="edit_website_logo" name="website_logo">
                            <img id="currentImage" src="" class="img-thumbnail mt-2" width="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Update Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Settings Management</h4>
            <div class="d-flex">
                <div class="input-group me-3" style="width: 300px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search settings...">
                    <button class="btn btn-outline-primary" type="button" id="searchBtn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSettingsModal">
                    <i class="fa fa-plus"></i> Add New Settings
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="settings-container">
                @include('partials.settings_table', ['settings' => $settings])
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

            // Load settings with AJAX
            function loadSettingss(params = {}) {
              // Ensure default sorting values
              params.sort = params.sort || 'id';
              params.direction = ['asc', 'desc'].includes(params.direction) ? params.direction : 'desc';
              
              $('#settings-container').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
              
              $.ajax({
                  url: "{{ route('settings.index') }}",
                  data: params,
                  success: function(response) {
                      $('#settings-container').html(response.html);
                  },
                  error: function(xhr) {
                      let errorMsg = 'Error loading settings';
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
                loadSettingss({
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
                
                loadSettingss({
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
                  
                  loadSettingss({
                      search: $('#searchInput').val(),
                      sort: sortField,
                      direction: sortDirection
                  });
              });

            // Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                
                loadSettingss({
                    search: $('#searchInput').val(),
                    sort: "{{ request('sort') }}",
                    direction: "{{ request('direction') }}",
                    page: page
                });
            });

            // Add new setting
            $('#addSettingsForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('settings.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#addSettingsForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function(response) {
                        $('#addSettingsModal').modal('hide');
                        $('#addSettingsForm')[0].reset();
                        loadSettingss();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error creating setting');
                        }
                    },
                    complete: function() {
                        $('#addSettingsForm button[type="submit"]').prop('disabled', false).html('Save Settings');
                    }
                });
            });

            // View setting details
            $(document).on('click', '.view-setting-btn', function() {
                const settingId = $(this).data('id');
                
                $.ajax({
                    url: `/settings/${settingId}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#settingDetailsContent').html('<div class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
                    },
                    success: function(response) {
                        const setting = response.data;
                        $('#settingDetailsContent').html(`
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/website_logo/') }}/${setting.website_logo}" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Website Name</th>
                                    <td>${setting.website_name}</td>
                                </tr>
                                <tr>
                                    <th>Footer Description</th>
                                    <td>${setting.footer_desc}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>${new Date(setting.created_at).toLocaleString()}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>${new Date(setting.updated_at).toLocaleString()}</td>
                                </tr>
                            </table>
                        `);
                        $('#viewSettingsModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading setting details');
                    }
                });
            });

            // Edit setting - load data
            $(document).on('click', '.edit-setting-btn', function() {
                const settingId = $(this).data('id');
                
                $.ajax({
                    url: `/settings/${settingId}/edit`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#editSettingsForm input, #editSettingsForm textarea').val('');
                        $('#currentImage').attr('src', '');
                    },
                    success: function(response) {
                        const setting = response.data;
                        $('#edit_setting_id').val(setting.id);
                        $('#edit_website_name').val(setting.website_name);
                        $('#edit_footer_desc').val(setting.footer_desc);
                        $('#currentImage').attr('src', `{{ asset('storage/website_logo') }}/${setting.website_logo}`);
                        $('#editSettingsModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error loading setting for editing');
                    }
                });
            });

            // Update setting
            $('#editSettingsForm').submit(function(e) {
                e.preventDefault();
                const settingId = $('#edit_setting_id').val();
                let formData = new FormData(this);
                
                $.ajax({
                    url: `/settings/${settingId}`,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#editSettingsForm button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                    },
                    success: function(response) {
                        $('#editSettingsModal').modal('hide');
                        loadSettingss();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Error updating setting');
                        }
                    },
                    complete: function() {
                        $('#editSettingsForm button[type="submit"]').prop('disabled', false).html('Update Settings');
                    }
                });
            });

            // Delete setting
            $(document).on('click', '.delete-setting-btn', function() {
                const settingId = $(this).data('id');
                
                if (confirm('Are you sure you want to delete this setting? This action cannot be undone.')) {
                    $.ajax({
                        url: `/settings/${settingId}`,
                        type: 'DELETE',
                        beforeSend: function() {
                            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                        },
                        success: function(response) {
                            loadSettingss();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error deleting setting');
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