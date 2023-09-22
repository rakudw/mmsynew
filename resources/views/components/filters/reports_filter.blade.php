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
                <select class="form-control" title="{{ request()->get('status_id') }}" name="status_id" id="status-id">
                    <option value="">-- All --</option>
                    @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                        @if(in_array($status->id(), $statusId))
                            <option value="{{ $status->id() }}" @selected(request()->get('status_id') == $status->id())>{{ $status->value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-md-2">
            <label class="form-label">Select FY</label>
            <select class="form-control fy" title="{{ request()->get('fy') }}" name="fy" id="status-id">
                <option value="All">-- All --</option>
                <option value="2023-2024" @selected(request()->get('fy') == '2023-2024')>2023-2024</option>
                <option value="2022-2023" @selected(request()->get('fy') == '2022-2023')>2022-2023</option>
                <option value="2021-2022" @selected(request()->get('fy') == '2021-2022')>2021-2022</option>
                <option value="2020-2021" @selected(request()->get('fy') == '2020-2021')>2020-2021</option>
            </select>
        </div>
        @if(auth()->user()->isSuperAdmin())
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
        </div>
</form>

<script>
    // JavaScript to handle custom multiselect
    $(document).ready(function () {
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
        const selectedFYValue = $('.fy').val();

        // Push the selectedStatusValue into the queryParams array as status_id
        if (selectedStatusValue) {
            queryParams.push(`status_id=${encodeURIComponent(selectedStatusValue)}`);
        }
        // Push the selectedFYValue into the queryParams array as fy
        if (selectedFYValue) {
            queryParams.push(`fy=${encodeURIComponent(selectedFYValue)}`);
        }
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

</script>