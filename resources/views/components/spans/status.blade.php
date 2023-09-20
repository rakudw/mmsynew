@props(['status', 'type' => ''])
@php
    if (in_array($status, ['Incompleted', 'Reverted Back to Applicant', 'Withdrawn'])) {
        $type = 'rotate-left';
        $class = 'secondary';
    } elseif (Illuminate\Support\Str::contains(strtolower($status->value), 'reject')) {
        $type = 'xmark';
        $class = 'danger';
    } elseif (Illuminate\Support\Str::contains(strtolower($status->value), 'pending')) {
        $type = 'circle-exclamation';
        $class = 'primary';
    } else {
        $type = 'circle-check';
        $class = 'success';
    }
@endphp
<div class="d-flex align-items-center">
    <span class="badge badge-sm bg-gradient-{{ $class }}">
        <i class="fa-solid fa-{{ $type }}" aria-hidden="true"></i>
        {{ $status->value }}
    </span>
</div>
