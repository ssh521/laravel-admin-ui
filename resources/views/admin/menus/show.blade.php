<x-laravel-admin::admin.layouts.admin title="메뉴 상세">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menus.index') }}">메뉴 관리</a>
            </x-slot>
            <x-slot name="description">{{ __('메뉴 상세') }}</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('메뉴 정보') }}</h1>
                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            {{ __('메뉴의 기본 정보, 연결 경로, 표시 상태를 확인합니다.') }}
                        </p>
                    </div>
                    <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-6">
                        <a href="{{ route('admin.menus.index') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-list mr-2 text-xs" aria-hidden="true"></i>
                            {{ __('목록보기') }}
                        </a>
                    </div>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                            @if($menu->icon)
                                <i class="{{ $menu->icon }}" aria-hidden="true"></i>
                            @else
                                <i class="fa-solid fa-bars" aria-hidden="true"></i>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ $menu->name }}</h2>
                            <p class="truncate text-sm leading-6 text-gray-500 dark:text-gray-400">
                                {{ $menu->category ? $menu->category->name : __('카테고리 없음') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-6 sm:px-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('ID') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->id }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('메뉴명') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->name }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('카테고리') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->category ? $menu->category->name : '-' }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('상위 메뉴') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->parent ? $menu->parent->name : '-' }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Route Name') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->route_name ?: '-' }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Route Params') }}</dt>
                            <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->route_parameters ?: '-' }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Direct URL') }}</dt>
                            <dd class="mt-1 break-words text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->url ?: '-' }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Target') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->target ?: '-' }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('정렬 순서') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->sort_order }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('상태') }}</dt>
                            <dd class="mt-1 text-sm leading-6 sm:mt-2">
                                <span class="{{ $menu->is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-500/20' }} inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                    {{ $menu->is_active ? __('활성') : __('비활성') }}
                                </span>
                            </dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('외부 링크') }}</dt>
                            <dd class="mt-1 text-sm leading-6 sm:mt-2">
                                <span class="{{ $menu->is_external ? 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20' : 'bg-gray-50 text-gray-700 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700' }} inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                    {{ $menu->is_external ? __('예') : __('아니오') }}
                                </span>
                            </dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('등록일') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->created_at?->format('Y-m-d H:i:s') }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('수정일') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->updated_at?->format('Y-m-d H:i:s') }}</dd>
                        </div>

                        @if($menu->description)
                            <div class="border-t border-gray-100 px-0 py-5 sm:col-span-2 dark:border-gray-800">
                                <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('설명') }}</dt>
                                <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $menu->description }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                @if($menu->children->count() > 0)
                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6 dark:border-gray-700">
                        <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">{{ __('Child Menus') }}</h3>
                        <div class="mt-4 flow-root">
                            <div class="-mx-4 overflow-x-auto sm:-mx-6">
                                <div class="inline-block min-w-full align-middle sm:px-6">
                                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3 pr-3 text-left font-semibold text-gray-900 dark:text-white">{{ __('Child Menu') }}</th>
                                                <th scope="col" class="px-3 py-3 text-left font-semibold text-gray-900 dark:text-white">{{ __('Route/URL') }}</th>
                                                <th scope="col" class="px-3 py-3 text-left font-semibold text-gray-900 dark:text-white">{{ __('Status') }}</th>
                                                <th scope="col" class="py-3 pl-3 text-right font-semibold text-gray-900 dark:text-white">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            @foreach($menu->children as $childMenu)
                                                <tr>
                                                    <td class="whitespace-nowrap py-3 pr-3 font-medium text-gray-900 dark:text-white">{{ $childMenu->name }}</td>
                                                    <td class="whitespace-nowrap px-3 py-3 text-gray-600 dark:text-gray-300">{{ $childMenu->route_name ?: ($childMenu->url ?: '-') }}</td>
                                                    <td class="whitespace-nowrap px-3 py-3">
                                                        <span class="{{ $childMenu->is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-500/20' }} inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                                            {{ $childMenu->is_active ? __('활성') : __('비활성') }}
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap py-3 pl-3 text-right">
                                                        <a href="{{ route('admin.menus.show', $childMenu) }}" class="text-sm font-semibold !text-indigo-600 hover:!text-indigo-500 hover:no-underline dark:!text-indigo-400">{{ __('보기') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 dark:border-gray-700 dark:bg-gray-800/70">
                    <div class="flex justify-end">
                        <div class="flex flex-wrap justify-end gap-2">
                            @can('update', $menu)
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                    {{ __('수정하기') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
