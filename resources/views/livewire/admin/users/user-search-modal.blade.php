<div class="p-5 text-gray-900 dark:text-gray-100">
    <div class="mb-5">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <label for="modal-user-search" class="sr-only">사용자 검색</label>
            <input
                id="modal-user-search"
                type="text"
                wire:model.live="search"
                placeholder="이름 또는 이메일로 검색..."
                class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
            <button type="button" wire:click="clearSearch" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                초기화
            </button>
        </div>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            페이지: {{ $users->currentPage() }} / {{ $users->lastPage() }} · 총 {{ $users->total() }}명
        </p>
    </div>

    <div class="max-h-96 overflow-y-auto pr-1">
        @if($users->count() > 0)
            <div class="space-y-2">
                @foreach($users as $user)
                    <div class="rounded-md border border-gray-200 bg-white p-3 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50/40 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-indigo-500/40 dark:hover:bg-indigo-500/10">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <button type="button" class="flex min-w-0 flex-1 cursor-pointer items-center gap-3 text-left" wire:click="selectUser({{ $user->id }})">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span>
                                        <span class="shrink-0 rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">#{{ $user->id }}</span>
                                    </div>
                                    <div class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                            </button>

                            <div class="flex shrink-0 items-center justify-end gap-3 text-sm font-medium">
                                @if($canView($user))
                                    <button type="button" class="cursor-pointer text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" wire:click="openUserViewModal({{ $user->id }})">
                                        보기
                                    </button>
                                @endif

                                @if($canEdit($user))
                                    <button type="button" class="cursor-pointer text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white" wire:click="openUserEditModal({{ $user->id }})">
                                        수정
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-md border border-gray-200 bg-gray-50/60 px-4 py-10 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800/60 dark:text-gray-400">
                @if($search)
                    "{{ $search }}"에 대한 검색 결과가 없습니다.
                @else
                    등록된 사용자가 없습니다.
                @endif
            </div>
        @endif
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
