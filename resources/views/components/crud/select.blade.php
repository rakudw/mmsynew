<div class="mb-3 col-md-{{ property_exists($element, 'width') ? $element->width : 6 }}">
    @php
        $oldData = old($element->attributes->name, $model->{$element->attributes->name});
    @endphp
    @if(!property_exists($element, 'noLabel') || $element->noLabel == false)
        <label for="{{ $element->attributes->name }}_element">{{ $element->label }} {{property_exists($element->attributes, 'required') ? '*' : '' }}</label><br />
    @endif
    <div class="input-group input-group-outline my-3">
        <select data-value="{{ $oldData }}" class="form-control @error($element->attributes->name) is-invalid @else is-valid @enderror @if(property_exists($element->attributes, 'class')) {{ $element->attributes->class }} @endif" {!! $attributes->build($element->attributes) !!} >
            @if(property_exists($element, 'showChoose'))
                <option value="">--- ALL ---</option>
            @endif
            @foreach($attributes->buildOptions($element, $model) as $key => $value)
                <option value="{{ $key }}" @selected($key == $oldData)>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    @if(property_exists($element, 'helpText'))
        <small>{{ $element->helpText }}</small>
    @endif
    @if(property_exists($element, 'helpHtml'))
        {!! $element->helpHtml !!}
    @endif
    @error($element->attributes->name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>