<form>
    <div class="col-md-12 filter-top">
        <h6>Filters</h6>
            <button class="btn btn-primary text-center" type="submit">Apply</button>
    </div>
    </div>
    <div class="row">
        @if($statusId)
            <div class="col-md-2">
                <label class="form-label">Select Related Status</label>
                <select class="form-control" title="{{ is_array(request()->get('status_id')) }}" name="status_id" id="status-id">
                    <option value="">-- All --</option>
                    @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                        @if(in_array($status->id(), $statusId))
                            <option value="{{ $status->id() }}" @selected(request()->get('status_id') == $status->id())>{{ $status->value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
        @if($perPage)
            <div class="col-md-2">
                <label class="form-label">Records Per Page</label>
                <select class="form-control" name="per_page" id="per-page">
                    @foreach ([50, 100, 150, 200, 'All'] as $option)
                        <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
        
        @endif
        <div class="col-md-4">
            <label class="form-label">Select Date Range</label>
            <div id="dateRangePicker" style="display: flex; justify-content: space-between; width: 300px;">
                <input type="text" style="padding: 8px; width: 140px; border: 1px solid #ccc; border-radius: 4px;" class="form-control" id="startDate" value="{{ request()->get('startDate') }}" name="startDate" placeholder="Start Date">
                <input type="text" style="padding: 8px; width: 140px; border: 1px solid #ccc; border-radius: 4px;" class="form-control" id="endDate" name="endDate" value="{{ request()->get('endDate') }}" placeholder="End Date">
            </div>
        </div>

     
        <div class="col-md-4">
            <label class="form-label">Select FY (Leave Blank if Selecting DateRange)</label>
            <select class="form-control fy" title="{{ request()->get('fy') }}" name="fy" id="status-id">
                <option value="">Select FY</option>
                <option value="2024-2025" @selected(request()->get('fy') == '2024-2025')>2024-2025</option>
                <option value="2023-2024" @selected(request()->get('fy') == '2023-2024')>2023-2024</option>
                <option value="2022-2023" @selected(request()->get('fy') == '2022-2023')>2022-2023</option>
                <option value="2021-2022" @selected(request()->get('fy') == '2021-2022')>2021-2022</option>
                <option value="2020-2021" @selected(request()->get('fy') == '2020-2021')>2020-2021</option>
            </select>
        </div>
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isNodalBank())
            <div class="col-md-2">
                <!-- District Dropdown -->
                <label class="form-label">Select District</label>
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        District
                    </button>
                    <ul class="dropdown-menu" id="district-multiselect">
                        <li>
                            <label class="dropdown-item ">
                                <input type="checkbox" class="district-checkbox" id="select-all-districts-multiselect"> Select All
                            </label>
                        </li>
                        @foreach($districts as $district)
                            <li>
                                <label class="dropdown-item">
                                    <input type="checkbox" class="district-checkbox" value="{{ $district->id }}" {{ request()->has('district_id') &&  in_array($district->id, request('district_id')) ? 'checked' : '' }} name="district_id[]">
                                    {{ $district->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($constituencies)
            <div class="col-md-2">
                <label class="form-label">Select Constituency</label>
                <!-- Constituency Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Constituency
                    </button>
                    <ul class="dropdown-menu" id="constituency-multiselect">
                        <li>
                            <label class="dropdown-item">
                                <input type="checkbox" id="select-all-constituency-multiselect"> Select All
                            </label>
                        </li>
                            @foreach($constituencies as $constituency)
                                <li>
                                    <label class="dropdown-item">
                                        <input name="constituency_id[]" type="checkbox" class="constituency-checkbox" {{ request()->has('constituency_id') && in_array($constituency->id, request('constituency_id')) ? 'checked' : '' }} value="{{ $constituency->id }}">
                                        {{ $constituency->name }}
                                    </label>
                                </li>
                            @endforeach
                    
                    </ul>
                </div>
            </div>
        @endif
        @if($tehsils)
            <div class="col-md-2">
            <label class="form-label">Select Tehsil</label>
            <!-- Tehsil Dropdown -->
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tehsil
                </button>
                <ul class="dropdown-menu" id="tehsil-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input name="tehsil_id[]" type="checkbox" id="select-all-tehsil-multiselect"> Select All
                        </label>
                    </li>
                        @foreach($tehsils as $tehsil)
                            <li>
                                <label class="dropdown-item">
                                    <input name="tehsil_id[]" type="checkbox" class="tehsil-checkbox" {{ request()->has('tehsil_id') && in_array($tehsil->id, request('tehsil_id')) ? 'checked' : '' }} value="{{ $tehsil->id }}">
                                    {{ $tehsil->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($blocks)
            <div class="col-md-2">
            <label class="form-label">Select Block/Town</label>
            <!-- Block/Town Dropdown -->
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Block/Town
                </button>
                <ul class="dropdown-menu" id="block-town-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-block-town-multiselect"> Select All
                        </label>
                    </li>
                        @foreach($blocks as $block)
                            <li>
                                <label class="dropdown-item">
                                    <input  name="block_id[]" type="checkbox" class="block-town-checkbox" {{ request()->has('block_id') && in_array($block->id, request('block_id')) ? 'checked' : '' }} value="{{ $block->id }}">
                                    {{ $block->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($panchayatWards)
            <div class="col-md-2">
                <label class="form-label">Select Panchayat/Ward</label>
                <!-- Panchayat/Ward Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Panchayat/Ward
                    </button>
                    <ul class="dropdown-menu" id="panchayat-ward-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-panchayat-ward-multiselect"> Select All
                        </label>
                    </li>
                        @foreach($panchayatWards as $panchayatWard)
                            <li>
                                <label class="dropdown-item">
                                    <input name="panchayat_id[]" {{ request()->has('panchayat_id') &&  in_array($panchayatWard->id, request('panchayat_id')) ? 'checked' : '' }} type="checkbox" class="panchayat-ward-checkbox" value="{{ $panchayatWard->id }}">
                                    {{ $panchayatWard->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($categories)
            <div class="col-md-2">
                <label class="form-label">Select Social Category</label>
                <select class="form-control" title="{{ is_array(request()->get('cat_id')) }}" name="cat_id" id="cat-id">
                    <option value="">-- All --</option>
                    @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request()->get('cat_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if($activities)
            <div class="col-md-2">
                <label class="form-label">Select Activity</label>
                <select style="width: 200px" class="form-control activities" title="{{ is_array(request()->get('activity_id')) }}" name="activity_id" id="activity-id">
                    <option value="All">-- All --</option>
                    @foreach($activities as $activity)
                            <option value="{{ $activity->id }}" @selected(request()->get('activity_id') == $activity->id)>{{ $activity->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<script>
    // JavaScript to handle custom multiselect
    $(document).ready(function () {
    //     $('#activity-id').selectize({
    //       sortField: 'text'
    //   });
        // Event delegation to capture form submission
        $('form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create an array to store query parameters
        const queryParams = [];

        // Iterate over all checkboxes with a specific class
        $('input[type="checkbox"]:checked').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();

            // Add the name and value as a query parameter
            queryParams.push(`${name}=${encodeURIComponent(value)}`);
        });

        // Get the selected value from the select element
        const selectedStatusValue = $('#status-id').val();
        const selectedCategoryValue = $('#cat-id').val();
        const selectedActivityValue = $('#activity-id').val();
        const selectedFYValue = $('.fy').val();
        const perPage = $('#per-page').val();

        // Push the selectedStatusValue into the queryParams array as status_id
        if (selectedStatusValue) {
            queryParams.push(`status_id=${encodeURIComponent(selectedStatusValue)}`);
        }
        // Push the selectedStatusValue into the queryParams array as status_id
        if (selectedCategoryValue) {
            queryParams.push(`cat_id=${encodeURIComponent(selectedCategoryValue)}`);
        }
        // Push the selectedStatusValue into the queryParams array as status_id
        if (selectedActivityValue) {
            queryParams.push(`activity_id=${encodeURIComponent(selectedActivityValue)}`);
        }
        // Push the selectedFYValue into the queryParams array as fy
        if (selectedFYValue) {
            queryParams.push(`fy=${encodeURIComponent(selectedFYValue)}`);
        }
        // Push the perPage into the queryParams array as fy
        if (perPage) {
            queryParams.push(`per_page=${encodeURIComponent(perPage)}`);
        }
                // Get default start and end dates
        const defaultStartDate = $('#startDate').datepicker('getDate');
        const defaultEndDate = $('#endDate').datepicker('getDate');

        // Format default dates
        const formattedStartDate = $.datepicker.formatDate('yy/mm/dd', defaultStartDate);
        const formattedEndDate = $.datepicker.formatDate('yy/mm/dd', defaultEndDate);

        // Add default dates to queryParams
        queryParams.push(`start_date=${encodeURIComponent(formattedStartDate)}`);
        queryParams.push(`end_date=${encodeURIComponent(formattedEndDate)}`);

        console.log('queryParams',queryParams)
        // Construct the URL with the query parameters
        const url = `${window.location.pathname}?${queryParams.join('&')}`;

        // Redirect to the new URL
        window.location.href = url;
    });


    // Function to populate dropdown options
    function populateDropdown(dropdownId, options,selectedValues,name,className) {
        const $dropdown = $(`#${dropdownId}`);
        const selectAllCheckbox = `
            <li>
                <label class="dropdown-item">
                    <input type="checkbox" id="select-all-${dropdownId}" class="select-all-checkbox"> Select All
                </label>
            </li>
        `;

        $dropdown.empty();
        $dropdown.append(selectAllCheckbox);
        options.forEach((option) => {
            const isChecked = selectedValues?.includes(option.id.toString()) ? 'checked' : '';
            $dropdown.append(`
                <li><label  class="dropdown-item"><input name="${name}" class="${className}" type="checkbox" value="${option.id}" ${isChecked}> ${option.name}</label></li>
            `);
        });
    }
    // Hit District *****************************
        // hitDistrictFun('values')
        $('#district-multiselect').on('change', 'li input', function () {
            const clickedId = $(this).attr('id');
            const selectedDistricts = [];
            if (clickedId === 'select-all-districts-multiselect') {
                console.log('clickedId',clickedId)
                $('#district-multiselect li input').prop('checked', $(this).prop('checked'));
            } else {
                $('#district-multiselect li input:checked').each(function () {
                    selectedDistricts.push($(this).val());
                });
            }
            getData('district',selectedDistricts)
            // hitDistrictFun(clickedId)
        });
        function resetChecks() {
            $('#constituency-multiselect li input').removeAttr('checked');
            $('#tehsil-multiselect li input').removeAttr('checked');
            $('#block-town-multiselect li input').removeAttr('checked');
            $('#panchayat-ward-multiselect li input').removeAttr('checked');
        }
        
        function hitDistrictFun(clickedId){
            const selectedDistricts = [];
            if (clickedId === 'select-all-districts-multiselect') {
                console.log('clickedId',clickedId)
                $('#district-multiselect li input').prop('checked', $(this).prop('checked'));
            } else {
                $('#district-multiselect li input:checked').each(function () {
                    selectedDistricts.push($(this).val());
                });
            }
            getData('district',selectedDistricts)
        
        }
        $('#constituency-multiselect').on('change', 'li input', function () {
            const clickedId = $(this).attr('id');
            const selectedConstituency = [];

            if (clickedId === 'select-all-constituency-multiselect') {
                $('#constituency-multiselect li input').prop('checked', $(this).prop('checked'));
            } else {
                $('#constituency-multiselect li input:checked').each(function () {
                    selectedConstituency.push($(this).val());
                });
            }
        });
        $('#tehsil-multiselect').on('change', 'li input', function () {
            const clickedId = $(this).attr('id');
            console.log('clickedId',clickedId)
            const selectedtehsil = [];

            if (clickedId === 'select-all-tehsil-multiselect') {
                console.log( $('#tehsil-multiselect li input').val())
                $('#tehsil-multiselect li input').prop('checked', $(this).prop('checked'));
            }
        });
        $('#block-town-multiselect').on('change', 'li input', function () {
            const clickedId = $(this).attr('id');
            console.log(clickedId);
            const selectedBlocks = [];

            if (clickedId === 'select-all-block-town-multiselect') {
                $('#block-town-multiselect li input').prop('checked', $(this).prop('checked'));
            }
            $('#block-town-multiselect li input:checked').each(function () {
                selectedBlocks.push($(this).val());
            });
            getData('block', selectedBlocks);
        });
        $('#panchayat-ward-multiselect').on('change', 'li input', function () {
            const clickedId = $(this).attr('id');
            const selectedPanchayat = [];

            if (clickedId === 'select-all-panchayat-ward-multiselect') {
                $('#panchayat-ward-multiselect li input').prop('checked', $(this).prop('checked'));
            } else {
                $('#panchayat-ward-multiselect li input:checked').each(function () {
                    selectedPanchayat.push($(this).val());
                });
            }
        });
        var selectedConstituency = {!! json_encode(request('constituency_id')) !!};
                    console.log('selectedConstituency',selectedConstituency)
                    var selectedTehsil = {!! json_encode(request('tehsil_id')) !!};
                    var selectedBlock = {!! json_encode(request('block_id')) !!};
                    var selectedPanchayat = {!! json_encode(request('panchayat_id')) !!};
        function getData(type, data){
            $.ajax({
                url: "{{ route('get-data-from-districts') }}",
                method: 'POST', // Adjust the method as needed
                data: { type: type, data: data },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                
                    // Handle the response and populate child dropdowns here
                    if(type == 'district'){
                        populateDropdown('constituency-multiselect', response.constituencies, selectedConstituency,'constituency_id[]','constituency-checkbox')
                        populateDropdown('block-town-multiselect', response.blocks, selectedBlock,'block_id[]','block-checkbox')
                        populateDropdown('tehsil-multiselect', response.tehsils, selectedTehsil,'tehsil_id[]','tehsil-checkbox')
                        populateDropdown('panchayat-ward-multiselect', response.panchayatWards, selectedPanchayat,'panchayat_id[]','panchayat-checkbox')
                        resetChecks()
                    }else{
                        populateDropdown('panchayat-ward-multiselect', response.panchayatWards, selectedPanchayat,'panchayat_id[]','panchayat-checkbox')
                        $('#panchayat-ward-multiselect li input').removeAttr('checked');
                    }
                    
                    // console.log(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    });

    $(document).ready(function() {
    function initDatepicker() {
        const datePickerOptions = {
            changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
            dateFormat: 'yy/mm/dd',
            onSelect: function(dateText, inst) {
                const selectedDate = new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay);
                const id = inst.input[0].id;
                if (id === 'startDate') {
                    endDateInput.datepicker('option', 'minDate', selectedDate);
                } else {
                    startDateInput.datepicker('option', 'maxDate', selectedDate);
                }
            },
            onChangeMonthYear: function(year, month, inst) {
                // Update the year selection
                var yearSelect = $('.ui-datepicker-year');
                if (!yearSelect.length) {
                    $('<div class="ui-datepicker-row-break"></div>').insertAfter($('.ui-datepicker-month'));
                    $('<label class="ui-datepicker-year-label">Year:</label>').insertBefore($('.ui-datepicker-month'));
                    yearSelect = $('<select class="ui-datepicker-year"></select>').insertBefore($('.ui-datepicker-month'));
                    yearSelect.on('change', function() {
                        inst.selectedYear = $(this).val();
                        inst.dpDiv.find('.ui-datepicker-year').val(inst.selectedYear);
                        inst.dpDiv.find('.ui-datepicker-close').click();
                    });
                }
                yearSelect.empty();
                var currentYear = new Date().getFullYear();
                for (var i = currentYear; i >= 2019; i--) {
                    yearSelect.append($('<option></option>').attr('value', i).text(i));
                }
            }
        };

        const selectedStartDate = '{{ request()->get('startDate') }}';
        const selectedEndDate = '{{ request()->get('endDate') }}';

        const defaultStartDate = new Date(2019, 3, 1);
        const defaultEndDate = new Date();

        const startDateInput = $('#startDate');
        const endDateInput = $('#endDate');

        // Check if the selected start date is empty, if so, use the default start date
        const startDate = selectedStartDate ? selectedStartDate : defaultStartDate.toLocaleDateString('en-GB');

        // Check if the selected end date is empty, if so, use the default end date
        const endDate = selectedEndDate ? selectedEndDate : defaultEndDate.toLocaleDateString('en-GB');

        // Set the selected start date and end date values to the date inputs
        $('#startDate').val(startDate);
        $('#endDate').val(endDate);

        startDateInput.datepicker(datePickerOptions);
        endDateInput.datepicker(datePickerOptions);
    }

    initDatepicker();
});

</script>