<form wire:submit="save" class="p-6">
    <div class="mb-5">
        <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
            [{{ $category->name }}] 권한 관리
        </h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            메뉴 카테고리에 허용할 역할을 선택합니다.
        </p>
    </div>

    <div class="grid max-h-80 grid-cols-1 gap-3 overflow-y-auto pr-1 sm:grid-cols-2">
        @forelse($availableRoles as $role)
            <x-laravel-admin::admin.checkbox-row title="{{ $role['name'] }}" class="min-h-12 items-center px-4 py-3 text-sm font-medium">
                <input
                    type="checkbox"
                    class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900"
                    value="{{ $role['id'] }}"
                    wire:model.defer="roleIds"
                >
            </x-laravel-admin::admin.checkbox-row>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">사용 가능한 역할이 없습니다.</p>
        @endforelse
    </div>

    <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-700">
        <x-laravel-admin::admin.action-button type="button" variant="secondary" wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
            취소
        </x-laravel-admin::admin.action-button>
        <x-laravel-admin::admin.action-button type="submit">
            저장
        </x-laravel-admin::admin.action-button>
    </div>
</form>
