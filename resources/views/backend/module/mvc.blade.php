@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2 style="text-align: -webkit-center; color: #782929;  text-decoration-line: underline; padding-bottom: 20px;">Generate MVC</h2>
    <!-- <p>Module ID: {{ $moduleId }}</p>
    <p>Table Name: {{ $tableName }}</p> -->

    <form action="{{ route('mvc.generate.mvc') }}" method="POST">
        @csrf
        <input type="hidden" name="module_id" value="{{ $moduleId }}">
        <input type="hidden" name="dropdown_options" id="dropdown_options">
        <div class="form-group">
            <h4> <i class="fa-solid fa-arrow-right"></i> Select Columns</h4>
            <div style="margin-left: 38px;"> 
            @foreach($columns as $column)
             @if($column !== 'id' && $column !== 'updated_at' && $column !== 'created_at' )  
                 <div class="form-check">
                     <input class="form-check-input" type="checkbox" value="{{ $column }}" id="column_{{ $column }}" name="columns[]">
                     <label class="form-check-label" for="column_{{ $column }}">
                         {{ $column }}
                     </label>
                 </div>
             @endif
           @endforeach
        </div>

        </div>

        <div class="form-group mt-4">
            <h4> <i class="fa-solid fa-arrow-right"></i> Edit Columns with Input Types</h4>
            <table class="table table-bordered" style=" margin-left: 32px;">
                <thead>
                    <tr>
                        <th>Column Name</th>
                        <th>Input Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($columns as $column)
                    @if($column !== 'id' && $column !== 'updated_at' && $column !== 'created_at' )  
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $column)) }}</td>
                            <td>
                                <select name="input_types[{{ $column }}]" class="form-control input-type">
                                    <option value="text" selected>Text</option>
                                    <option value="email">Email</option>
                                    <option value="number">Number</option>
                                    <option value="password">Password</option>
                                    <option value="date">Date</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="textarea">Radio</option>
                                    <option value="file">File</option>
                                    <option value="select">Select</option>
                                </select>
                            </td>
                        </tr>
                        @endif  
                    @endforeach
                </tbody>
            </table>
        </div>

        <input type="hidden" name="tableName" value="{{ $tableName }}">
        <button type="submit" class="btn btn-primary mt-3" style="margin-left: 32px;">Submit and Generate MVC</button>
    </form>
</div>

