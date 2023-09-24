@switch($element->type)
    @case('group')
                                
                    @foreach($element->body as $child)
                        <x-element2 :application="$application" :design="$design" :form="$form" :element="$child" />
                    @endforeach
        @break
    @case('input')
    
        <x-input2 :application="$application" :design="$design" :form="$form" :element="$element" />
        @break
    @case('select')
        <x-select2 :application="$application" :design="$design" :form="$form" :element="$element" />
        @break
@endswitch