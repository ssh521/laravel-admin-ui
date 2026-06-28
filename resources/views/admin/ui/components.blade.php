<x-laravel-admin::admin.layouts.admin title="UI 컴포넌트">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
            </x-slot>
            <x-slot name="description">
                UI 컴포넌트
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <x-laravel-admin::admin.page-section title="UI 컴포넌트" description="현재 스타일: {{ config('laravel-admin-ui.style', 'yaverstyle') }}">
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="space-y-4">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">액션</h2>

                <div class="flex flex-wrap gap-2">
                    <x-laravel-admin::admin.action-button icon="plus">등록하기</x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button variant="secondary" icon="arrow-left">목록</x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button variant="danger" icon="trash">삭제</x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button variant="link" href="#component-table" icon="eye">상세보기</x-laravel-admin::admin.action-button>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-laravel-admin::admin.badge>대기</x-laravel-admin::admin.badge>
                    <x-laravel-admin::admin.badge variant="primary">기본</x-laravel-admin::admin.badge>
                    <x-laravel-admin::admin.badge variant="success">활성</x-laravel-admin::admin.badge>
                    <x-laravel-admin::admin.badge variant="warning">검토</x-laravel-admin::admin.badge>
                    <x-laravel-admin::admin.badge variant="danger">중지</x-laravel-admin::admin.badge>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">폼</h2>

                <div class="grid gap-3 sm:grid-cols-2">
                    <x-laravel-admin::admin.form-input name="component_name" value="관리자 메뉴" aria-label="컴포넌트 이름" />
                    <x-laravel-admin::admin.form-select name="status" aria-label="상태">
                        <option>전체</option>
                        <option>활성</option>
                        <option>비활성</option>
                    </x-laravel-admin::admin.form-select>
                </div>

                <x-laravel-admin::admin.form-textarea name="memo" aria-label="메모">관리자 화면 기본 문구는 한국어를 유지합니다.</x-laravel-admin::admin.form-textarea>

                <x-laravel-admin::admin.checkbox-row title="목록에 표시" description="선택한 항목을 관리자 목록에 노출합니다.">
                    <input type="checkbox" checked class="checkbox checkbox-primary mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </x-laravel-admin::admin.checkbox-row>
            </div>
        </div>

        <x-laravel-admin::admin.filter-bar action="{{ route('admin.ui.components') }}">
            <x-laravel-admin::admin.form-input name="search" placeholder="검색어" aria-label="검색어" />
            <x-laravel-admin::admin.form-select name="type" aria-label="유형" class="sm:max-w-48">
                <option>전체 유형</option>
                <option>액션</option>
                <option>폼</option>
            </x-laravel-admin::admin.form-select>
            <x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass">검색</x-laravel-admin::admin.action-button>
        </x-laravel-admin::admin.filter-bar>

        <div id="component-table" class="mt-6">
            <x-laravel-admin::admin.table-shell>
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">컴포넌트</th>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">상태</th>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">예시</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">action-button</td>
                            <td class="px-4 py-3"><x-laravel-admin::admin.badge variant="success">적용</x-laravel-admin::admin.badge></td>
                            <td class="px-4 py-3"><x-laravel-admin::admin.action-button size="sm">저장</x-laravel-admin::admin.action-button></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">form-input</td>
                            <td class="px-4 py-3"><x-laravel-admin::admin.badge variant="primary">기본</x-laravel-admin::admin.badge></td>
                            <td class="px-4 py-3"><x-laravel-admin::admin.form-input value="sample@example.com" aria-label="이메일 예시" /></td>
                        </tr>
                    </tbody>
                </table>
            </x-laravel-admin::admin.table-shell>
        </div>

        <div class="mt-6">
            <x-laravel-admin::admin.empty-state title="표시할 항목이 없습니다." description="조건을 변경한 뒤 다시 확인하세요." icon="folder-open" />
        </div>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
