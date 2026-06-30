<form wire:submit="save" class="p-5">
    <div>
        <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">역할 수정</h3>
        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">역할 이름과 연결 권한을 수정합니다.</p>
    </div>

    <div class="mt-5 border-t border-gray-200 pt-5 dark:border-gray-700">
        <label for="modal-role-name-{{ $modalStackId }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">역할 이름</label>
        <x-laravel-admin::admin.form-input id="modal-role-name-{{ $modalStackId }}" wire:model.defer="name" class="mt-2 w-full" />
        @error('name')
            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-6">
        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">권한</h4>
        <div class="mt-3 grid max-h-80 grid-cols-1 gap-3 overflow-y-auto pr-1 sm:grid-cols-2">
            @foreach($availablePermissions as $permission)
                <x-laravel-admin::admin.checkbox-row title="{{ $permission['name'] }}" class="min-h-11 items-center px-3 py-2 text-sm font-medium">
                    <input
                        type="checkbox"
                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900"
                        value="{{ $permission['id'] }}"
                        wire:model.defer="permissionIds"
                    >
                </x-laravel-admin::admin.checkbox-row>
            @endforeach
        </div>
        @error('permissionIds')
            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
        <x-laravel-admin::admin.action-button type="button" variant="secondary" wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
            닫기
        </x-laravel-admin::admin.action-button>
        <x-laravel-admin::admin.action-button type="submit" wire:loading.attr="disabled" wire:target="save">
            저장하기
        </x-laravel-admin::admin.action-button>
    </div>
</form>
