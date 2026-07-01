<div class="p-3">
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-700">
            <div class="flex items-start justify-between gap-4">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="truncate text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="mt-0.5 truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>

                @if($user->email_verified_at)
                    <x-laravel-admin::admin.badge variant="success" class="shrink-0">인증됨</x-laravel-admin::admin.badge>
                @else
                    <x-laravel-admin::admin.badge variant="warning" class="shrink-0">미인증</x-laravel-admin::admin.badge>
                @endif
            </div>
        </div>

        <div class="px-4 py-3">
            <dl class="grid grid-cols-1 gap-0 sm:grid-cols-2">
                <div class="border-t border-gray-100 py-3 sm:pr-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-5 text-gray-900 dark:text-white">{{ __('이름') }}</dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-700 dark:text-gray-300">{{ $user->name }}</dd>
                </div>
                <div class="border-t border-gray-100 py-3 sm:pl-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-5 text-gray-900 dark:text-white">{{ __('E-mail') }}</dt>
                    <dd class="mt-1 break-all text-sm leading-5 text-gray-700 dark:text-gray-300">{{ $user->email }}</dd>
                </div>
                <div class="border-t border-gray-100 py-3 sm:col-span-2 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-5 text-gray-900 dark:text-white">{{ __('이메일 인증') }}</dt>
                    <dd class="mt-2 flex flex-wrap items-center gap-3 text-sm leading-5 text-gray-700 dark:text-gray-300">
                        @can('update', $user)
                            <button
                                type="button"
                                wire:click="setEmailVerified({{ $user->id }}, {{ $user->email_verified_at ? 0 : 1 }})"
                                wire:loading.attr="disabled"
                                wire:target="setEmailVerified"
                                wire:loading.class="opacity-60 cursor-not-allowed"
                                class="inline-flex h-8 cursor-pointer items-center gap-2 rounded-md border border-gray-200 bg-white px-3 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800"
                                role="switch"
                                aria-checked="{{ $user->email_verified_at ? 'true' : 'false' }}">
                                <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full transition-colors {{ $user->email_verified_at ? 'bg-green-600' : 'bg-gray-300 dark:bg-gray-600' }}">
                                    <span class="inline-block size-4 transform rounded-full bg-white shadow transition {{ $user->email_verified_at ? 'translate-x-4' : 'translate-x-1' }}"></span>
                                </span>
                                <span class="{{ $user->email_verified_at ? 'text-green-700 dark:text-green-300' : 'text-amber-700 dark:text-amber-300' }}">
                                    {{ $user->email_verified_at ? '인증됨' : '미인증' }}
                                </span>
                            </button>
                        @else
                            @if($user->email_verified_at)
                                <x-laravel-admin::admin.badge variant="success">인증됨</x-laravel-admin::admin.badge>
                            @else
                                <x-laravel-admin::admin.badge variant="warning">미인증</x-laravel-admin::admin.badge>
                            @endif
                        @endcan

                        @if($user->email_verified_at)
                            <span class="text-gray-500 dark:text-gray-400">{{ $user->email_verified_at->format('Y-m-d H:i:s') }}</span>
                        @endif
                    </dd>
                </div>
                <div class="border-t border-gray-100 py-3 sm:pr-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-5 text-gray-900 dark:text-white">{{ __('가입일') }}</dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-700 dark:text-gray-300">{{ $user->created_at?->format('Y-m-d H:i:s') }}</dd>
                </div>
                <div class="border-t border-gray-100 py-3 sm:pl-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-5 text-gray-900 dark:text-white">{{ __('수정일') }}</dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-700 dark:text-gray-300">{{ $user->updated_at?->format('Y-m-d H:i:s') }}</dd>
                </div>
            </dl>
        </div>

        <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800/70">
            <div class="flex flex-wrap justify-end gap-2">
                @can('view', $user)
                    <x-laravel-admin::admin.action-button variant="secondary" size="sm" :href="route('admin.users.show', $user)" icon="file-lines">
                        상세 페이지
                    </x-laravel-admin::admin.action-button>
                @endcan
                @can('update', $user)
                    <x-laravel-admin::admin.action-button type="button" variant="secondary" size="sm" wire:click="openUserEditModal" icon="pen-to-square">
                        모달에서 수정
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button type="button" size="sm" wire:click="editUser">
                        수정 페이지
                    </x-laravel-admin::admin.action-button>
                @endcan
                <x-laravel-admin::admin.action-button type="button" variant="secondary" size="sm" wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
                    닫기
                </x-laravel-admin::admin.action-button>
            </div>
        </div>
    </div>
</div>
