@props([
    'groups' => [],
    'name' => 'permissions',
    'selected' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('permission-matrix.container')]) }}>
    @foreach ($groups as $group => $permissions)
        <section class="{{ $theme->classes('permission-matrix.group') }}">
            <h3 class="{{ $theme->classes('permission-matrix.title') }}">{{ $group }}</h3>
            <div class="{{ $theme->classes('permission-matrix.grid') }}">
                @foreach ($permissions as $value => $label)
                    <label class="{{ $theme->classes('permission-matrix.item') }}">
                        <input type="checkbox" name="{{ $name }}[]" value="{{ $value }}" @checked(in_array($value, $selected, true))>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </section>
    @endforeach

    {{ $slot }}
</div>
