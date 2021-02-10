@props(['value'])

<label {{ $attributes->merge(['class' => 'col-xl-2 col-sm-3 col-sm-2 col-form-label']) }}>
    {{ $value ?? $slot }}
</label>
