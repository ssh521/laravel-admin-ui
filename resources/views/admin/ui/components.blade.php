@php
    $currentStyle = config('laravel-admin-ui.style', 'yaverstyle');
    $componentAction = \Illuminate\Support\Facades\Route::has('admin.ui.components')
        ? route('admin.ui.components')
        : url('/admin/ui/components');

    $sections = [
        'Page And Layout' => [
            ['name' => 'admin.layouts.admin', 'description' => '관리자 전체 layout shell', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.page-header', 'description' => 'breadcrumb, 제목, 설명, action slot', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.page-section', 'description' => '관리자 페이지 기본 캔버스', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.card', 'description' => '제목/본문/footer가 있는 bordered surface', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.tabs', 'description' => '하위 섹션 탭', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.accordion', 'description' => '접고 펼치는 상세 그룹', 'coverage' => 'yaverstyle'],
        ],
        'Actions And Menus' => [
            ['name' => 'admin.action-button', 'description' => 'primary, secondary, danger, search, link action', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.primary-button', 'description' => 'legacy primary submit button', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.secondary-button', 'description' => 'legacy secondary button', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.danger-button', 'description' => 'legacy destructive button', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.dropdown', 'description' => 'compact command menu', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.action-menu', 'description' => '행 작업 dropdown', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.confirm-dialog', 'description' => '삭제/위험 작업 확인', 'coverage' => 'yaverstyle'],
        ],
        'Lists And Tables' => [
            ['name' => 'admin.filter-bar', 'description' => '목록 검색/필터 wrapper', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.search-input', 'description' => '검색 input + clear link', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.filter-select', 'description' => '목록 필터 select', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.table-shell', 'description' => 'responsive table wrapper', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.table-empty-row', 'description' => 'tbody 내부 empty row', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.empty-state', 'description' => '표 밖의 빈 상태', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.pagination', 'description' => 'simple paginator', 'coverage' => 'yaverstyle'],
        ],
        'Forms' => [
            ['name' => 'admin.form-section', 'description' => '12-column form section', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.field', 'description' => 'label/help/error wrapper', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.form-input', 'description' => '기본 input', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.form-select', 'description' => 'select control', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.form-textarea', 'description' => 'textarea control', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.checkbox-row', 'description' => 'bordered checkbox row', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.checkbox-card', 'description' => '카드형 checkbox option', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.radio-card', 'description' => '카드형 radio option', 'coverage' => 'yaverstyle'],
        ],
        'Data And Feedback' => [
            ['name' => 'admin.badge', 'description' => 'status label', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.status-dot', 'description' => '작은 점 + label 상태', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.stat', 'description' => 'dashboard metric', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.description-list', 'description' => 'detail dl/dt/dd list', 'coverage' => 'yaverstyle'],
            ['name' => 'admin.key-value-grid', 'description' => 'compact detail grid', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.notice', 'description' => '정적인 안내 box', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.alert', 'description' => 'alert surface', 'coverage' => 'yaverstyle, daisystyle'],
            ['name' => 'admin.session-messages', 'description' => 'session message renderer', 'coverage' => 'yaverstyle'],
        ],
    ];

    $styleOptions = ['yaverstyle' => 'yaverstyle', 'daisystyle' => 'daisystyle'];
    $componentRows = collect($sections)
        ->flatMap(fn ($items, $section) => collect($items)->map(fn ($item) => $item + ['section' => $section]))
        ->values();
@endphp

<x-laravel-admin::admin.layouts.admin title="UI 컴포넌트">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ \Illuminate\Support\Facades\Route::has('admin.index') ? route('admin.index') : url('/admin') }}">관리자 홈</a>
            </x-slot>
            <x-slot name="description">
                {{ __('UI 컴포넌트') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('UI 컴포넌트') }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('관리자 화면에서 사용하는 공용 컴포넌트와 현재 스타일 적용 상태를 확인합니다.') }}
                    </p>
                </div>
                <div class="mt-4 flex flex-wrap gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <x-laravel-admin::admin.badge variant="primary">현재 스타일: {{ $currentStyle }}</x-laravel-admin::admin.badge>
                    <x-laravel-admin::admin.badge variant="success">{{ $componentRows->count() }}개 컴포넌트</x-laravel-admin::admin.badge>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form method="GET" action="{{ $componentAction }}" class="mt-6 grid gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:grid-cols-[minmax(0,180px)_minmax(0,1fr)_auto] sm:items-center dark:border-gray-700 dark:bg-gray-800/70">
                <label for="component-style" class="sr-only">{{ __('스타일') }}</label>
                <x-laravel-admin::admin.form-select id="component-style" name="style" class="h-10" disabled>
                    @foreach ($styleOptions as $styleValue => $styleLabel)
                        <option value="{{ $styleValue }}" @selected($currentStyle === $styleValue)>{{ $styleLabel }}</option>
                    @endforeach
                </x-laravel-admin::admin.form-select>

                <label for="component-search" class="sr-only">{{ __('컴포넌트 검색') }}</label>
                <x-laravel-admin::admin.form-input
                    id="component-search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('컴포넌트 검색') }}"
                    class="h-10"
                />

                <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-gray-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    <x-laravel-admin::admin.icon name="magnifying-glass" class="mr-2 text-xs" />
                    {{ __('검색') }}
                </button>
            </form>

            <div class="mt-6 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h2 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ __('현재 스타일 미리보기') }}</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('아래 예시는 x-laravel-admin::admin.* dispatcher를 통해 현재 스타일로 렌더링됩니다.') }}
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-laravel-admin::admin.action-button icon="plus">등록하기</x-laravel-admin::admin.action-button>
                        <x-laravel-admin::admin.action-button variant="secondary" icon="arrow-left">목록</x-laravel-admin::admin.action-button>
                        <x-laravel-admin::admin.action-button variant="danger" icon="trash">삭제하기</x-laravel-admin::admin.action-button>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-laravel-admin::admin.badge>대기</x-laravel-admin::admin.badge>
                        <x-laravel-admin::admin.badge variant="primary">기본</x-laravel-admin::admin.badge>
                        <x-laravel-admin::admin.badge variant="success">활성</x-laravel-admin::admin.badge>
                        <x-laravel-admin::admin.badge variant="warning">검토</x-laravel-admin::admin.badge>
                        <x-laravel-admin::admin.badge variant="danger">중지</x-laravel-admin::admin.badge>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h2 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ __('스타일 전환 기준') }}</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('호스트 앱에서 LARAVEL_ADMIN_UI_STYLE 값을 바꾸면 같은 admin.* 컴포넌트가 yaverstyle 또는 daisystyle 구현으로 표시됩니다.') }}
                    </p>
                    <dl class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                        <div>
                            <dt class="font-medium text-gray-900 dark:text-white">yaverstyle</dt>
                            <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ __('기본 Tailwind 기반 fallback 스타일') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900 dark:text-white">daisystyle</dt>
                            <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ __('DaisyUI class 기반 대체 스타일') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">{{ __('그룹') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('컴포넌트') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">{{ __('역할') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">{{ __('스타일 구현') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse ($componentRows as $componentMeta)
                                    @continue(request('search') && ! str_contains($componentMeta['name'].' '.$componentMeta['description'].' '.$componentMeta['section'], request('search')))
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-4 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $componentMeta['section'] }}</div>
                                            <div class="mt-1 text-gray-500 md:hidden dark:text-gray-400">{{ $componentMeta['description'] }}</div>
                                            <div class="mt-2 flex flex-wrap gap-1 sm:hidden">
                                                @foreach (explode(', ', $componentMeta['coverage']) as $styleName)
                                                    <x-laravel-admin::admin.badge variant="{{ $styleName === $currentStyle ? 'success' : 'neutral' }}">{{ $styleName }}</x-laravel-admin::admin.badge>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            <code>{{ $componentMeta['name'] }}</code>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell dark:text-gray-400">
                                            {{ $componentMeta['description'] }}
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm sm:table-cell">
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach (explode(', ', $componentMeta['coverage']) as $styleName)
                                                    <x-laravel-admin::admin.badge variant="{{ $styleName === $currentStyle ? 'success' : 'neutral' }}">{{ $styleName }}</x-laravel-admin::admin.badge>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-16 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('표시할 컴포넌트가 없습니다.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
