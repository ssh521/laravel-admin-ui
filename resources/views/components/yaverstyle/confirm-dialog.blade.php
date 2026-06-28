@props([
    'title' => '확인',
    'description' => null,
    'confirmLabel' => '확인',
    'cancelLabel' => '취소',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<div x-data="{ open: false }">
    <div @click="open = true">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-cloak
        class="{{ $theme->classes('confirm-dialog.backdrop') }}"
        @keydown.escape.window="open = false"
    >
        <div class="{{ $theme->classes('confirm-dialog.panel') }}" @click.outside="open = false">
            <h2 class="{{ $theme->classes('confirm-dialog.title') }}">{{ $title }}</h2>

            @if ($description)
                <p class="{{ $theme->classes('confirm-dialog.description') }}">{{ $description }}</p>
            @endif

            @isset($content)
                <div class="mt-4">
                    {{ $content }}
                </div>
            @endisset

            <div class="{{ $theme->classes('confirm-dialog.actions') }}">
                <x-laravel-admin::admin.action-button variant="secondary" type="button" @click="open = false">
                    {{ $cancelLabel }}
                </x-laravel-admin::admin.action-button>

                @isset($confirm)
                    {{ $confirm }}
                @else
                    <x-laravel-admin::admin.action-button variant="danger" type="button">
                        {{ $confirmLabel }}
                    </x-laravel-admin::admin.action-button>
                @endisset
            </div>
        </div>
    </div>
</div>
