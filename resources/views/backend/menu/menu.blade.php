@extends('backend.layouts.app')

@section('content')

<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/jquery-menu-editor.min.js"></script>

<h1 style="text-align: center; background-color:rgb(54, 148, 192); padding:10px; border-radius:10px;">Menu Editor</h1>

<div class="containersss" style="display: flex; justify-content: space-around;padding:10px;">
    <div>
        <ul id="myEditor" class="sortableLists list-group"></ul>
    </div>

    <?php
    $id = $finalmenu_output['id'];
    $finalmenu_output = json_decode($finalmenu_output['json_output'], true);
    ?>

    <div>
        <div class="card">
            <div class="card-header">Edit Item</div>
            <div class="card-body" style=" width: 500px;">
                <form id="frmEdit" class="form-horizontal">
                    <div class="form-group">
                        <label for="text">Text</label>
                        <div class="input-group">
                            <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Text">
                            <div class="input-group-append">
                                <button type="button" id="myEditor_icon" class="btn btn-outline-secondary"></button>
                            </div>
                        </div>
                        <input type="hidden" name="icon" class="item-menu">
                    </div>
                    <div class="form-group">
                        <label for="href">URL</label>
                        <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <label for="target">Target</label>
                        <select name="target" id="target" class="form-control item-menu">
                            <option value="_self">Self</option>
                            <option value="_blank">Blank</option>
                            <option value="_top">Top</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label for="Permission">Permission</label>
                        <input type="text" name="Permission" class="form-control item-menu" id="Permission" placeholder="Permission">
                    </div>
                </form>
            </div>
        </div>

        <!-- New Hidden Fields -->
        <input type="hidden" name="module_id" id="module_id" class="item-menu" value="">
        <input type="hidden" name="deleted_at" id="deleted_at" class="item-menu" value="">

        <div class="card-footer">
            <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            <button type="button" id="btnUpdate" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Update</button>
            <button type="button" id="SaveButton" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
        </div>
    </div>
</div>

<div style="display: none;">
    <form action="{{ route('updatejsondata') }}" method="POST" class="json-form">
        @csrf
        <textarea id="myTextarea" class="form-control" rows="8" name="json_output" required></textarea>
        <input type="hidden" name="id" value="{{ $id }}">
    </form>
</div>

<script>
    var iconPickerOptions = { searchText: "Search...", labelHeader: "{0}/{1}" };
    var sortableListOptions = { placeholderCss: { 'background-color': "#cccccc" } };
    var arrayjson = <?php echo json_encode($finalmenu_output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>;

    let moduleIdCounter = 1; // Initialize counter for module ids

    // Function to update the module data and increment module id
    function updateModulesData(item) {
        if (!item.text) return; // If no text, don't update
        item.modulesname = toCamelCase(item.text); // Set modulesname in camelCase
        item.moduleid = moduleIdCounter++; // Increment and assign module id
        item.deletestatus = 'NULL'; // Set deletestatus to active
        if (item.children && item.children.length > 0) {
            item.children.forEach(updateModulesData); // Recursively update children if they exist
        }
    }

    // Convert string to camelCase
    function toCamelCase(str) {
        return str
            .replace(/[-_\s\/]+(.)?/g, (match, chr) => (chr ? chr.toUpperCase() : '')) // Remove spaces, slashes, underscores
            .replace(/^(.)/, (match, chr) => chr.toLowerCase()); // Ensure first character is lowercase
    }

    var editor = new MenuEditor('myEditor', {
        listOptions: sortableListOptions,
        iconPicker: iconPickerOptions,
        maxLevel: 2,
        formOptions: {
            icon: 'input[name="icon"]',
            text: '#text',
            href: '#href',
            target: '#target',
            title: '#title',
            module_id: '#module_id', 
            deleted_at: '#deleted_at' 
        }
    });

    editor.setForm($('#frmEdit'));
    editor.setUpdateButton($('#btnUpdate'));
    editor.setData(arrayjson);

    $('#btnAdd').click(function () {
        editor.add();
        updateTextarea();
    });

    $('#btnUpdate').click(function () {
        editor.update();
        updateTextarea();
    });

    $('#SaveButton').click(function () {
        updateTextarea();
        document.querySelector('.json-form').submit();
    });

    function updateTextarea() {
        var jsonString = editor.getString();
        var jsonData = JSON.parse(jsonString);

        // Reset moduleIdCounter before updating
        moduleIdCounter = 1; 

        // Update each menu item with new module ids and names
        jsonData.forEach(updateModulesData);

        // Update the textarea with the modified JSON
        $('#myTextarea').val(JSON.stringify(jsonData, null, 2));
    }

    $('#myEditor_icon').iconpicker({
        placement: 'bottomLeft',
        animation: true
    }).on('iconpickerSelected', function (event) {
        $('input[name="icon"]').val(event.iconpickerValue);
    });
</script>

@endsection
