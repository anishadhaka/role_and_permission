@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>    
</div>

<div class="row">
    <div class="moduleContainer">
    <form id="moduleSearchForm" data-id="{{ $role->id }}" style="text-align:right; margin-top:10px;" action="">
    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
        <select name="module_title" class="form-control" style="width: 300px; display: inline-block;">
            <option value="">-- Select Module --</option>
            @foreach($modules as $module)
                <option value="{{ $module->Title }}" 
                        {{ request()->input('module_title') == $module->Title ? 'selected' : '' }}>
                    {{ $module->Title }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>
    </div>
</form>

    </div>
</div>


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
         
              <div class="row">
    @foreach($modules as $module )
        <div class="col-lg-12">
            <div class="form-group   mb-3">
            <div style=" padding-left:5px;">
                <label>
                    <input type="checkbox" class="category-checkbox" data-category="{{ $module->Title }}">
                    <strong>{{ $module->Title }}</strong>
                </label>

                <div class="ml-4" style="padding-left:10px;border-left:1px solid gray;margin-left:8px;">
                    <!-- <div>
                        <input type="checkbox" class="menu-checkbox" data-category="{{ $module->Title }}" value="show menu"> Show Menu
                    </div> -->
                    <!-- <div class="form-group  p-2" style="margin-left:8px;">
                        @foreach($module->permission as $permission)
                        <div>
                            <label>
                                <input type="checkbox" class="permission-checkbox" data-category="{{ $module->Title }}" value="{{ $permission->id }}" name="permission[{{$permission->id}}]" class="name" {{ in_array($permission->id, $rolePermissions) ? 'checked' : ''}}>
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div> -->
                <div class="form-group  p-2" >
                 @foreach($module->childmodule as $childmod)
                    <div>
                        <label>
                            <input type="checkbox" class="category-checkbox" data-category="{{ $childmod->Title }}">
                            <strong>{{ $childmod->Title }}</strong>
                            <!-- {{$childmod->permission}} -->
                        </label>
                            <div class="form-group  p-2" style="margin-left:8px;border-left:1px solid gray;">
                            @foreach($childmod->permission as $permission)
                            <div>
                                <label>
                                    <input type="checkbox" class="permission-checkbox" data-category="{{ $childmod->Title }}" value="{{ $permission->id }}"  name="permission[{{$permission->id}}]" class="name" {{ in_array($permission->id, $rolePermissions) ? 'checked' : ''}}>
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                         </div>
                        </div>
                  @endforeach
                </div>
                </div>
            </div>
         </div>
        @endforeach
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // When a category checkbox is toggled
        document.querySelectorAll('.category-checkbox').forEach(categoryCheckbox => {
            categoryCheckbox.addEventListener('change', function () {
                const category = this.getAttribute('data-category');
                const isChecked = this.checked;

                // Check/uncheck all menus and permissions under this category
                document.querySelectorAll(`.menu-checkbox[data-category="${category}"], .permission-checkbox[data-category="${category}"]`).forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });


    
    $(document).ready(function () {
    $('#moduleSearchForm').on('submit', function (e) {
        e.preventDefault(); // Stop form submission

        const roleId = $(this).data('id'); // Get role ID
        const moduleTitle = $('select[name="module_title"]').val(); // Get selected module

        // AJAX request
        $.get(`/roles/${roleId}/edit`, { module_title: moduleTitle }, function (response) {
            const moduleContainer = $('.moduleContainer');
            moduleContainer.empty(); // Clear the container

            if (response.success && response.modules.length > 0) {
                // Loop through modules and append only the matching ones
                response.modules.forEach(module => {
                    moduleContainer.append(`
                        <div>
                            <h4>${module.Title}</h4>
                            <div style="margin-left: 20px; border-left: 1px solid #ccc; padding-left: 10px;">
                                ${module.childmodule.map(child => `
                                    <div>
                                        <strong>${child.Title}</strong>
                                        <div style="margin-left: 15px;">
                                            ${child.permission.map(perm => `
                                                <label>
                                                    <input type="checkbox" name="permission[${perm.id}]" value="${perm.id}">
                                                    ${perm.name}
                                                </label>
                                            `).join('')}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `);
                });
            } else {
                moduleContainer.append('<p>No modules found.</p>');
            }

            $('select[name="module_title"] option').each(function () {
                const optionValue = $(this).val();
                if (optionValue !== moduleTitle && optionValue !== "") {
                    $(this).hide(); 
                }
            });
        }).fail(function () {
            alert('Error fetching data. Please try again.');
        });
    });
});


</script>
@endsection

