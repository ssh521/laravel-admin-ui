<div>
    @if($showModal)
        @if($parentModalId)
            <div class="p-5 text-gray-900 dark:text-gray-100">
                <h2 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                    {{ $mode === 'create' ? '새 사용자 추가' : ($mode === 'view' ? '사용자 보기' : '사용자 편집') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">사용자 이름, 이메일, 비밀번호를 관리합니다.</p>
        @else
            <div class="fixed inset-0 z-40 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/50" wire:click="close"></div>
                <div class="relative z-50 w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
                    <h2 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                        {{ $mode === 'create' ? '새 사용자 추가' : ($mode === 'view' ? '사용자 보기' : '사용자 편집') }}
                    </h2>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">사용자 이름, 이메일, 비밀번호를 관리합니다.</p>
        @endif

                <div class="mt-5 space-y-6 border-t border-gray-200 pt-5 dark:border-gray-700">
                    @if($user && $mode === 'view')
                        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                            <div class="border-b border-gray-200 px-4 py-4 dark:border-gray-700">
                                <div class="flex items-center gap-4">
                                    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-base font-semibold text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                        <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <dl class="divide-y divide-gray-100 dark:divide-gray-800">
                                <div class="px-4 py-4">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">가입일</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $user->created_at?->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                <div class="px-4 py-4">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">마지막 업데이트</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $user->updated_at?->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>
                    @endif

                    @if($mode === 'edit')
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이름</label>
                            <div class="mt-2">
                                <input type="text" class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white" wire:model.defer="name">
                                @error('name')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이메일</label>
                            <div class="mt-2">
                                <input type="email" class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white" wire:model.defer="email">
                                @error('email')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                비밀번호
                                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(수정 시에만 입력)</span>
                            </label>
                            <div class="mt-2">
                                <input type="password" class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white" wire:model.defer="password">
                                @error('password')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                    @if($parentModalId)
                        <button type="button" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700" @click="$dispatch('close-modal', { modalId: '{{ $parentModalId }}' })">
                            닫기
                        </button>
                    @else
                        <button type="button" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700" wire:click.stop="close">
                            닫기
                        </button>
                    @endif

                    @if($mode !== 'view')
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
