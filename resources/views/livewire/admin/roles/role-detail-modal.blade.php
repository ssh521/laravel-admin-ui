<div>
    <x-laravel-admin::admin.draggable-modal
        id="role-detail-modal"
        x-on:closed-modal.window="if ($event.detail.modalId === 'role-detail-modal') $wire.resetRole()"
        title="역할 상세 정보"
        :show-close-button="true"
        :show-resize-handle="true"
        :close-on-escape="true"
        :close-on-backdrop-click="true"
        :width="640"
        :height="560">

        <div class="p-5">
            @if($role)
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-4 py-4 sm:px-5 dark:border-gray-700">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="truncate text-lg font-semibold leading-7 text-gray-900 dark:text-white">{{ $role->name }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $role->permissions->count() }}개 권한이 연결되어 있습니다.
                                </p>
                            </div>
                            <span class="inline-flex shrink-0 items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                                Role
                            </span>
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
                                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">
                                                        {{ $permission->name }}
                                                    </span>
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
                            <a href="{{ route('admin.roles.show', $role) }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                                <x-laravel-admin::admin.icon name="file-lines" class="mr-2 text-xs" />
                                상세 페이지
                            </a>
                            @can('update', $role)
                                <button type="button" wire:click="openEditModal" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                                    <x-laravel-admin::admin.icon name="pen-to-square" class="mr-2 text-xs" />
                                    모달에서 수정
                                </button>
                                <button type="button" wire:click="editRole" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                    수정 페이지
                                </button>
                            @endcan
                            <button type="button" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700" @click="$dispatch('close-modal', { modalId: 'role-detail-modal' })">
                                닫기
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        </x-laravel-admin::admin.draggable-modal>

        <!-- 자식 모달: 역할 수정 폼 -->
        <x-laravel-admin::admin.draggable-modal
            id="role-edit-modal"
            x-on:closed-modal.window="if ($event.detail.modalId === 'role-edit-modal') $wire.resetEditForm()"
            title="역할 수정"
            :show-close-button="true"
            :show-resize-handle="true"
            :close-on-escape="true"
            :close-on-backdrop-click="true"
            :width="500"
            :height="600">
            <div class="px-2 py-2">
                <livewire:admin.roles.role-form parent-modal-id="role-edit-modal" />
            </div>
        </x-laravel-admin::admin.draggable-modal>
</div>
