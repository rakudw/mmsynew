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
    <x-forms.form-section action="{{ route('dashboard.applications.status', $meeting) }}" id="applicationStatus" class="my-3" method="PUT">
        <div class="col-12 my-3">
            <x-slot name="title">
                {{ $meeting->title }}
            </x-slot>
            <x-slot name="description">
                <strong>Chair Person:</strong> {{ $meeting->chair_person }} - <strong>Time:</strong> {{ substr($meeting->datetime, 0, 16) }}
            </x-slot>
            <x-slot name="form">
                <div class="col-md-12 mb-3">
                    <x-application.list :meeting="$meeting" page="schedule" :applications="$meeting->applications" :status="false" />
                </div>
                @if(auth()->user()->isGm() && ($meeting->applications->count() > 0) && !$meeting->was_conducted && ($meeting->datetime < date('Y-m-d H:i:s')))
                    <div class="col-md-6 px-lg-3 px-2 pt-3">
                        <x-forms.label for="remark">&nbsp;</x-forms.label>
                        <select name="status" class="form-control">
                            <option value="">--Choose--</option>
                            <option value="{{ \App\Enums\ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id() }}">Approve</option>
                            <option value="{{ \App\Enums\ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id() }}">Reject</option>
                            <option value="{{ \App\Enums\ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id() }}">Defer</option>
                        </select>
                    </div>
                    <div class="col-md-6 px-lg-3 px-2 pt-3">
                        <x-forms.label for="remark">Remark</x-forms.label>
                        <x-forms.textarea id="comment" name="comment" rows="2" placeholder="You can enter comment here">{{ old('comment') ?? '' }}</x-forms.textarea>
                    </div>
                    <div class="col-md-12 justify-content-end">
                        <x-forms.button :type="'submit'">Update</x-forms.button>
                    </div>
                @endif
            </x-slot>
        </div>
    </x-forms.form-section>
@endsection
