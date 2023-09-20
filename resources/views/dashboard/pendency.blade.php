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
    <div class="nav-wrapper position-relative end-0">
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-3" role="tablist">
                @foreach ($pendencyStatuses as $status)
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 {{ $status->id() == $statusId ? 'active' : '' }}"
                            href="{{ route('dashboard.pendency', ['statusId' => $status->id()]) }}"
                            role="tab" aria-selected="{{ $status->id() == $statusId ? 'true' : 'false' }}">
                            <span class="material-icons align-middle mb-1">
                                badge
                            </span>
                            @if($status->id() == $statusId)
                                <strong>{{ $status->value }}</strong>
                            @else
                                {{ $status->value }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <form action="{{ route('schedule.meeting') }}" method="post" class="row align-items-center">
        @csrf
        <div class="col-md-12">
            @if($pendingApplications->count())
                <x-cards.card>
                    <x-cards.header class="px-md-4 py-md-3">
                        @if($pendingApplications[0]->application_status == \App\Enums\ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS)
                            <h5 class="mb-0">New Applications {{ __($pendingApplications[0]->application_status->value) }}</h5>
                        @elseif($pendingApplications[0]->application_status == \App\Enums\ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT)
                            <h5 class="mb-0">Approved Applications by DLC, {{ __($pendingApplications[0]->application_status->value) }}</h5>
                        @else
                            <h5 class="mb-0">{{ __($pendingApplications[0]->application_status->value) }}</h5>
                        @endif
                    </x-cards.header>
                    <x-cards.body>
                        <x-application.list :applications="$pendingApplications" :status="false" :selectedApplications="$selectedApplications" />
                    </x-cards.body>
                    <x-cards.footer>
                        {{ $pendingApplications->links() }}
                    </x-cards.footer>
                </x-cards.card>
            @else
                <div class="alert alert-primary text-light" role="alert">
                    <h4 class="alert-heading">Congratulations</h4>
                    None of the applications are waiting for you here.
                </div>
            @endif
        </div>
    </form>

@endsection
