<div class="table-responsive">
    <table {{ $attributes->merge(['id' => '', 'class' => '' ]) }}>
        {{ $slot }}
    </table>
</div>
