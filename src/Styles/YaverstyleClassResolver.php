<?php

namespace Ssh521\LaravelAdminUi\Styles;

use Ssh521\LaravelAdminUi\Contracts\StyleClassResolver;

class YaverstyleClassResolver implements StyleClassResolver
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function classes(string $key, array $context = []): string
    {
        return match ($key) {
            'action-button.base' => 'inline-flex cursor-pointer items-center justify-center gap-2 rounded-md font-semibold transition hover:!no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
            'action-button.size' => $this->actionButtonSize($context['size'] ?? 'md'),
            'action-button.variant' => $this->actionButtonVariant($context['variant'] ?? 'primary'),
            'legacy-button.primary' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-gray-100 focus:bg-gray-700 dark:focus:bg-gray-100 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 cursor-pointer disabled:cursor-not-allowed transition ease-in-out duration-150',
            'legacy-button.secondary' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 cursor-pointer disabled:cursor-not-allowed transition ease-in-out duration-150',
            'legacy-button.danger' => 'inline-flex items-center justify-center px-4 py-2 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 dark:hover:bg-red-400 active:bg-red-700 dark:active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 cursor-pointer disabled:cursor-not-allowed transition ease-in-out duration-150',
            'badge.base' => 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
            'badge.variant' => $this->badgeVariant($context['variant'] ?? 'neutral'),
            'dropdown.container' => 'relative',
            'dropdown.panel' => 'absolute z-50 mt-2 rounded-md shadow-lg',
            'dropdown.content' => 'rounded-md bg-white py-1 ring-1 ring-black ring-opacity-5 dark:bg-gray-700',
            'dropdown-link' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800',
            'accordion.container' => 'rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900',
            'accordion.button' => 'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm font-semibold text-gray-900 transition hover:bg-gray-50 dark:text-gray-100 dark:hover:bg-gray-800',
            'accordion.icon' => 'size-4 text-gray-500 transition-transform dark:text-gray-400',
            'accordion.content' => 'border-t border-gray-200 px-4 py-4 text-sm text-gray-700 dark:border-gray-700 dark:text-gray-300',
            'card.container' => 'rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900',
            'card.header' => 'border-b border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700',
            'card.title' => 'text-base font-semibold leading-6 text-gray-900 dark:text-white',
            'card.description' => 'mt-1 text-sm text-gray-600 dark:text-gray-400',
            'card.body' => 'px-4 py-5 sm:p-6',
            'card.footer' => 'border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700',
            'field.wrapper' => 'space-y-2',
            'field.label' => 'block text-sm font-medium text-gray-900 dark:text-gray-100',
            'field.required' => 'text-red-600 dark:text-red-400',
            'field.help' => 'text-sm text-gray-500 dark:text-gray-400',
            'form-section.container' => 'mx-auto grid max-w-4xl grid-cols-1 gap-x-8 gap-y-6 text-gray-900 md:grid-cols-12 dark:text-gray-100',
            'form-section.header' => 'md:col-span-4',
            'form-section.title' => 'text-base font-semibold leading-7 text-gray-900 dark:text-white',
            'form-section.description' => 'mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400',
            'form-section.body' => 'md:col-span-8',
            'description-list.container' => 'overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900',
            'description-list.grid' => 'divide-y divide-gray-200 dark:divide-gray-700',
            'description-list.row' => 'px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6',
            'description-list.term' => 'text-sm font-medium text-gray-900 dark:text-gray-100',
            'description-list.description' => 'mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300',
            'tabs.nav' => 'flex gap-1 border-b border-gray-200 dark:border-gray-700',
            'tabs.item' => 'border-b-2 border-transparent px-3 py-2 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200',
            'tabs.item-active' => 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-300',
            'confirm-dialog.backdrop' => 'fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4',
            'confirm-dialog.panel' => 'w-full max-w-md rounded-lg bg-white p-6 shadow-xl dark:bg-gray-900',
            'confirm-dialog.title' => 'text-base font-semibold text-gray-900 dark:text-white',
            'confirm-dialog.description' => 'mt-2 text-sm text-gray-600 dark:text-gray-400',
            'confirm-dialog.actions' => 'mt-6 flex justify-end gap-2',
            'toast.container' => 'rounded-md border p-4 shadow-sm',
            'toast.variant' => $this->toastVariant($context['type'] ?? 'info'),
            'toast.title' => 'text-sm font-semibold',
            'toast.message' => 'mt-1 text-sm',
            'pagination.container' => 'flex items-center justify-between gap-4 border-t border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700',
            'pagination.info' => 'text-sm text-gray-700 dark:text-gray-300',
            'pagination.links' => 'flex gap-2',
            'stat.container' => 'rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900',
            'stat.label' => 'text-sm font-medium text-gray-500 dark:text-gray-400',
            'stat.value' => 'mt-2 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white',
            'stat.description' => 'mt-1 text-sm text-gray-600 dark:text-gray-400',
            'drawer.backdrop' => 'fixed inset-0 z-50 bg-gray-900/50',
            'drawer.panel' => $this->drawerPanel($context['side'] ?? 'right'),
            'drawer.header' => 'flex items-center justify-between border-b border-gray-200 px-4 py-4 dark:border-gray-700',
            'drawer.title' => 'text-base font-semibold text-gray-900 dark:text-white',
            'drawer.body' => 'p-4',
            'breadcrumb.nav' => 'flex',
            'breadcrumb.list' => 'flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400',
            'breadcrumb.link' => 'font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200',
            'breadcrumb.current' => 'font-medium text-gray-900 dark:text-white',
            'breadcrumb.separator' => 'text-gray-400 dark:text-gray-600',
            'avatar.container' => 'inline-flex items-center justify-center overflow-hidden rounded-full bg-gray-100 text-sm font-semibold text-gray-700 ring-1 ring-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:ring-gray-700',
            'avatar.size' => $this->avatarSize($context['size'] ?? 'md'),
            'avatar.image' => 'h-full w-full object-cover',
            'progress.container' => 'space-y-2',
            'progress.header' => 'flex items-center justify-between text-sm font-medium text-gray-700 dark:text-gray-300',
            'progress.track' => 'h-2 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700',
            'progress.bar' => 'h-full rounded-full bg-indigo-600 transition-all dark:bg-indigo-400',
            'stepper.list' => 'flex flex-col gap-4 sm:flex-row sm:items-center',
            'stepper.item' => 'flex items-center gap-3 text-sm',
            'stepper.marker' => 'flex size-8 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white font-semibold text-gray-600 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300',
            'stepper.marker-active' => 'border-indigo-600 bg-indigo-600 text-white dark:border-indigo-400 dark:bg-indigo-400 dark:text-gray-950',
            'stepper.label' => 'font-medium text-gray-700 dark:text-gray-300',
            'timeline.list' => 'space-y-6 border-l border-gray-200 pl-6 dark:border-gray-700',
            'timeline.item' => 'relative',
            'timeline.marker' => 'absolute -left-[31px] top-1 size-3 rounded-full border-2 border-white bg-indigo-600 dark:border-gray-900 dark:bg-indigo-400',
            'timeline.title' => 'text-sm font-semibold text-gray-900 dark:text-white',
            'timeline.meta' => 'mt-1 text-xs text-gray-500 dark:text-gray-400',
            'timeline.body' => 'mt-2 text-sm text-gray-700 dark:text-gray-300',
            'skeleton' => 'animate-pulse rounded-md bg-gray-200 dark:bg-gray-700',
            'file-upload.container' => 'rounded-lg border-2 border-dashed border-gray-300 bg-white p-6 text-center transition hover:border-indigo-400 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-indigo-500',
            'file-upload.icon' => 'mx-auto size-10 text-gray-400 dark:text-gray-500',
            'file-upload.label' => 'mt-3 text-sm font-medium text-gray-900 dark:text-white',
            'file-upload.help' => 'mt-1 text-xs text-gray-500 dark:text-gray-400',
            'choice-card.container' => 'relative flex cursor-pointer gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:border-indigo-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-indigo-500',
            'choice-card.input' => 'mt-1 size-4 border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900',
            'choice-card.title' => 'text-sm font-semibold text-gray-900 dark:text-white',
            'choice-card.description' => 'mt-1 text-sm text-gray-600 dark:text-gray-400',
            'bulk-action-bar.container' => 'flex flex-col gap-3 rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm sm:flex-row sm:items-center sm:justify-between dark:border-gray-700 dark:bg-gray-900',
            'bulk-action-bar.summary' => 'text-sm font-medium text-gray-700 dark:text-gray-300',
            'bulk-action-bar.actions' => 'flex flex-wrap gap-2',
            'search-input.wrapper' => 'relative flex w-full items-center',
            'search-input.icon' => 'pointer-events-none absolute left-3 size-4 text-gray-400 dark:text-gray-500',
            'search-input.input' => 'block w-full rounded-md border border-gray-300 bg-white py-2 pr-10 pl-9 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white',
            'search-input.clear' => 'absolute right-2 inline-flex size-7 items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-200',
            'filter-select.wrapper' => 'space-y-1',
            'filter-select.label' => 'block text-xs font-medium text-gray-500 dark:text-gray-400',
            'filter-select.select' => 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-44 dark:border-gray-600 dark:bg-gray-900 dark:text-white',
            'date-range.wrapper' => 'flex flex-col gap-2 sm:flex-row sm:items-end',
            'date-range.field' => 'space-y-1',
            'date-range.label' => 'block text-xs font-medium text-gray-500 dark:text-gray-400',
            'date-range.input' => 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-40 dark:border-gray-600 dark:bg-gray-900 dark:text-white',
            'copy-button.wrapper' => 'inline-flex items-center gap-2',
            'copy-button.value' => 'rounded-md border border-gray-200 bg-gray-50 px-3 py-2 font-mono text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200',
            'code-block.container' => 'overflow-hidden rounded-lg border border-gray-200 bg-gray-950 text-gray-100 shadow-sm dark:border-gray-700',
            'code-block.header' => 'flex items-center justify-between border-b border-white/10 px-4 py-2 text-xs font-medium text-gray-400',
            'code-block.pre' => 'overflow-x-auto p-4 text-sm',
            'kbd' => 'inline-flex min-w-6 items-center justify-center rounded border border-gray-300 bg-gray-50 px-1.5 py-0.5 font-mono text-xs font-medium text-gray-700 shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200',
            'divider' => 'my-6 border-t border-gray-200 dark:border-gray-700',
            'status-dot.wrapper' => 'inline-flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300',
            'status-dot.dot' => $this->statusDot($context['variant'] ?? 'neutral'),
            'user-cell.wrapper' => 'flex min-w-0 items-center gap-3',
            'user-cell.body' => 'min-w-0',
            'user-cell.name' => 'truncate text-sm font-medium text-gray-900 dark:text-white',
            'user-cell.email' => 'truncate text-sm text-gray-500 dark:text-gray-400',
            'action-menu.trigger' => 'inline-flex size-8 items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200',
            'table-empty-row.cell' => 'px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400',
            'loading-overlay.wrapper' => 'relative',
            'loading-overlay.overlay' => 'absolute inset-0 z-20 flex items-center justify-center rounded-lg bg-white/70 backdrop-blur-sm dark:bg-gray-900/70',
            'loading-overlay.spinner' => 'size-6 animate-spin rounded-full border-2 border-gray-300 border-t-indigo-600 dark:border-gray-700 dark:border-t-indigo-400',
            'notice.container' => 'rounded-lg border p-4',
            'notice.variant' => $this->noticeVariant($context['type'] ?? 'info'),
            'notice.title' => 'text-sm font-semibold',
            'notice.body' => 'mt-1 text-sm',
            'key-value-grid.container' => 'grid grid-cols-1 gap-4 sm:grid-cols-2',
            'key-value-grid.item' => 'rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900',
            'key-value-grid.key' => 'text-xs font-medium uppercase text-gray-500 dark:text-gray-400',
            'key-value-grid.value' => 'mt-1 text-sm text-gray-900 dark:text-white',
            'sort-control.wrapper' => 'flex flex-col gap-2 sm:flex-row sm:items-center',
            'sort-control.select' => 'block rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white',
            'column-toggle.trigger' => 'inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700',
            'column-toggle.item' => 'flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300',
            'export-button.menu' => 'flex flex-col py-1',
            'inline-edit.wrapper' => 'flex flex-col gap-2 sm:flex-row sm:items-center',
            'inline-edit.input' => 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white',
            'permission-matrix.container' => 'overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900',
            'permission-matrix.group' => 'border-b border-gray-200 p-4 last:border-b-0 dark:border-gray-700',
            'permission-matrix.title' => 'text-sm font-semibold text-gray-900 dark:text-white',
            'permission-matrix.grid' => 'mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3',
            'permission-matrix.item' => 'flex items-center gap-2 rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-700 dark:border-gray-700 dark:text-gray-300',
            'page-header.container' => 'mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between',
            'page-header.title' => 'text-2xl font-semibold leading-7 text-gray-900 dark:text-white',
            'page-header.description' => 'mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400',
            'page-header.actions' => 'flex flex-wrap gap-2',
            'form.input' => 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:disabled:bg-gray-800',
            'form.select' => 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:disabled:bg-gray-800',
            'form.textarea' => 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:disabled:bg-gray-800',
            'filter-bar' => 'mt-6 flex flex-col gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:flex-row sm:items-center dark:border-gray-700 dark:bg-gray-800/70',
            'table-shell.outer' => 'flow-root',
            'table-shell.scroller' => '-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8',
            'table-shell.inner' => 'inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8',
            default => '',
        };
    }

    private function actionButtonSize(mixed $size): string
    {
        $size = is_string($size) ? $size : 'md';

        return [
            'sm' => 'h-8 px-3 text-sm',
            'md' => 'h-10 px-4 text-sm',
            'lg' => 'h-11 px-5 text-base',
        ][$size] ?? 'h-10 px-4 text-sm';
    }

    private function actionButtonVariant(mixed $variant): string
    {
        $variant = is_string($variant) ? $variant : 'primary';

        return [
            'primary' => 'bg-indigo-600 !text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400',
            'secondary' => 'border border-gray-300 bg-white !text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700',
            'danger' => 'border border-red-200 bg-white !text-red-700 shadow-sm hover:bg-red-50 focus-visible:outline-red-600 dark:border-red-500/30 dark:bg-gray-900 dark:!text-red-300 dark:hover:bg-red-500/10',
            'search' => 'laravel-admin-search-button shadow-sm focus-visible:outline-gray-900',
            'link' => '!text-indigo-600 hover:bg-indigo-50 dark:!text-indigo-300 dark:hover:bg-indigo-500/10',
        ][$variant] ?? 'bg-indigo-600 !text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400';
    }

    private function badgeVariant(mixed $variant): string
    {
        $variant = is_string($variant) ? $variant : 'neutral';

        return [
            'neutral' => 'bg-gray-50 text-gray-700 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700',
            'primary' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20',
            'success' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20',
            'warning' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20',
            'danger' => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-500/20',
        ][$variant] ?? 'bg-gray-50 text-gray-700 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700';
    }

    private function toastVariant(mixed $type): string
    {
        $type = is_string($type) ? $type : 'info';

        return [
            'success' => 'border-green-200 bg-green-50 text-green-800 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-300',
            'error' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300',
            'warning' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300',
            'info' => 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300',
        ][$type] ?? 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300';
    }

    private function drawerPanel(mixed $side): string
    {
        $side = is_string($side) ? $side : 'right';
        $position = $side === 'left' ? 'left-0' : 'right-0';

        return "fixed top-0 {$position} z-50 h-full w-full max-w-md bg-white shadow-xl dark:bg-gray-900";
    }

    private function avatarSize(mixed $size): string
    {
        $size = is_string($size) ? $size : 'md';

        return [
            'sm' => 'size-8',
            'md' => 'size-10',
            'lg' => 'size-12',
            'xl' => 'size-16',
        ][$size] ?? 'size-10';
    }

    private function statusDot(mixed $variant): string
    {
        $variant = is_string($variant) ? $variant : 'neutral';
        $color = [
            'neutral' => 'bg-gray-400',
            'primary' => 'bg-indigo-500',
            'success' => 'bg-green-500',
            'warning' => 'bg-amber-500',
            'danger' => 'bg-red-500',
        ][$variant] ?? 'bg-gray-400';

        return "size-2.5 rounded-full {$color}";
    }

    private function noticeVariant(mixed $type): string
    {
        $type = is_string($type) ? $type : 'info';

        return [
            'success' => 'border-green-200 bg-green-50 text-green-800 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-300',
            'error' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300',
            'warning' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300',
            'info' => 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300',
        ][$type] ?? 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300';
    }
}
