{{-- 사용자 관리 페이지 - 회원 목록 조회, 검색, 상세 모달 기능 --}}
<x-laravel-admin::admin.layouts.admin title="사용자 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.users.select-user') }}">사용자 선택(모달폼 예제)</a>
            </x-slot>
            <x-slot name="description">
                {{ __('User List') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $users = $data;
        $search = request('search');
    @endphp

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">
                        {{ __('회원 리스트') }}
                    </h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        @if($search)
                            {{ __('":keyword" 검색 결과를 확인합니다.', ['keyword' => $search]) }}
                        @else
                            {{ __('관리자 사용자 계정을 조회하고 상세 정보를 확인합니다.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 flex flex-wrap gap-3 sm:mt-0">
                    @can('viewAny', Ssh521\LaravelAdmin\Models\User::class)
                        <a href="{{ route('admin.users.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            {{ __('목록보기') }}
                        </a>
                    @endcan

                    @can('create', Ssh521\LaravelAdmin\Models\User::class)
                        <a href="{{ route('admin.users.create') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            {{ __('등록하기') }}
                        </a>
                    @endcan
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mt-6 rounded-md border border-gray-200 bg-gray-50/60 p-3 dark:border-gray-700 dark:bg-gray-800/60">
                <form class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end" action="{{ route('admin.users.index') }}" method="GET">
                    <label for="user-search" class="sr-only">Search</label>
                    <input
                        id="user-search"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        class="block h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-72 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                        placeholder="{{ __('사용자 검색') }}"
                    >

                    @if($search)
                        <a href="{{ route('admin.users.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            {{ __('초기화') }}
                        </a>
                    @endif

                    <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        {{ __('검색') }}
                    </button>
                </form>
            </div>

            <div class="mt-6 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-white">Name</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">E-mail</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">이메일 인증</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">가입일</th>
                                        <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                    @forelse ($users as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/70">
                                            <td class="py-4 pr-3 pl-4 text-sm sm:pl-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex size-9 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/30">
                                                        {{ mb_substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            @can('view', $user)
                                                                <x-laravel-admin::admin.modal-trigger
                                                                    text="{{ $user->name }}"
                                                                    modal-id="user-detail-modal"
                                                                    variant="primary"
                                                                    type="link"
                                                                    data-user-id="{{ $user->id }}"
                                                                    modal-type="single"
                                                                />
                                                            @else
                                                                {{ $user->name }}
                                                            @endcan
                                                        </div>
                                                        <div class="mt-1 truncate text-gray-500 md:hidden dark:text-gray-400">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 sm:hidden">
                                                    @if($user->email_verified_at)
                                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/30">{{ __('인증됨') }}</span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">{{ __('미인증') }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 md:table-cell dark:text-gray-300">
                                                @can('view', $user)
                                                    <a href="{{ route('admin.users.show', $user->id) }}" class="!text-gray-700 hover:!text-indigo-600 dark:!text-gray-300 dark:hover:!text-indigo-300">{{ $user->email }}</a>
                                                @else
                                                    {{ $user->email }}
                                                @endcan
                                            </td>
                                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm sm:table-cell">
                                                @if($user->email_verified_at)
                                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/30">{{ __('인증됨') }}</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">{{ __('미인증') }}</span>
                                                @endif
                                            </td>
                                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell dark:text-gray-400">
                                                {{ $user->created_at?->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6">
                                                <div class="flex items-center justify-end gap-3">
                                                    @can('view', $user)
                                                        <a href="{{ route('admin.users.show', $user->id) }}" class="!text-indigo-600 hover:!text-indigo-900 dark:!text-indigo-400 dark:hover:!text-indigo-300">{{ __('상세보기') }}</a>
                                                    @endcan
                                                    @can('update', $user)
                                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="!text-gray-700 hover:!text-gray-900 dark:!text-gray-300 dark:hover:!text-white">{{ __('수정') }}</a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                                @if($search)
                                                    {{ __('":keyword"에 대한 검색 결과가 없습니다.', ['keyword' => $search]) }}
                                                @else
                                                    {{ __('등록된 사용자가 없습니다.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-sm">
                {!! $users->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>

    <livewire:admin.users.user-detail-modal />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-user-id]').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');

                    if (userId) {
                        Livewire.dispatch('admin-users:user-detail-modal:open', {
                            userId: parseInt(userId)
                        });
                    }
                });
            });

            Livewire.on('admin-users:user:saved', () => {
                window.location.reload();
            });
        });
    </script>
</x-laravel-admin::admin.layouts.admin>
