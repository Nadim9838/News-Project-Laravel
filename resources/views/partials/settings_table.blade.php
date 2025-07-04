<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="15%" class="text-center">Website Logo</th>
                <th class="text-center" >Website Name</th>
                <th class="text-center">Footer Description</th>
                <th width="12%" class="text-center">Date</th>
                <th width="15%" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">
                    <img src="{{ asset('storage/' . $setting->website_logo) }}" class="img-thumbnail" style="max-height: 60px;">
                </td>
                <td>{{ Str::limit($setting->website_name, 30) }}</td>
                <td>{{ Str::limit($setting->footer_desc, 50) }}</td>
                <td class="text-center">{{ $setting->created_at->format('d M Y') }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary view-setting-btn" data-id="{{ $setting->id }}" title="View">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning edit-setting-btn" data-id="{{ $setting->id }}" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-setting-btn" data-id="{{ $setting->id }}" title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>