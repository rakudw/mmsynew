@switch($element->type)
    @case('group')
        <div class="card">
            @if (property_exists($element, 'title') && !empty($element->title))
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        {{ $element->title }}
                    </h5>
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    @foreach($element->body as $child)
                        <x-element :application="$application" :design="$design" :form="$form" :element="$child" />
                    @endforeach
                </div>
            </div>
        </div>
        @break
    @case('input')
        <x-input :application="$application" :design="$design" :form="$form" :element="$element" />
        @break
    @case('select')
        <x-select :application="$application" :design="$design" :form="$form" :element="$element" />
        @break
    @case('html')
        {!! $element->content !!}
        @break
    @case('view')
        @include ($element->name)
        @break
    @default
        <h3 class="text-danger">{{ $element->type }}</h3>
@endswitch