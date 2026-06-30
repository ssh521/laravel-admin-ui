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
                <input
                    id="modal-user-name-{{ $modalStackId }}"
                    type="text"
                    class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                    wire:model.defer="name"
                >
                @error('name')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="modal-user-email-{{ $modalStackId }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이메일</label>
            <div class="mt-2">
                <input
                    id="modal-user-email-{{ $modalStackId }}"
                    type="email"
                    class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                    wire:model.defer="email"
                >
                @error('email')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="modal-user-password-{{ $modalStackId }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                비밀번호
                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(변경 시에만 입력)</span>
            </label>
            <div class="mt-2">
                <input
                    id="modal-user-password-{{ $modalStackId }}"
                    type="password"
                    class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                    wire:model.defer="password"
                >
                @error('password')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
        <button
            type="button"
            class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700"
            wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })"
        >
            닫기
        </button>
        <button
            type="submit"
            class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-60 dark:bg-indigo-500 dark:hover:bg-indigo-400"
            wire:loading.attr="disabled"
            wire:target="save"
        >
            저장하기
        </button>
    </div>
</form>
