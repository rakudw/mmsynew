@extends('layouts.admin')

@section('title', $title ?? __("DIC - DH"))

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dic-dh.index') }}">{{ __("Dic - DH") }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('Pending Applications') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Pending Applications') }}</h6>
    </nav>
@endsection

@section('content')
    <div class="col-md-12">
        <x-cards.card>
            <x-cards.header class="px-md-4 py-md-3">
                <h5 class="mb-0">{{ $title ?? __("Pending Applications") }} <a href="{{ route('dashboard.schedule') }}" class="btn btn-primary">Schedule Meeting</a></h5>
            </x-cards.header>
            <x-cards.body>
                @if($meetings && $meetings->count() > 0)
                    <x-table.table class="table table-flush align-items-center">
                        <x-table.head>
                            <x-table.tr>
                                <x-table.th>Id</x-table.th>
                                <x-table.th>Title</x-table.th>
                                <x-table.th>Date Time</x-table.th>
                                <x-table.th>Chairperson</x-table.th>
                                <x-table.th>Updated On</x-table.th>
                                <x-table.th>Status</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.head>
                        <x-table.body>
                            @foreach($meetings as $meeting)
                                <x-table.tr>
                                    <x-table.td class="">
                                        <div class="d-flex align-items-center">
                                            <p class="text-xs font-weight-normal ms-2 mb-0">{{ $meeting->unique_id }}</p>
                                        </div>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal text-wrap">
                                        {{ $meeting->title }}<br /><small>({{ $meeting->applications_count }} Application{{ $meeting->applications_count > 1 ? 's' : '' }})</small>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal text-wrap">
                                        {{ $meeting->datetime ?? '' }}
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal text-wrap">
                                        {{ $meeting->chair_person ?? ''}}
                                    </x-table.td>
                                    <x-table.td class="font-weight-normal">
                                        <span class="my-2 text-xs">{{ $meeting->updated_at ?? $meeting->created_at }}</span>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal text-wrap">
                                        {{$meeting->was_conducted ? 'Proceeded' : 'Not Proceeded'}}
                                    </x-table.td>
                                    <x-table.td class="text-sm text-center">
                                        @if(!$meeting->was_conducted)
                                            <a href="{{ route('dashboard.schedule') }}" data-bs-toggle="tooltip" title="Edit Meeting" class="text-decoration-none">
                                                <em class="material-icons text-secondary position-relative text-lg">edit</em>
                                            </a>
                                        @endif
                                        <a href="{{ route('dashboard.meetings.application', $meeting) }}" data-bs-toggle="tooltip" title="View Applications" class="text-decoration-none">
                                            <em class="material-icons text-secondary position-relative text-lg">visibility</em>
                                        </a>
                                        @if($meeting->was_conducted)
                                            <a href="{{ route('dashboard.minutes', $meeting) }}" data-bs-toggle="tooltip" title="Download Meeting Minutes" class="text-decoration-none text-success">
                                                <em class="material-icons text-secondary position-relative text-lg">groups_2</em>
                                            </a>
                                        @endif
                                        <a href="{{ route('dashboard.agenda', $meeting) }}" data-bs-toggle="tooltip" title="Download Agenda" class="text-decoration-none">
                                            <em class="material-icons text-secondary position-relative text-lg">download</em>
                                        </a>
                                        <a href="{{ route('dashboard.agenda.export', $meeting) }}" data-bs-toggle="tooltip" title="Export Agenda" class="text-decoration-none">
                                            <em class="material-icons text-secondary position-relative text-lg">newspaper</em>
                                        </a>
                                    </x-table.td>
                                </x-table.tr>
                            @endforeach
                        </x-table.body>
                    </x-table.table>
                @else
                    <x-alert :type="'warning'" :message="__('There is no meeting schedule till now.')"></x-alert>
                @endif
            </x-cards.body>
            <x-cards.footer>
                {{ $meetings->links() }}
            </x-cards.footer>
        </x-cards.card>
    </div>
@endsection
