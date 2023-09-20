@component('mail::message')
# Application Status has been changed to <small style="color:green;">{{ $application->status->name ?? '**' }}</small>

Application for {{ $application->name ?? 'application name' }} has been updated.

@component('mail::table')
    | Particular        | Detail         |
    | -------------     | :-------------:|
    | Name              | {{ $application->data->enterprise->name ?? '' }}      |
    | Status            | {{ $application->status->name }} |
    | Activity/Product  | {{ $application->activity }} |
    | Constitution Type | {{ $application->constitution_type->value }} |
    | Employment        | {{ $application->data->enterprise->employment ?? '' }} |
    | Mobile            | {{ $application->getData('owner', 'mobile') }} |
    | Email             | {{ $application->getData('owner', 'email') }} |
    | Aadhar            | {{ $application->getData('owner', 'aadhaar') }} |
    | PAN               | {{ $application->getData('owner', 'pan') }} |
    | Own Contribution  | ₹ {{ number_format($application->own_contribution_amount) }} |
    | Project Cost      | ₹ {{ number_format($application->project_cost) }} |
    | Bank Detail       | {{ $application->bank_branch_details }} |
@endcomponent

@component('mail::button', ['url' => route('application.view', $application->id)])
View Application
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
