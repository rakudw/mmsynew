@extends('layouts.admin')

@section('content')
@php
$type = request()->route()->parameter('type');
$step = request()->route()->parameter('step');
$isPending = ($type == 'pending');
$isStep60Or40 = ($step == '60' || $step == '40');
$notPendingNotRejected = ($type == 'pending' || $type == 'rejected');
@endphp

<div class="row align-items-center master_report">
    <h3>{{ $title }}</h3>
    <div class="col-md-12">
        <x-cards.card>
            <x-cards.header class="px-md-4 py-md-3">
                <div class="row">
                    <x-filters.reports_filter :statusId="$statusId" :constituencies="$constituencies" :districts="$districts" :tehsils="$tehsils" :blocks="$blocks" :panchayatWards="$panchayatWards"> 
                    </x-filters.reports_filter> 
                </div>
            </x-cards.header>
            <x-cards.body>
                <div class="col-md-12">
                    <div class="card mb-3">
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th> {{-- 1 --}}
                                    <th>ID</th>{{-- 2 --}}
                                    <th>Status</th>{{-- 3 --}}
                                    <th>Name & Address</th>{{-- 4 --}}
                                    <th>Block</th>{{-- 5 --}}
                                    <th>Ph. No.</th>{{-- 6 --}}
                                    <th>Activity</th>{{-- 7 --}}
                                    <th>Category</th>{{-- 8 --}}
                                    <th>CIS @ of</th>{{-- 9 --}}
                                    @if ($isStep60Or40 && !$notPendingNotRejected)
                                        <th>Total cost Approved in DLC</th>{{-- 10 --}}
                                    @endif
                                    @if (!$notPendingNotRejected)
                                        <th>Term Loan</th>{{-- 11 --}}
                                    @endif
                                    @if (!$notPendingNotRejected && $isStep60Or40)
                                        <th>60% CIS</th>{{-- 12 --}}
                                    @endif
                                    
                                    @if ($step == '40' && !$notPendingNotRejected)
                                        <th>40% CIS</th>{{-- 13 --}}
                                    @endif
                                    
                                    @if (!$notPendingNotRejected && $step == '40')
                                        <th>100% CGTMSE</th>{{-- 14 --}}
                                    @endif
                                    @if ($isStep60Or40 && !$isPending)
                                        <th>Total</th>{{-- 15 --}}
                                    @endif
                                    <th>Emp</th>{{-- 16 --}}
                                    <th>Bank</th>{{-- 17 --}}
                                    @if ($isStep60Or40 && !$notPendingNotRejected)<th>Date of forwarding to Nodal Bank</th> @endif {{-- 18 --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $key => $application)
                                @php
                                    $srNo = $key + 1 + ($applications->perPage() * ($applications->currentPage() - 1));
                                @endphp
                                {{-- @php dd($application->data); @endphp --}}
                                    <tr>
                                        <td class="text-left">{{ $srNo }}</td>{{-- 1 --}}
                                        <td class="text-left" title="{{ $application->unique_id }}"> {{ $application->unique_id }}</td>{{-- 2 --}}
                                        <td class="text-left" title="{{ $application->application_status ? $application->application_status->value : 'NA' }}">{{ $application->application_status ? $application->application_status->value : 'NA' }}</td>{{-- 3 --}}
                                        <td class="text-left" title="{{ $application->getOwnerAddressAttribute()  }}">{{ $application->getOwnerAddressAttribute() }}</td>{{-- 4 --}}
                                        <td class="text-left">{{ $application->getOwnerBlock()  }}</td>{{-- 5 --}}
                                        <td class="text-left">{{ $application->getMobileAttribute()  }}</td>{{-- 6 --}}
                                        <td class="text-left" title="{{ $application->getActivityAttribute() != '[]' ? $application->getActivityAttribute() : $application->activity_type->value  }}">{{ $application->getActivityAttribute() != '[]' ? $application->getActivityAttribute() : $application->activity_type->value  }}</td>{{-- 7 --}}
                                        <td class="text-left">{{ $application->social_category->value }}</td>{{-- 8 --}}
                                        <td class="text-left">{{ $application->subsidy_percentage }}%</td>{{-- 9 --}}

                                        @if ($isStep60Or40 && !$notPendingNotRejected)<td class="text-left">{{ $application->getSubsidyEligibleAmountAttribute() }}</td>@endif{{-- 10 --}}
                                        @if (!$notPendingNotRejected)
                                            <td class="text-left">
                                                {{ $application->getTermLoanAttribute() }}  
                                            </td>{{-- 11 --}}
                                        @endif
                                        
                                        @if (!$notPendingNotRejected && $isStep60Or40)
                                            <td class="text-left">{{ optional($application->data->subsidy)->amount60 ?? 'NA' }} </td>{{-- 12 --}}
                                        @endif
                                        
                                        @if ($step == '40' && !$notPendingNotRejected)
                                            <td class="text-left">{{ optional($application->data->subsidy)->amount40 ?? 'NA' }}</td>{{-- 13 --}}
                                        @endif
                                        
                                        @if (!$notPendingNotRejected && $step == '40')
                                            <td class="text-left">14405.44</td>{{-- 14 --}}
                                        @endif
                                        @if ($isStep60Or40 && !$isPending)
                                            <td class="text-left">{{ $application->getProjectCostAttribute() }}</td>{{-- 15 --}}
                                        @endif
                                        <td class="text-left">{{ $application->getData('enterprise', 'employment') }}</td>{{-- 16 --}}
                                        <td class="text-left" title="{{ $application->bank_branch_details }}">{{ $application->bank_branch_details }}</td>{{-- 17 --}}
                                        @if ($isStep60Or40 && !$notPendingNotRejected)
                                            <td class="text-left">{{ $step == '40' ? optional($application->data->subsidy)->date40 ?? 'NA' : optional($application->data->subsidy)->date60 ?? 'NA' }}</td>{{-- 13 --}}
                                        @endif
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                       
                    </div>
                </div>
            </x-cards.body>
            <x-cards.footer>
                    {!! $applications->links() !!}
            </x-cards.footer>
        </x-cards.card>
    </div>
</div>
@endsection
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css"/>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer="defer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js" defer="defer"></script>


<script type="text/javascript">
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

    $(document).ready(function () {
        debugger;
        $('#table').DataTable({
            scrollX:true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            scrollY: '60vh', // Adjust the height as needed
            scrollCollapse: true,
            fixedHeader: true,
            "paging": false,
            "language": {
                "info": "" // Remove or customize the information text
            }
        })

    });
</script>
