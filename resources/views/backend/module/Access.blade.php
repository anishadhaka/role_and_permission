@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Manage Access</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('module.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

<form method="POST" action="">
    @csrf
<ul>
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
                    <div>
                        <input type="checkbox" class="menu-checkbox" data-category="{{ $module->Title }}" value="show menu"> Show Menu
                    </div>
                    <div class="form-group  p-2" style="margin-left:8px;border-left:1px solid gray;">
                        @foreach($module->permission as $permission)
                        <div>
                            <label>
                                <input type="checkbox" class="permission-checkbox" data-category="{{ $module->Title }}" value="{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group  p-2" style="margin-left:8px;border-left:1px solid gray;">
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
                                <input type="checkbox" class="permission-checkbox" data-category="{{ $childmod->Title }}" value="{{ $permission->id }}">
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
</ul>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
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

        // Optionally, if you want menus to control permissions under them
        document.querySelectorAll('.menu-checkbox').forEach(menuCheckbox => {
            menuCheckbox.addEventListener('change', function () {
                const category = this.getAttribute('data-category');
                const isChecked = this.checked;

                // Check/uncheck all permissions under this menu
                document.querySelectorAll(`.permission-checkbox[data-category="${category}"]`).forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });
    });
</script>
@endsection