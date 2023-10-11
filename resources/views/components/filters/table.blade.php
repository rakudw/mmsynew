<table class="table" id="table">
    <thead>
        <tr>
            <th>Sr. No.</th> {{-- 1 --}}
            <th>ID</th>{{-- 2 --}}
            <th>Status</th>{{-- 3 --}}
            <th>CGTMSE Fee</th>{{-- 14 --}}
            <th>Name & Address</th>{{-- 4 --}}
            <th>Block</th>{{-- 5 --}}
            <th>Ph. No.</th>{{-- 6 --}}
            <th>Category</th>{{-- 8 --}}
            <th>CIS @ of</th>{{-- 9 --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($applications as $key => $application)
        @php
            $srNo = $key + 1 + ($applications->perPage() * ($applications->currentPage() - 1));
        @endphp
        {{-- @php dd($application->data); @endphp --}}
            <tr>
                <td class="text-center"><b>{{ $srNo }}<b></td>{{-- 1 --}}
                <td class="text-left" title="{{ $application->unique_id }}"><a href="/application/view/{{ $application->id }}"> {{ $application->unique_id }}</a></td>{{-- 2 --}}
                <td class="text-left" title="{{ $application->application_status ? $application->application_status->value : 'NA' }}">{{ $application->application_status ? $application->application_status->value : 'NA' }}</td>{{-- 3 --}}
                <td class="text-left">
                @if ($application->id < 25000)
                    {{ isset($application->data->old_annexure_a->gaa_amount_cgtmse) ? $application->data->old_annexure_a->gaa_amount_cgtmse : 'NA' }}
                @else
                    {{ isset($application->data->subsidy->cgtmse_fee) ? $application->data->subsidy->cgtmse_fee : 'NA' }}
                @endif
                
                </td>
                <td class="text-left" title="{{ $application->getOwnerAddressAttribute()  }}">{{ $application->getOwnerAddressAttribute() }}</td>{{-- 4 --}}
                <td class="text-left">{{ $application->getOwnerBlock()  }}</td>{{-- 5 --}}
                <td class="text-left">{{ $application->getMobileAttribute()  }}</td>{{-- 6 --}}
                <td class="text-left">{{ $application->social_category->value }}</td>{{-- 8 --}}
                <td class="text-left">{{ $application->subsidy_percentage }}%</td>{{-- 9 --}}

                
                </td>{{-- 14 --}}
        @endforeach
        
    </tbody>
</table>