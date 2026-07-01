<div class="p-4">
    <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
        <p class="text-sm text-blue-700 dark:text-blue-300">
            {{ count($selectedMenuIds) }}개의 메뉴가 선택되었습니다.
        </p>
    </div>

    <div class="space-y-2">
        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">변경할 카테고리를 선택하세요:</label>

        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
            <input type="radio" value="" wire:model="categoryId"
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">미분류</span>
        </label>

        @foreach($categories as $category)
            <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                <input type="radio" value="{{ $category['id'] }}" wire:model="categoryId"
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ $category['name'] }}
                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">({{ $category['count'] }}개 메뉴)</span>
                </span>
            </label>
        @endforeach
    </div>

    <div class="mt-6 flex justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-700">
        <x-laravel-admin::admin.action-button
            type="button"
            variant="secondary"
            wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
            취소
        </x-laravel-admin::admin.action-button>
        @if (count($selectedMenuIds) === 0)
            <x-laravel-admin::admin.action-button type="button" wire:click="save" disabled>
                변경
            </x-laravel-admin::admin.action-button>
        @else
            <x-laravel-admin::admin.action-button type="button" wire:click="save">
                변경
            </x-laravel-admin::admin.action-button>
        @endif
    </div>
</div>
