@props([
    'name',
    'label' => '파일 선택',
    'help' => null,
    'accept' => null,
    'multiple' => false,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<label {{ $attributes->merge(['class' => $theme->classes('file-upload.container')]) }}>
    <x-laravel-admin::admin.icon name="file-lines" class="{{ $theme->classes('file-upload.icon') }}" />
    <span class="{{ $theme->classes('file-upload.label') }}">{{ $label }}</span>

    @if ($help)
        <span class="{{ $theme->classes('file-upload.help') }}">{{ $help }}</span>
    @endif

    <input type="file" name="{{ $name }}" class="sr-only" @if ($accept) accept="{{ $accept }}" @endif @if ($multiple) multiple @endif>
</label>
