<div>
    @if($showModal)
        @if($parentModalId)
            {{-- draggable-modal 안에 있을 때는 자체 모달 UI 사용 안 함 --}}
            <div class="p-5 text-gray-900 dark:text-gray-100">
                <h2 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                    {{ $mode === 'create' ? '새 역할 추가' : ($mode === 'view' ? '역할 보기' : '역할 편집') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">역할 이름과 연결할 권한을 선택합니다.</p>
        @else
            {{-- 독립적으로 사용될 때는 자체 모달 UI 사용 --}}
            <div class="fixed inset-0 z-40 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/50" wire:click="close"></div>
                <div class="relative z-50 w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                        {{ $mode === 'create' ? '새 역할 추가' : ($mode === 'view' ? '역할 보기' : '역할 편집') }}
                    </h2>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">역할 이름과 연결할 권한을 선택합니다.</p>
        @endif

                <div class="mt-5 space-y-6 border-t border-gray-200 pt-5 dark:border-gray-700">
                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">역할 이름</label>
                        <div class="mt-2">
                            <input type="text" class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:disabled:bg-gray-800 dark:disabled:text-gray-400" wire:model.defer="name" @if($mode==='view') disabled @endif>
                            @error('name')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <span class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">권한</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ count($permissionIds ?? []) }}개 선택</span>
                        </div>
                        <div class="mt-3 max-h-72 overflow-y-auto pr-1">
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @forelse($availablePermissions as $permission)
                                    <label for="permission-{{ $permission['id'] }}" title="{{ $permission['name'] }}" class="flex min-h-11 cursor-pointer items-center gap-3 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800 @if($mode==='view') cursor-not-allowed opacity-70 @endif">
                                        <input
                                            type="checkbox"
                                            id="permission-{{ $permission['id'] }}"
                                            wire:model.defer="permissionIds"
                                            value="{{ $permission['id'] }}"
                                            @if($mode==='view') disabled @endif
                                            class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                                        <span class="min-w-0 truncate">{{ $permission['name'] }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">사용 가능한 권한이 없습니다.</p>
                                @endforelse
                            </div>
                            @error('permissionIds')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                    <button type="button" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700" wire:click.stop="close">
                        취소
                    </button>
                    @if($mode!=='view')
                        <button type="button" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400" wire:click.stop="save">
                            저장
                        </button>
                    @endif
                </div>
            @if($parentModalId)
                </div>
            @else
                </div>
            </div>
            @endif
    @endif
</div>
