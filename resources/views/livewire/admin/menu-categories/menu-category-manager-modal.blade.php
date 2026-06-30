<div class="p-5">
    <div>
        <h3 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">메뉴 카테고리 관리</h3>
        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">카테고리별 접근 역할을 확인하고 관리합니다.</p>
    </div>

    <div class="mt-5 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/70">
        <x-laravel-admin::admin.form-input wire:model.live.debounce.250ms="search" placeholder="메뉴 카테고리 검색..." class="h-10 w-full" />
    </div>

    <div class="mt-5 max-h-[380px] overflow-y-auto pr-1">
        <div class="grid grid-cols-1 gap-3">
            @forelse($categories as $category)
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-gray-600 dark:hover:bg-gray-800/80">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-base font-semibold text-gray-900 dark:text-white">
                                {{ $category->name }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                메뉴 {{ $category->menus_count ?? 0 }}개
                            </div>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @forelse($category->roles as $role)
                                    <x-laravel-admin::admin.badge>{{ $role->name }}</x-laravel-admin::admin.badge>
                                @empty
                                    <span class="text-sm text-gray-500 dark:text-gray-400">허용된 역할 없음</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            <x-laravel-admin::admin.badge variant="{{ $category->is_active ? 'success' : 'danger' }}">
                                {{ $category->is_active ? '활성' : '비활성' }}
                            </x-laravel-admin::admin.badge>
                            <button type="button" class="inline-flex h-8 cursor-pointer items-center rounded-md px-2.5 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 dark:text-indigo-300 dark:hover:bg-indigo-500/10" wire:click="openRolesModal({{ $category->id }})">
                                <x-laravel-admin::admin.icon name="pen-to-square" class="mr-1.5 text-xs" />
                                역할 관리
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <x-laravel-admin::admin.empty-state>메뉴 카테고리가 없습니다.</x-laravel-admin::admin.empty-state>
            @endforelse
        </div>
    </div>

    <div class="mt-6 flex justify-end border-t border-gray-200 pt-4 dark:border-gray-700">
        <x-laravel-admin::admin.action-button type="button" variant="secondary" wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
            닫기
        </x-laravel-admin::admin.action-button>
    </div>
</div>
