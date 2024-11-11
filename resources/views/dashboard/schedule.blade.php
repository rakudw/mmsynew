@extends('layouts.admin')

@section('title', $title ?? 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('Dashboard') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Dashboard') }}</h6>
    </nav>
@endsection
@section('content')
    @php($isGm = auth()->user()->isGm())
    <form action="{{ route('schedule.meeting') }}" method="post" class="row align-items-center">
        @csrf
        @if($pendingApplications->count() > 0)
            <div class="col-md-12">
                <x-cards.card>
                    <x-cards.header class="px-md-4 py-md-3">
                        <h5 class="mb-0">Schedule DLC Meeting</h5>
                    </x-cards.header>
                    <x-cards.body>
                        <x-application.list :applications="$pendingApplications" page="schedule" :meeting="$meeting" :status="false" :selectedApplications="$selectedApplications" />
                    </x-cards.body>
                </x-cards.card>
            </div>
            <x-forms.mark>
                <x-slot name="title">
                    {{ __('Create Agenda Meeting') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('Here you can create Agenda Meeting in bulk') }}
                </x-slot>
                <x-slot name="form">
                    @if($meeting)
                        <input type="hidden" name="id" value="{{ $meeting->id }}" />
                    @endif
                    <div class="row mt-4">
                        <div class="col-12 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">{{ __('Title') }}</x-forms.label>
                                <x-forms.input type="text" required="required" name="title" class="form-control w-100" value="{{ $meeting ? $meeting->title : '' }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">{{ __('Specify Meeting Date') }}</x-forms.label>
                                <x-forms.input type="date" required="required" name="date" data-datepicker-xmin-date="-1" class="form-control w-100" aria-describedby="dateHelp" value="{{ $meeting ? substr($meeting->datetime, 0, 10) : '' }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Specify Meeting Time</x-forms.label>
                                <x-forms.input type="time" required="required" name="time" class="form-control w-100" value="{{ $meeting ? substr($meeting->datetime, 11, 5) : '' }}" />
                            </x-forms.input-group>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mt-3 mt-sm-0">
                            <x-forms.input-group :dynamic="true">
                                <x-forms.label class="form-label">Chairman</x-forms.label>
                                <x-forms.input type="text" required="required" name="chair_person" class="form-control w-100" value="{{ $meeting ? $meeting->chair_person : '' }}" />
                            </x-forms.input-group>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <x-forms.label class="mt-4" for="remark">Remark</x-forms.label>
                            <textarea class="form-control w-100" id="remarks" rows="2" name="remarks" placeholder="Remark is optional or you can explain about meeting...">{{ $meeting ? $meeting->remarks : '' }}</textarea>
                            <p class="form-text text-muted text-xs ms-1 d-inline">(optional)</p>
                        </div>
                        <div class="col-md-12 justify-content-end">
                            <x-forms.button :type="'submit'">{{ $meeting ? 'Update Meeting Applications' : 'Schedule Applications for Meeting' }}</x-forms.button>
                        </div>
                    </div>
                </x-slot>
            </x-forms.mark>
        @else
            <x-alert :message="'No application to show yet!'" :type="'danger'"/>
        @endif
    </form>

@endsection
