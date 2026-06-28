@props([
    'sortName' => 'sort',
    'directionName' => 'direction',
    'fields' => [],
    'sort' => null,
    'direction' => 'asc',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('sort-control.wrapper')]) }}>
    <select name="{{ $sortName }}" class="{{ $theme->classes('sort-control.select') }}">
        @foreach ($fields as $value => $label)
            <option value="{{ $value }}" @selected((string) $sort === (string) $value)>{{ $label }}</option>
        @endforeach
    </select>

    <select name="{{ $directionName }}" class="{{ $theme->classes('sort-control.select') }}">
        <option value="asc" @selected($direction === 'asc')>오름차순</option>
        <option value="desc" @selected($direction === 'desc')>내림차순</option>
    </select>
</div>
