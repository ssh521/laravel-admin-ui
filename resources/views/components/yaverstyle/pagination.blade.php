@props([
    'paginator' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

@if ($paginator && method_exists($paginator, 'hasPages') && $paginator->hasPages())
    <nav {{ $attributes->merge(['class' => $theme->classes('pagination.container')]) }} aria-label="Pagination">
        <p class="{{ $theme->classes('pagination.info') }}">
            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} / {{ $paginator->total() }}
        </p>

        <div class="{{ $theme->classes('pagination.links') }}">
            @if ($paginator->onFirstPage())
                <x-laravel-admin::admin.action-button variant="secondary" disabled>이전</x-laravel-admin::admin.action-button>
            @else
                <x-laravel-admin::admin.action-button variant="secondary" href="{{ $paginator->previousPageUrl() }}">이전</x-laravel-admin::admin.action-button>
            @endif

            @if ($paginator->hasMorePages())
                <x-laravel-admin::admin.action-button variant="secondary" href="{{ $paginator->nextPageUrl() }}">다음</x-laravel-admin::admin.action-button>
            @else
                <x-laravel-admin::admin.action-button variant="secondary" disabled>다음</x-laravel-admin::admin.action-button>
            @endif
        </div>
    </nav>
@else
    {{ $slot }}
@endif
