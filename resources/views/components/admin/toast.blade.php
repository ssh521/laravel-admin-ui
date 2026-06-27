@props([
    'type' => 'info',
    'title' => null,
    'message' => null,
    'dismissible' => false,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div
    {{ $attributes->merge(['class' => trim($theme->classes('toast.container').' '.$theme->classes('toast.variant', ['type' => $type]))]) }}
    @if ($dismissible) x-data="{ visible: true }" x-show="visible" @endif
>
    <div class="flex items-start justify-between gap-3">
        <div>
            @if ($title)
                <p class="{{ $theme->classes('toast.title') }}">{{ $title }}</p>
            @endif

            @if ($message)
                <p class="{{ $theme->classes('toast.message') }}">{{ $message }}</p>
            @endif

            {{ $slot }}
        </div>

        @if ($dismissible)
            <button type="button" class="shrink-0" @click="visible = false" aria-label="닫기">
                <x-laravel-admin::admin.icon name="xmark" class="size-4" />
            </button>
        @endif
    </div>
</div>
