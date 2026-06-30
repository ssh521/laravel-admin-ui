<div class="p-5">
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-4 py-4 sm:px-5 dark:border-gray-700">
            <div class="flex items-start justify-between gap-4">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-base font-semibold text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="truncate text-lg font-semibold leading-7 text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>

                @if($user->email_verified_at)
                    <span class="inline-flex shrink-0 items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/30">
                        인증됨
                    </span>
                @else
                    <span class="inline-flex shrink-0 items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">
                        미인증
                    </span>
                @endif
            </div>
        </div>

        <div class="px-4 py-5 sm:px-5">
            <dl class="grid grid-cols-1 gap-0 sm:grid-cols-2">
                <div class="border-t border-gray-100 py-4 sm:pr-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('이름') }}</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $user->name }}</dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:pl-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('E-mail') }}</dt>
                    <dd class="mt-1 break-all text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $user->email }}</dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:col-span-2 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('이메일 인증') }}</dt>
                    <dd class="mt-2 flex flex-wrap items-center gap-3 text-sm leading-6 text-gray-700 dark:text-gray-300">
                        @can('update', $user)
                            <button
                                type="button"
                                wire:click="setEmailVerified({{ $user->id }}, {{ $user->email_verified_at ? 0 : 1 }})"
                                wire:loading.attr="disabled"
                                wire:target="setEmailVerified"
                                wire:loading.class="opacity-60 cursor-not-allowed"
                                class="inline-flex cursor-pointer items-center gap-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800"
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
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/30">인증됨</span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">미인증</span>
                            @endif
                        @endcan

                        @if($user->email_verified_at)
                            <span class="text-gray-500 dark:text-gray-400">{{ $user->email_verified_at->format('Y-m-d H:i:s') }}</span>
                        @endif
                    </dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:pr-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('가입일') }}</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $user->created_at?->format('Y-m-d H:i:s') }}</dd>
                </div>
                <div class="border-t border-gray-100 py-4 sm:pl-4 dark:border-gray-800">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('수정일') }}</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $user->updated_at?->format('Y-m-d H:i:s') }}</dd>
                </div>
            </dl>
        </div>

        <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-5 dark:border-gray-700 dark:bg-gray-800/70">
            <div class="flex flex-wrap justify-end gap-2">
                @can('view', $user)
                    <a href="{{ route('admin.users.show', $user) }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-regular fa-file-lines mr-2 text-xs" aria-hidden="true"></i>
                        상세 페이지
                    </a>
                @endcan
                @can('update', $user)
                    <button type="button" wire:click="openUserEditModal" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-regular fa-pen-to-square mr-2 text-xs" aria-hidden="true"></i>
                        모달에서 수정
                    </button>
                    <button type="button" wire:click="editUser" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        수정 페이지
                    </button>
                @endcan
                <button type="button" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700" wire:click="$dispatch('admin:modal-stack:close', { id: '{{ $modalStackId }}' })">
                    닫기
                </button>
            </div>
        </div>
    </div>
</div>
