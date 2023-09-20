@props(['application', 'name', 'actions'])

<x-forms.label for="applicationStatus" value="{{ $currentStatus ?? __('Take Action') }}" />
<x-forms.select id="applicationStatus" name="{{ $name }}" required="required" :showChoose="count($actions) > 1">
    @foreach($actions as $status => $action)
        <option value="{{ $status }}" @selected(old($name) == $status)>{{ $action }}</option>
    @endforeach
</x-forms.select>
<x-forms.input-error for="applicationStatus" class="mt-2" />
