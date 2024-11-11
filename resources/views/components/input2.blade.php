<tr>
    <th>(1)</th>
        <th >
            @if (!property_exists($element, 'noLabel') || $element->noLabel == false)
                <strong for="{{ $element->attributes->name }}Element" class="form-label">{{ $element->label }} {{property_exists($element->attributes, 'required') ? '*' : '' }}</strong>
            @endif
        </th>
    <td colspan="4">
        <input {!!property_exists($element->attributes, 'type') ? '' : ' type="text"'!!}
            value="{{ old($element->attributes->name, $application->getData($design->slug, $element->attributes->name, property_exists($element, 'default') ? $element->default : null )) }}"
            class=""
            {!! $attributes->build($element->attributes) !!} />
        @if (property_exists($element, 'helpText'))
        <small>{{ $element->helpText }}</small>
        @endif
        @if (property_exists($element, 'helpHtml'))
            {!! $element->helpHtml !!}
        @endif
        @error($element->attributes->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
     </td>
</tr>
