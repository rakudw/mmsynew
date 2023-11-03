@props(['type'=>'button'])
<button {{ $attributes->merge(['type' => $type, 'class' => 'btn bg-gradient-primary mb-0 ms-lg-auto me-lg-0 me-auto', 'id' => 'submitButton']) }}>
    {{ $slot }}
</button>
