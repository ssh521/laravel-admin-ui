@props(['type' => 'info', 'message' => null, 'dismissible' => false])

@php
    $typeClasses = [
        'success' => 'text-green-800 dark:text-green-400 bg-green-50 dark:bg-green-900/20',
        'error' => 'text-red-800 dark:text-red-400 bg-red-50 dark:bg-red-900/20',
        'warning' => 'text-yellow-800 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20',
        'info' => 'text-blue-800 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20'
    ];

    $typeLabels = [
        'success' => '[성공] ',
        'error' => '[오류] ',
        'warning' => '[경고] ',
        'info' => '[정보] '
    ];

    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $label = $typeLabels[$type] ?? $typeLabels['info'];
    $role = in_array($type, ['error', 'warning'], true) ? 'alert' : 'status';
    $live = $role === 'alert' ? 'assertive' : 'polite';
@endphp

@if($message)
<div {{ $attributes->class("p-4 text-sm rounded-lg {$classes}") }} role="{{ $role }}" aria-live="{{ $live }}" @if($dismissible) x-data="{ show: true }" x-show="show" @endif>
    <div class="flex items-center justify-between">
        <div>
            <span class="font-medium">{{ $label }}</span> {{ $message }}
        </div>
        @if($dismissible)
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 inline-flex h-8 w-8 items-center justify-center" aria-label="{{ __('알림 닫기') }}" @click="show = false">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
        @endif
    </div>
</div>
@endif
