<form wire:submit="save" class="p-5">
    <div class="space-y-6">
        <div>
            <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">사용자 정보 수정</h3>
            <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">
                {{ $user->name }} 계정의 이름, 이메일, 비밀번호를 수정합니다.
            </p>
        </div>

        <div class="border-t border-gray-200 pt-5 dark:border-gray-700">
            <label for="modal-user-name-{{ $modalStackId }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이름</label>
            <div class="mt-2">
                <x-laravel-admin::admin.form-input
                    id="modal-user-name-{{ $modalStackId }}"
                    name="name"
                    type="text"
                    class="h-10 w-full"
                    wire:model.defer="name"
                />
                @error('name')
                    <x-laravel-admin::admin.input-error-message for="modal-user-name-{{ $modalStackId }}" class="mt-2 text-xs" :messages="[$message]" />
                @enderror
            </div>
        </div>

        <div>
            <label for="modal-user-email-{{ $modalStackId }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이메일</label>
            <div class="mt-2">
                <x-laravel-admin::admin.form-input
                    id="modal-user-email-{{ $modalStackId }}"
                    name="email"
                    type="email"
                    class="h-10 w-full"
                    wire:model.defer="email"
                />
                @error('email')
                    <x-laravel-admin::admin.input-error-message for="modal-user-email-{{ $modalStackId }}" class="mt-2 text-xs" :messages="[$message]" />
                @enderror
            </div>
        </div>

        <div>
            <label for="modal-user-password-{{ $modalStackId }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                비밀번호
                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(변경 시에만 입력)</span>
            </label>
            <div class="mt-2">
                <x-laravel-admin::admin.form-input
                    id="modal-user-password-{{ $modalStackId }}"
                    name="password"
                    type="password"
                    class="h-10 w-full"
                    wire:model.defer="password"
                />
                @error('password')
                    <x-laravel-admin::admin.input-error-message for="modal-user-password-{{ $modalStackId }}" class="mt-2 text-xs" :messages="[$message]" />
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
        <x-laravel-admin::admin.action-button
            type="button"
            variant="secondary"
            wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })"
        >
            닫기
        </x-laravel-admin::admin.action-button>
        <x-laravel-admin::admin.action-button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="save"
        >
            <span wire:loading.remove wire:target="save">저장하기</span>
            <span wire:loading wire:target="save" role="status">저장 중...</span>
        </x-laravel-admin::admin.action-button>
    </div>
</form>
