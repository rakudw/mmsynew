@props(['id', 'disabled' => false, 'showChoose' => true])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control', 'id' => $id]) !!}>
    @if($showChoose)
        <option selected value="">--Choose--</option>
    @endif
    {{ $slot }}
</select>
