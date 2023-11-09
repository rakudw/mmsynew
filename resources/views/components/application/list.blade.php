@props(['applications' => [], 'meeting' => null, 'status' => true, 'selectedApplications' => [], 'page' => 'pendency'])

<x-table.table class="table table-flush align-items-center text-sm">
    <x-table.head>
        <x-table.tr>
            @if(auth()->user()->canScheduleMeeting() && $page == 'schedule')
                <x-table.th>
                    <label>
                        <strong class="text-left">Sr. No.</strong>
                        <div class="form-check d-inline">
                            <input class="form-check-input" type="checkbox" id="customCheckMulti" />
                        </div> 
                    </label>
                </x-table.th>
            @else
                <x-table.th>Sr. No.</x-table.th>
            @endif
            <x-table.th>Enterprise</x-table.th>
            <x-table.th>Applicant</x-table.th>
            <x-table.th>Subsidy Eligibility<hr class="m-0" />Subsidy Category</x-table.th>
            <x-table.th>Investment / Project Cost</x-table.th>
            <x-table.th>Bank</x-table.th>
            @if($status)
                <x-table.th>Status</x-table.th>
            @endif
            <x-table.th>Last Action Time</x-table.th>
            <x-table.th>Actions</x-table.th>
        </x-table.tr>
    </x-table.head>
    <x-table.body>
        @forelse($applications as $index => $application)
            <x-table.tr>
                @if(auth()->user()->canScheduleMeeting() && $page == 'schedule')
                    @php($applicationMeeting = $meeting ? $application->meetingApplications()->where('meeting_id', $meeting->id)->orderBy('created_at', 'desc')->first() : null)
                    @if(!$applicationMeeting || ($applicationMeeting->status == \App\Enums\MeetingApplicationStatusEnum::PENDING->value))
                        <x-table.td>
                            {{ $index + 1 }}
                        </x-table.td>
                        <x-table.td>
                            <div class="d-flex align-items-center">
                                <label>
                                    <div class="form-check d-inline">
                                        <input class="form-check-input" name="applications[]" value="{{$application->id}}" type="checkbox" id="customCheck{{$application->id}}" @checked(in_array($application->id, $selectedApplications)) />
                                    </div>
                                    {{ $application->unique_id }}
                                </label>
                            </div>
                        </x-table.td>
                    @else
                        <x-table.td colspan="2">
                            {{ $application->unique_id }}
                        </x-table.td>
                    @endif
                @else
                    <x-table.td>
                        {{ $application->unique_id }}
                    </x-table.td>
                @endif
                <x-table.td class="font-weight-normal text-wrap">
                    M/s {{ $application->getData('enterprise', 'name') }}<br />{{ $application->address }}
                </x-table.td>
                <x-table.td class="font-weight-normal text-wrap">
                    {{ $application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '') }} {{ $application->getData('owner', 'name') }}
                    <br />
                    <em class="fa fa-phone"></em>
                    <a href="tel:{{ $application->getData('owner', 'mobile') }}">{{ $application->getData('owner', 'mobile')}}</a>
                    @if($application->getData('owner', 'email'))
                        <br />
                        <em class="fa fa-envelope"></em>
                        <a href="emailto:{{ $application->getData('owner', 'email') }}">{{ $application->getData('owner', 'email')}}</a>
                    @endif
                    <hr />
                    {{ $application->activity }}
                </x-table.td>
                <x-table.td class="font-weight-normal text-wrap">
                    <p class="text-end m-0">{{ $application->subsidy_percentage }}%</p>
                    <hr class="m-0" />
                    @php($categoryShown = false)
                    @foreach($application->getCategories() as $category => $info)
                        @if($info['eligible'] > 0)
                            @php($categoryShown = true)
                            <span class="badge badge-sm bg-gradient-success">{{ $application->isAFirm() ? ($info['eligible'] == $info['total'] ? '' : round(($info['eligible'] / $info['total']) * 100) . '% ') : '' }}{{ $category }}</span>
                        @endif
                    @endforeach
                    @if(!$categoryShown)
                        <span class="badge badge-sm bg-gradient-success">General</span>
                    @endif
                </x-table.td>
                <x-table.td class="font-weight-normal text-center">
                    {{ $pageVars['formatter']->format($application->own_contribution_amount) }} / {{ $pageVars['formatter']->format($application->project_cost) }}
                </x-table.td>
                <x-table.td class="font-weight-normal text-wrap">
                    {{ $application->bank_branch_details }}
                </x-table.td>
                @if($status)
                    <x-table.td class="font-weight-normal text-wrap">
                        <x-spans.status :status="$application->application_status">
                            {{ $application->application_status ? $application->application_status->value : 'NA' }}
                        </x-spans.status>
                    </x-table.td>
                @endif
                <x-table.td class="font-weight-normal">
                    <span class="my-2">{{ $application->status_updated_at }}</span>
                </x-table.td>
                <x-table.td class="text-center">
                    <a href="{{ route('application.view', $application->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Preview Application" class="text-decoration-none">
                        <em class="material-icons text-secondary position-relative">visibility</em>
                    </a>
                    @can('update', $application)
                        <a href="{{ route('application.edit', $application->id) }}" class="mx-3 text-decoration-none" data-bs-toggle="tooltip" title="Edit Application" data-bs-original-title="Edit Application">
                            <em class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</em>
                        </a>
                    @endif
                    {{-- @can('delete', $application)
                        <a href="{{ route('application.withdraw', $application->id) }}" data-bs-toggle="tooltip" title="Withdraw Application" data-bs-original-title="Withdraw Application" class="text-decoration-none">
                            <em class="material-icons text-secondary position-relative text-lg">delete</em>
                        </a>
                    @endif --}}
                </x-table.td>
            </x-table.tr>
        @empty
            <tr>
                <td colspan="{{ $status ? 9 : 8}}" class="alert alert-warning text-center">No application to show here! <a href="{{ route('application.create', 1) }}">Create new</a></td>
            </tr>
        @endforelse
    </x-table.body>
</x-table.table>