@props([
    'type' => 'text',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
    $fieldName = $attributes->get('name');
    $fieldId = $attributes->get('id');
    $hasError = isset($errors) && $fieldName && $errors->has($fieldName);
    $accessibilityAttributes = $hasError
        ? array_filter([
            'aria-invalid' => 'true',
            'aria-describedby' => $fieldId ? $fieldId.'-error' : null,
        ])
        : [];
@endphp

<input
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $theme->classes('form.input')])->merge($accessibilityAttributes) }}
>
