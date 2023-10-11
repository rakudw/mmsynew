<table class="table" id="table">
    <thead>
        <tr>
            <th>Sr. No.</th> {{-- 1 --}}
            <th>ID</th>{{-- 2 --}}
            <th>Status</th>{{-- 3 --}}
            <th>60% Amount Proposed</th>{{-- 14 --}}
            <th>60% Amount Released</th>{{-- 14 --}}
            <th>Date 60% Amount</th>{{-- 14 --}}
            <th>40% Amount Proposed</th>{{-- 14 --}}
            <th>40% Amount Released</th>{{-- 14 --}}
            <th>Date 40% Amount</th>{{-- 14 --}}
            <th>CGTMSE Fee</th>{{-- 14 --}}
            <th>Name</th>{{-- 4 --}}
            <th>District</th>{{-- 5 --}}
            <th>Block</th>{{-- 5 --}}
            <th>Ph. No.</th>{{-- 6 --}}
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
                   {{ isset($application->data->subsidy->amount60) ? $application->data->subsidy->amount60 : 'NA'  }}
                </td>
                <td class="text-left">
                    <?php echo isset($application->data->subsidy->releasedamt60) ? $application->data->subsidy->releasedamt60 : (isset($application->data->subsidy->amount60) ? $application->data->subsidy->amount60 : "NA"); ?>

                </td>
                <td class="text-left">
                    {{ isset($application->data->subsidy->date60) ? $application->data->subsidy->date60 : 'NA'  }}
                 </td>
                <td class="text-left">
                   {{ isset($application->data->subsidy->amount40) ? $application->data->subsidy->amount40 : 'NA'  }}
                </td>
                <td class="text-left">
                    <?php echo isset($application->data->subsidy->releasedamt40) ? $application->data->subsidy->releasedamt40 : (isset($application->data->subsidy->amount40) ? $application->data->subsidy->amount40 : "NA"); ?>

                </td>
                <td class="text-left">
                    {{ isset($application->data->subsidy->date40) ? $application->data->subsidy->date40 : 'NA'  }}
                 </td>
                <td class="text-left">
                    @if ($application->id < 25000)
                        {{ isset($application->data->old_annexure_a->gaa_amount_cgtmse) ? $application->data->old_annexure_a->gaa_amount_cgtmse : 'NA' }}
                    @else
                        {{ isset($application->data->subsidy->cgtmse_fee) ? $application->data->subsidy->cgtmse_fee : 'NA' }}
                    @endif
                
                </td>
                <td class="text-left" title="{{ $application->name  }}">{{ $application->name }}</td>{{-- 4 --}}
                <td class="text-left">{{ $application->getDistrict()->name  }}</td>{{-- 5 --}}
                <td class="text-left">{{ $application->getOwnerBlock()  }}</td>{{-- 5 --}}
                <td class="text-left">{{ $application->getMobileAttribute()  }}</td>{{-- 6 --}}

                
                </td>{{-- 14 --}}
        @endforeach
        
    </tbody>
</table>