@php($slug = \Illuminate\Support\Str::slug($title))

<div class="tab-pane fade {{ $isActive ? 'active show ': '' }}" id="{{$slug}}" role="tabpanel" aria-labelledby="{{$slug}}-tab">
    {{ $slot ?? '' }}
</div>
