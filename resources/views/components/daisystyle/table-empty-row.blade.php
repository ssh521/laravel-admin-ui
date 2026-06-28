@props([
    'colspan' => 1,
    'message' => '표시할 항목이 없습니다.',
])

<tr>
    <td colspan="{{ $colspan }}" {{ $attributes->merge(['class' => 'px-4 py-16 text-center text-sm text-base-content/60']) }}>
        {{ $message }}
    </td>
</tr>
