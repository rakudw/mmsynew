<div class="mb-3 col-md-{{ property_exists($element, 'width') ? $element->width : 6 }}">
    <label>&nbsp;</label>
    <div class="input-group input-group-outline my-3">
        @if (!property_exists($element, 'noLabel') || $element->noLabel == false)
            <label for="{{ $element->attributes->name }}Element" class="form-label">{{ $element->label }} {{property_exists($element->attributes, 'required') ? '*' : '' }}</label>
        @endif
        <input {!!property_exists($element->attributes, 'type') ? '' : ' type="text"'!!}
            value="{{ old($element->attributes->name, $application->getData($design->slug, $element->attributes->name, property_exists($element, 'default') ? $element->default : null )) }}"
            class="form-control @error($element->attributes->name) is-invalid @else is-valid @enderror @if (property_exists($element->attributes, 'class')) {{ $element->attributes->class }} @endif"
            {!! $attributes->build($element->attributes) !!} />
    </div>
    @if (property_exists($element, 'helpText'))
        <small>{{ $element->helpText }}</small>
    @endif
    @if (property_exists($element, 'helpHtml'))
        {!! $element->helpHtml !!}
    @endif
    @error($element->attributes->name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
