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
<style>
    #status-id
    {
      background-color: #EC407A !important;
      border: 1px solid #EC407A !important;
    }
    button.btn.btn-info.dropdown-toggle
    {
      background-color: #EC407A !important; 
      border: 1px solid #EC407A !important; 
    }
    #status-id option,ul#district-multiselect,ul#constituency-multiselect,ul#tehsil-multiselect,ul#block-town-multiselect,ul#panchayat-ward-multiselect
    {
    width: 100% !important;
    background-color: #66BB6A !important;  
    overflow-x: hidden;
    } 

    button.dt-button.buttons-copy.buttons-html5,.buttons-csv.buttons-html5,.buttons-excel.buttons-html5,.buttons-pdf.buttons-html5,.buttons-print
    {
    background-color: #66BB6A !important;  
    border: 1px solid #66BB6A !important;
    border-radius: 4px !important;
    padding: 5px !important;
    color: #fff !important;
    text-transform: uppercase;   
    }
    input[type="search"]
    {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    appearance: none;
    border-radius: 0.375rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    label.dropdown-item
    {
    color: #fff;
    }
    ::-webkit-scrollbar 
    {
     width: 10px;
    }


::-webkit-scrollbar-track
 {
  background: #f1f1f1; 
 }

::-webkit-scrollbar-thumb 
{
  background: #EC407A; 
}
::-webkit-scrollbar-thumb:hover 
{
  background: #EC407A; 
}
</style>
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
