@props([
    'colspan' => 1,
    'message' => '표시할 항목이 없습니다.',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<tr>
    <td colspan="{{ $colspan }}" {{ $attributes->merge(['class' => $theme->classes('table-empty-row.cell')]) }}>
        {{ $message }}
    </td>
</tr>
