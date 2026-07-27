<div class="p-5">
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-4 py-4 sm:px-5 dark:border-gray-700">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h3 class="truncate text-lg font-semibold leading-7 text-gray-900 dark:text-white">{{ $role->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $role->permissions->count() }}개 권한이 연결되어 있습니다.
                    </p>
                </div>
                <x-laravel-admin::admin.badge>Role</x-laravel-admin::admin.badge>
            </div>
        </div>

        <div class="px-4 py-5 sm:px-5">
            <dl class="grid grid-cols-1 gap-0 sm:grid-cols-2">
                <div class="border-t border-gray-100 py-4 sm:pr-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('생성일') }}</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $role->created_at->format('Y-m-d H:i:s') }}</dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:pl-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('수정일') }}</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $role->updated_at->format('Y-m-d H:i:s') }}</dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:col-span-2 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Description') }}</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $role->description ?: __('설명이 없습니다.') }}</dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:col-span-2 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('할당된 권한') }}</dt>
                    <dd class="mt-2">
                        @if($role->permissions->count() > 0)
                            <div class="max-h-56 overflow-y-auto pr-1">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($role->permissions as $permission)
                                        <x-laravel-admin::admin.badge>{{ $permission->name }}</x-laravel-admin::admin.badge>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">할당된 권한이 없습니다.</p>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-5 dark:border-gray-700 dark:bg-gray-800/70">
            <div class="flex flex-wrap justify-end gap-2">
                <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.roles.show', $role)" icon="file-lines">
                    상세 페이지
                </x-laravel-admin::admin.action-button>
                @can('update', $role)
                    <x-laravel-admin::admin.action-button type="button" variant="secondary" wire:click="openEditModal" icon="pen-to-square">
                        모달에서 수정
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button type="button" wire:click="editRole">
                        수정 페이지
                    </x-laravel-admin::admin.action-button>
                @endcan
                <x-laravel-admin::admin.action-button type="button" variant="secondary" wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
                    닫기
                </x-laravel-admin::admin.action-button>
            </div>
        </div>
    </div>
</div>
