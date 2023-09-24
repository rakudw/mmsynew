<tr>
    @php
        $oldData = old($element->attributes->name, $application->getData($design->slug, $element->attributes->name, property_exists($element, 'default') ? $element->default : null));
    @endphp
    <th>(3)</th>
    <th >
        @if(!property_exists($element, 'noLabel') || $element->noLabel == false)
            <strong for="{{ $element->attributes->name }}_element">{{ $element->label }} {{property_exists($element->attributes, 'required') ? '*' : '' }}</strong>
        @endif
    </th>
    <td colspan="4">
        <select data-value="{{ $oldData }}" class="button" {!! $attributes->build($element->attributes) !!} >
            @foreach($attributes->buildOptions($element) as $key => $value)
                <option value="{{ $key }}" @selected($key == $oldData)>{{ $value }}</option>
            @endforeach
        </select>
        @if(property_exists($element, 'helpText'))
        <small>{{ $element->helpText }}</small>
        @endif
        @if(property_exists($element, 'helpHtml'))
            {!! $element->helpHtml !!}
        @endif
        @error($element->attributes->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </td>
</tr>