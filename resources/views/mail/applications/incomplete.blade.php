@component('mail::message')
# Application is <small style="color:darkred;">{{ $application->status->name ?? '**' }}</small>

Application for {{ $application->name ?? 'application name' }} is incomplete.

@php($branch = $application->getData('finance', 'bank_branch_id') ? \App\Models\BankBranch::find($application->getData('finance', 'bank_branch_id')) : null)

@component('mail::table')
    | Particular        | Detail         |
    | -------------     | :-------------:|
    | Name              | {{$application->data->enterprise->name ?? ''}}      |
    | Status            | {{ $application->status->name ?? '' }} |
    | Product           | {{ $application->data->enterprise->products ?? '' }} |
    | Constitution Type | {{ $application->data->enterprise->constitution_type_id ?? '' }} |
    | Employment        | {{ $application->data->enterprise->employment ?? '' }} |
    | Mobile            | {{ $application->data->enterprise->mobile ?? $application->data->owner->mobile ?? '' }} |
    | Email             | {{ $application->data->email ?? $application->data->owner->email ?? '' }} |
    | Aadhar            | {{ $application->data->owner->aadhaar ?? '' }} |
    | PAN               | {{ $application->data->owner->pan ?? '' }} |
    | Project Cost      | {{ $application->project_cost ?? '' }} |
    | Bank Detail       | {{ $branch ? "{$branch->bank->name}, {$branch->name} ({$branch->ifsc})" : 'NA' }} |
@endcomponent

@component('mail::button', ['url' => route('application.view', $application->id)])
    View Application
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