<!-- Modal for Selecting Options -->
<div class="modal fade" id="selectOptionPopup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Input Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="selectOptionsForm">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selectOptionType" value="table">
                        <label class="form-check-label">By Table</label>
                        

                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selectOptionType" value="custom">
                        <label class="form-check-label">By Customize</label>
                    </div>

                    <div id="tableSelectionDiv" class="mt-3" style="display: none;">
                        <label>Choose Table:</label>
                        <select id="tableSelect" class="form-control">
                            <option value="">Select Table</option>
                        </select>
                    </div>

                    <div id="columnSelectionDiv" class="mt-3" style="display: none;">
                        <label>Choose Column:</label>
                        <select id="columnSelect" class="form-control">
                            <option value="">Select Column</option>
                        </select>
                        
                    </div>

                  

                    <div id="customOptionsDiv" class="mt-3" style="display: none;">
                        <label>Enter Options:</label>
                        <div id="customOptionsContainer">
                            <div class="d-flex mb-2">
                                <input type="text" class="form-control me-2 custom-key" placeholder="Key">
                                <input type="text" class="form-control custom-value" placeholder="Value">
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="addCustomOption">Add More</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.input-type').on('change', function() {
        if ($(this).val() === 'select') {
            $('#selectOptionPopup').modal('show');
        }
    });

    $('input[name="selectOptionType"]').on('change', function() {
        let type = $(this).val();
        $('#tableSelectionDiv, #columnSelectionDiv, #customOptionsDiv').hide();
        if (type === 'table') {
            $('#tableSelectionDiv').show();
            fetchTables();
        } else {
            $('#customOptionsDiv').show();
        }
    });

    // Fetch tables dynamically
    function fetchTables() {
        $.ajax({
            url: "{{ route('module.getTables1') }}",
            type: "GET",
            success: function(response) {
                let tableSelect = $('#tableSelect');
                tableSelect.empty().append('<option value="">Select Table</option>');

                if (response.tables) {
                    response.tables.forEach(table => {
                        let tableName = Object.values(table)[0]; // Extract actual table name
                        tableSelect.append('<option value="' + tableName + '">' + tableName + '</option>');
                    });
                } else {
                    tableSelect.append('<option value="">No Tables Found</option>');
                }
            },
            error: function(xhr) {
                console.error("Error fetching tables:", xhr.responseText);
                alert("Failed to load tables.");
            }
        });
    }

    // On selecting a table, fetch columns including "id"
    $('#tableSelect').on('change', function() {
        let tableName = $(this).val();
        if (tableName) {
            $.ajax({
                url: "{{ route('fetch.columns') }}",
                type: "GET",
                data: { table: tableName },
                success: function(response) {
                    let columnSelect = $('#columnSelect');
                    columnSelect.empty().append('<option value="">Select Column</option>');

                    if (response.columns) {
                        response.columns.forEach(column => {
                            columnSelect.append('<option value="' + column + '">' + column + '</option>');
                        });
                        $('#columnSelectionDiv').show();
                    } else {
                        $('#columnSelectionDiv').hide();
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching columns:", xhr.responseText);
                    alert("Failed to load columns.");
                }
            });
        } else {
            $('#columnSelectionDiv').hide();
        }
    });

    // On selecting a column, show key-value dropdowns with "id" and the selected column
    $('#columnSelect').on('change', function() {
        let selectedColumn = $(this).val();
        if (selectedColumn) {
            $('#keyValueSelectionDiv').remove(); // Remove any existing dropdowns to avoid duplicates

            $('#columnSelectionDiv').append(`
                <div id="keyValueSelectionDiv" class="mt-3">
                    <label>Select Key and Value for Column:</label>
                    <select id="keySelect" class="form-control">
                        <option value="id">ID</option>
                        <option value="${selectedColumn}" selected>${selectedColumn}</option>
                    </select>
                    <select id="valueSelect" class="form-control mt-2">
                        <option value="id">ID</option>
                        <option value="${selectedColumn}" selected>${selectedColumn}</option>
                    </select>
                </div>
            `);
        }
    });

    // Add custom options dynamically
    $('#addCustomOption').on('click', function() {
        $('#customOptionsContainer').append('<div class="d-flex mb-2">' +
            '<input type="text" class="form-control me-2 custom-key" placeholder="Key">' +
            '<input type="text" class="form-control custom-value" placeholder="Value">' +
            '</div>');
    });

    // When the user clicks "Save" in the modal, collect the data and save it to the hidden input field
    $('.modal-footer .btn-primary').on('click', function() {
        let selectedOptions = [];

        // Check the selected option type (table or custom)
        let optionType = $('input[name="selectOptionType"]:checked').val();

        if (optionType === 'table') {
            // Get the selected table, column, key, and value
            let selectedTable = $('#tableSelect').val();
            let selectedColumn = $('#columnSelect').val();
            let selectedKey = $('#keySelect').val();
            let selectedValue = $('#valueSelect').val();

            if (selectedTable && selectedColumn && selectedKey && selectedValue) {
                selectedOptions.push({ 
                    table: selectedTable, 
                    column: selectedColumn,
                    key: selectedKey,
                    value: selectedValue 
                });
            }
        } else if (optionType === 'custom') {
            // Get the custom options entered by the user
            $('#customOptionsContainer .custom-key').each(function() {
                let key = $(this).val();
                let value = $(this).closest('.d-flex').find('.custom-value').val();
                if (key && value) {
                    selectedOptions.push({ key: key, value: value });
                }
            });
        }

        // Convert the selected options to JSON and update the hidden input field
        $('input[name="dropdown_options"]').val(JSON.stringify(selectedOptions));

        // Close the modal
        $('#selectOptionPopup').modal('hide');
    });
});


</script>
@endsection
