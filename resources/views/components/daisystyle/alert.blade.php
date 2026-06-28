@props(['type' => 'info', 'message' => null, 'dismissible' => false])

@php
    $variantClasses = [
        'success' => 'alert-success',
        'error' => 'alert-error',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ][$type] ?? 'alert-info';

    $typeLabels = [
        'success' => '[성공] ',
        'error' => '[오류] ',
        'warning' => '[경고] ',
        'info' => '[정보] ',
    ];

    $label = $typeLabels[$type] ?? $typeLabels['info'];
@endphp

@if($message)
    <div {{ $attributes->merge(['class' => trim("alert {$variantClasses}")]) }} role="alert" @if($dismissible) x-data="{ show: true }" x-show="show" @endif>
        <div class="flex w-full items-center justify-between gap-3">
            <div>
                <span class="font-semibold">{{ $label }}</span> {{ $message }}
            </div>

            @if($dismissible)
                <button type="button" class="btn btn-ghost btn-xs" @click="show = false">
                    <span class="sr-only">닫기</span>
                    <x-laravel-admin::admin.icon name="xmark" class="size-3" />
                </button>
            @endif
        </div>
    </div>
@endif
