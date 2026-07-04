<?php

namespace Ssh521\LaravelAdminUi\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Ssh521\LaravelAdminUi\LaravelAdminUiServiceProvider;
use Ssh521\LaravelAdminUi\Tests\TestCase;

class LaravelAdminUiServiceProviderTest extends TestCase
{
    public function test_it_registers_admin_view_locations_and_component_namespace(): void
    {
        $this->assertFalse(View::exists('admin.index'));
        $this->assertFalse(View::exists('livewire.admin.header-nav'));
        $this->assertTrue(View::exists('laravel-admin::admin.index'));
        $this->assertTrue(View::exists('laravel-admin::livewire.admin.header-nav'));
        $this->assertTrue(View::exists('laravel-admin::partials.assets'));
        $this->assertTrue(View::exists('laravel-admin::errors.403'));

        $html = Blade::render('<x-laravel-admin::admin.primary-button>Save</x-laravel-admin::admin.primary-button>');

        $this->assertStringContainsString('Save', $html);
        $this->assertStringContainsString('<button', $html);
    }

    public function test_it_renders_the_packaged_403_error_page(): void
    {
        Route::get('/forbidden', fn () => abort(403));

        $this->get('/forbidden')
            ->assertStatus(403)
            ->assertSee('403 Forbidden')
            ->assertSee('접근 권한이 없습니다.')
            ->assertSee('현재 계정으로는 이 페이지에 접근할 수 없습니다.');
    }

    public function test_it_registers_ui_specific_publish_tags(): void
    {
        $this->assertPublishesTo('laravel-admin-ui-views', resource_path('views/vendor/laravel-admin'));
        $this->assertPublishesTo('laravel-admin-ui-components', resource_path('views/vendor/laravel-admin/components'));
        $this->assertPublishesTo('laravel-admin-ui-assets', resource_path('vendor/laravel-admin/admin.css'));
        $this->assertPublishesTo('laravel-admin-ui-assets', resource_path('vendor/laravel-admin'));
        $this->assertPublishesTo('laravel-admin-ui-assets', public_path('images/dtree'));
        $this->assertPublishesTo('laravel-admin-ui-config', config_path('laravel-admin-ui.php'));
    }

    public function test_it_registers_yaverstyle_as_the_default_component_style(): void
    {
        $this->assertSame('yaverstyle', config('laravel-admin-ui.style'));

        $html = Blade::render('<x-laravel-admin::admin.action-button>Save</x-laravel-admin::admin.action-button>');

        $this->assertStringContainsString('bg-indigo-600', $html);
    }

    public function test_it_can_render_components_with_the_daisyui_style_folder(): void
    {
        config(['laravel-admin-ui.style' => 'daisystyle']);

        $button = Blade::render('<x-laravel-admin::admin.action-button variant="danger">삭제</x-laravel-admin::admin.action-button>');
        $badge = Blade::render('<x-laravel-admin::admin.badge variant="success">활성</x-laravel-admin::admin.badge>');
        $infoBadge = Blade::render('<x-laravel-admin::admin.badge variant="info">관리자</x-laravel-admin::admin.badge>');
        $input = Blade::render('<x-laravel-admin::admin.form-input name="name" />');
        $primaryButton = Blade::render('<x-laravel-admin::admin.primary-button>저장</x-laravel-admin::admin.primary-button>');
        $card = Blade::render('<x-laravel-admin::admin.card title="카드">본문</x-laravel-admin::admin.card>');
        $filterSelect = Blade::render('<x-laravel-admin::admin.filter-select name="status" placeholder="전체" :options="$options" />', [
            'options' => ['active' => '활성'],
        ]);
        $searchInput = Blade::render('<x-laravel-admin::admin.search-input name="q" value="admin" clear-href="/admin" />');
        $stat = Blade::render('<x-laravel-admin::admin.stat label="회원" value="120" />');
        $notice = Blade::render('<x-laravel-admin::admin.notice type="warning" title="주의" />');
        $fallback = Blade::render('<x-laravel-admin::admin.action-menu><button>열기</button></x-laravel-admin::admin.action-menu>');

        $this->assertStringContainsString('btn', $button);
        $this->assertStringContainsString('btn-error', $button);
        $this->assertStringContainsString('badge-success', $badge);
        $this->assertStringContainsString('badge-info', $infoBadge);
        $this->assertStringContainsString('input input-bordered', $input);
        $this->assertStringContainsString('btn-primary', $primaryButton);
        $this->assertStringContainsString('card', $card);
        $this->assertStringContainsString('select select-bordered', $filterSelect);
        $this->assertStringContainsString('input input-bordered', $searchInput);
        $this->assertStringContainsString('stat-value', $stat);
        $this->assertStringContainsString('alert-warning', $notice);
        $this->assertStringContainsString('작업 메뉴', $fallback);
    }

    public function test_icon_component_logs_unknown_icon_names_and_renders_warning_icon(): void
    {
        Log::shouldReceive('warning')
            ->once()
            ->with('Unknown laravel-admin icon name.', ['name' => 'legacy-icon']);

        $html = Blade::render('<x-laravel-admin::admin.icon name="legacy-icon" />');

        $this->assertStringContainsString('M12 9v4m0 4h.01', $html);
    }

    public function test_icon_component_maps_font_awesome_classes_without_dependency(): void
    {
        Log::shouldReceive('warning')->never();

        $html = Blade::render('<x-laravel-admin::admin.icon name="fas fa-home" class="text-xs" />');

        $this->assertStringContainsString('<svg', $html);
        $this->assertStringContainsString('m3 10.5 9-7.5 9 7.5', $html);
        $this->assertStringContainsString('text-xs', $html);
    }

    public function test_admin_reusable_components_render_contract_classes(): void
    {
        $button = Blade::render('<x-laravel-admin::admin.action-button href="/admin" icon="plus">등록하기</x-laravel-admin::admin.action-button>');
        $secondary = Blade::render('<x-laravel-admin::admin.action-button variant="secondary">목록</x-laravel-admin::admin.action-button>');
        $danger = Blade::render('<x-laravel-admin::admin.action-button variant="danger">삭제하기</x-laravel-admin::admin.action-button>');
        $search = Blade::render('<x-laravel-admin::admin.action-button variant="search">검색</x-laravel-admin::admin.action-button>');
        $badge = Blade::render('<x-laravel-admin::admin.badge variant="success">활성</x-laravel-admin::admin.badge>');
        $infoBadge = Blade::render('<x-laravel-admin::admin.badge variant="info">관리자</x-laravel-admin::admin.badge>');
        $emptyState = Blade::render('<x-laravel-admin::admin.empty-state title="비어 있음" description="표시할 항목이 없습니다." icon="folder-open" />');
        $filterBar = Blade::render('<x-laravel-admin::admin.filter-bar action="/admin"><input name="search"></x-laravel-admin::admin.filter-bar>');
        $tableShell = Blade::render('<x-laravel-admin::admin.table-shell><table><tbody><tr><td>row</td></tr></tbody></table></x-laravel-admin::admin.table-shell>');
        $pageSection = Blade::render('<x-laravel-admin::admin.page-section title="권한 목록" description="권한을 관리합니다.">본문</x-laravel-admin::admin.page-section>');
        $input = Blade::render('<x-laravel-admin::admin.form-input name="name" />');
        $select = Blade::render('<x-laravel-admin::admin.form-select name="role"><option>Admin</option></x-laravel-admin::admin.form-select>');
        $textarea = Blade::render('<x-laravel-admin::admin.form-textarea name="description">설명</x-laravel-admin::admin.form-textarea>');
        $checkboxRow = Blade::render('<x-laravel-admin::admin.checkbox-row title="활성화"><input type="checkbox"></x-laravel-admin::admin.checkbox-row>');
        $dropdown = Blade::render('<x-laravel-admin::admin.dropdown><x-slot name="trigger"><button>열기</button></x-slot><x-slot name="content"><x-laravel-admin::admin.dropdown-link href="/admin">관리자</x-laravel-admin::admin.dropdown-link></x-slot></x-laravel-admin::admin.dropdown>');
        $accordion = Blade::render('<x-laravel-admin::admin.accordion title="상세 정보" open>내용</x-laravel-admin::admin.accordion>');
        $card = Blade::render('<x-laravel-admin::admin.card title="카드" description="설명"><x-slot name="actions">액션</x-slot>본문<x-slot name="footer">푸터</x-slot></x-laravel-admin::admin.card>');
        $field = Blade::render('<x-laravel-admin::admin.field name="email" label="이메일" help="업무용 이메일" required><input id="email"></x-laravel-admin::admin.field>');
        $formSection = Blade::render('<x-laravel-admin::admin.form-section title="기본 정보" description="필수 입력">필드</x-laravel-admin::admin.form-section>');
        $descriptionList = Blade::render('<x-laravel-admin::admin.description-list :items="$items" />', [
            'items' => ['상태' => '활성'],
        ]);
        $tabs = Blade::render('<x-laravel-admin::admin.tabs active="profile" :items="$items" />', [
            'items' => [
                'profile' => ['label' => '프로필', 'href' => '/profile'],
                'security' => '보안',
            ],
        ]);
        $confirmDialog = Blade::render('<x-laravel-admin::admin.confirm-dialog title="삭제 확인" description="정말 삭제할까요?"><x-slot name="trigger"><button>삭제</button></x-slot></x-laravel-admin::admin.confirm-dialog>');
        $toast = Blade::render('<x-laravel-admin::admin.toast type="success" title="저장됨" message="변경사항이 저장되었습니다." dismissible />');
        $pagination = Blade::render('<x-laravel-admin::admin.pagination>페이지 없음</x-laravel-admin::admin.pagination>');
        $stat = Blade::render('<x-laravel-admin::admin.stat label="회원" value="120" description="이번 달" />');
        $drawer = Blade::render('<x-laravel-admin::admin.drawer title="필터"><x-slot name="trigger"><button>열기</button></x-slot>내용</x-laravel-admin::admin.drawer>');
        $breadcrumb = Blade::render('<x-laravel-admin::admin.breadcrumb :items="$items" />', [
            'items' => [
                ['label' => '관리자', 'href' => '/admin'],
                ['label' => '회원', 'active' => true],
            ],
        ]);
        $avatar = Blade::render('<x-laravel-admin::admin.avatar name="Admin User" size="lg" />');
        $progress = Blade::render('<x-laravel-admin::admin.progress label="업로드" value="25" max="100" />');
        $stepper = Blade::render('<x-laravel-admin::admin.stepper active="review" :items="$items" />', [
            'items' => ['draft' => '작성', 'review' => '검토'],
        ]);
        $timeline = Blade::render('<x-laravel-admin::admin.timeline :items="$items" />', [
            'items' => [
                ['title' => '생성됨', 'meta' => '오늘', 'body' => '관리자가 생성했습니다.'],
            ],
        ]);
        $skeleton = Blade::render('<x-laravel-admin::admin.skeleton height="2rem" width="50%" />');
        $fileUpload = Blade::render('<x-laravel-admin::admin.file-upload name="attachment" label="첨부파일" help="PDF만 가능" accept="application/pdf" />');
        $radioCard = Blade::render('<x-laravel-admin::admin.radio-card name="type" value="admin" title="관리자" description="관리 권한" checked />');
        $checkboxCard = Blade::render('<x-laravel-admin::admin.checkbox-card name="permissions[]" value="edit" title="수정" description="수정 권한" checked />');
        $bulkActionBar = Blade::render('<x-laravel-admin::admin.bulk-action-bar count="3"><x-laravel-admin::admin.action-button variant="danger">삭제</x-laravel-admin::admin.action-button></x-laravel-admin::admin.bulk-action-bar>');
        $searchInput = Blade::render('<x-laravel-admin::admin.search-input name="q" value="admin" placeholder="검색어" clear-href="/admin" />');
        $filterSelect = Blade::render('<x-laravel-admin::admin.filter-select name="status" label="상태" selected="active" placeholder="전체" :options="$options" />', [
            'options' => ['active' => '활성', 'inactive' => '비활성'],
        ]);
        $dateRange = Blade::render('<x-laravel-admin::admin.date-range from="2026-06-01" to="2026-06-27" />');
        $copyButton = Blade::render('<x-laravel-admin::admin.copy-button value="token-123" />');
        $codeBlock = Blade::render('<x-laravel-admin::admin.code-block title="응답" language="json">{ "ok": true }</x-laravel-admin::admin.code-block>');
        $kbd = Blade::render('<x-laravel-admin::admin.kbd>⌘K</x-laravel-admin::admin.kbd>');
        $divider = Blade::render('<x-laravel-admin::admin.divider />');
        $statusDot = Blade::render('<x-laravel-admin::admin.status-dot variant="success" label="활성" />');
        $userCell = Blade::render('<x-laravel-admin::admin.user-cell name="Admin User" email="admin@example.com" />');
        $actionMenu = Blade::render('<x-laravel-admin::admin.action-menu><x-laravel-admin::admin.dropdown-link href="/edit">수정</x-laravel-admin::admin.dropdown-link></x-laravel-admin::admin.action-menu>');
        $tableEmptyRow = Blade::render('<table><tbody><x-laravel-admin::admin.table-empty-row colspan="3" message="데이터 없음" /></tbody></table>');
        $loadingOverlay = Blade::render('<x-laravel-admin::admin.loading-overlay show label="저장 중">본문</x-laravel-admin::admin.loading-overlay>');
        $notice = Blade::render('<x-laravel-admin::admin.notice type="warning" title="주의" message="삭제 전 확인하세요." />');
        $keyValueGrid = Blade::render('<x-laravel-admin::admin.key-value-grid :items="$items" />', [
            'items' => ['환경' => 'production'],
        ]);
        $sortControl = Blade::render('<x-laravel-admin::admin.sort-control sort="name" direction="desc" :fields="$fields" />', [
            'fields' => ['name' => '이름', 'created_at' => '생성일'],
        ]);
        $columnToggle = Blade::render('<x-laravel-admin::admin.column-toggle :columns="$columns" />', [
            'columns' => ['name' => '이름', 'email' => '이메일'],
        ]);
        $exportButton = Blade::render('<x-laravel-admin::admin.export-button :formats="$formats" />', [
            'formats' => ['/export.csv' => 'CSV'],
        ]);
        $inlineEdit = Blade::render('<x-laravel-admin::admin.inline-edit name="title" value="제목" action="/save" method="PATCH" />');
        $permissionMatrix = Blade::render('<x-laravel-admin::admin.permission-matrix :groups="$groups" :selected="$selected" />', [
            'groups' => ['회원' => ['users.edit' => '회원 수정']],
            'selected' => ['users.edit'],
        ]);
        $pageHeader = Blade::render('<x-laravel-admin::admin.page-header title="회원 관리" description="회원을 관리합니다." :breadcrumbs="$breadcrumbs"><x-slot name="actions">액션</x-slot></x-laravel-admin::admin.page-header>', [
            'breadcrumbs' => [['label' => '관리자', 'href' => '/admin'], ['label' => '회원']],
        ]);

        $this->assertStringContainsString('<a', $button);
        $this->assertStringContainsString('laravel-admin-action-button', $button);
        $this->assertStringContainsString('cursor-pointer', $button);
        $this->assertStringContainsString('bg-indigo-600', $button);
        $this->assertStringContainsString('!text-white', $button);
        $this->assertStringContainsString('dark:bg-indigo-500', $button);
        $this->assertStringContainsString('border-gray-300', $secondary);
        $this->assertStringContainsString('!text-gray-700', $secondary);
        $this->assertStringContainsString('!text-red-700', $danger);
        $this->assertStringContainsString('laravel-admin-search-button', $search);
        $this->assertStringContainsString('bg-green-50', $badge);
        $this->assertStringContainsString('dark:bg-green-500/10', $badge);
        $this->assertStringContainsString('bg-blue-50', $infoBadge);
        $this->assertStringContainsString('text-blue-700', $infoBadge);
        $this->assertStringContainsString('dark:bg-blue-500/10', $infoBadge);
        $this->assertStringContainsString('border-dashed', $emptyState);
        $this->assertStringContainsString('표시할 항목이 없습니다.', $emptyState);
        $this->assertStringContainsString('<form', $filterBar);
        $this->assertStringContainsString('filtersOpen', $filterBar);
        $this->assertStringContainsString('검색\/필터', $filterBar);
        $this->assertStringContainsString('sm:hidden', $filterBar);
        $this->assertStringContainsString('mt-3 hidden flex-col', $filterBar);
        $this->assertStringContainsString('sm:mt-6 sm:flex sm:flex-row', $filterBar);
        $this->assertStringContainsString("x-bind:class=\"{ '!flex': filtersOpen }\"", $filterBar);
        $this->assertStringContainsString('dark:bg-gray-800/70', $filterBar);
        $this->assertStringContainsString('overflow-x-auto', $tableShell);
        $this->assertStringContainsString('sm:min-h-64', $tableShell);
        $this->assertStringContainsString('권한 목록', $pageSection);
        $this->assertStringContainsString('dark:bg-gray-900', $pageSection);
        $this->assertStringContainsString('focus:border-indigo-500', $input);
        $this->assertStringContainsString('w-full', $input);
        $this->assertStringContainsString('<select', $select);
        $this->assertStringContainsString('<textarea', $textarea);
        $this->assertStringContainsString('활성화', $checkboxRow);
        $this->assertStringContainsString('rounded-md bg-white py-1', $dropdown);
        $this->assertStringContainsString('관리자', $dropdown);
        $this->assertStringContainsString('rounded-lg border border-gray-200', $accordion);
        $this->assertStringContainsString('상세 정보', $accordion);
        $this->assertStringContainsString('내용', $accordion);
        $this->assertStringContainsString('카드', $card);
        $this->assertStringContainsString('푸터', $card);
        $this->assertStringContainsString('업무용 이메일', $field);
        $this->assertStringContainsString('text-red-600', $field);
        $this->assertStringContainsString('기본 정보', $formSection);
        $this->assertStringContainsString('md:col-span-8', $formSection);
        $this->assertStringContainsString('상태', $descriptionList);
        $this->assertStringContainsString('활성', $descriptionList);
        $this->assertStringContainsString('프로필', $tabs);
        $this->assertStringContainsString('aria-current="page"', $tabs);
        $this->assertStringContainsString('삭제 확인', $confirmDialog);
        $this->assertStringContainsString('정말 삭제할까요?', $confirmDialog);
        $this->assertStringContainsString('저장됨', $toast);
        $this->assertStringContainsString('border-green-200', $toast);
        $this->assertStringContainsString('페이지 없음', $pagination);
        $this->assertStringContainsString('회원', $stat);
        $this->assertStringContainsString('120', $stat);
        $this->assertStringContainsString('필터', $drawer);
        $this->assertStringContainsString('max-w-md', $drawer);
        $this->assertStringContainsString('관리자', $breadcrumb);
        $this->assertStringContainsString('aria-current="page"', $breadcrumb);
        $this->assertStringContainsString('AU', $avatar);
        $this->assertStringContainsString('size-12', $avatar);
        $this->assertStringContainsString('업로드', $progress);
        $this->assertStringContainsString('width: 25%', $progress);
        $this->assertStringContainsString('검토', $stepper);
        $this->assertStringContainsString('step-primary', $stepper);
        $this->assertStringContainsString('생성됨', $timeline);
        $this->assertStringContainsString('관리자가 생성했습니다.', $timeline);
        $this->assertStringContainsString('animate-pulse', $skeleton);
        $this->assertStringContainsString('height: 2rem', $skeleton);
        $this->assertStringContainsString('첨부파일', $fileUpload);
        $this->assertStringContainsString('application/pdf', $fileUpload);
        $this->assertStringContainsString('type="radio"', $radioCard);
        $this->assertStringContainsString('관리 권한', $radioCard);
        $this->assertStringContainsString('type="checkbox"', $checkboxCard);
        $this->assertStringContainsString('수정 권한', $checkboxCard);
        $this->assertStringContainsString('3 선택됨', $bulkActionBar);
        $this->assertStringContainsString('삭제', $bulkActionBar);
        $this->assertStringContainsString('name="q"', $searchInput);
        $this->assertStringContainsString('검색어', $searchInput);
        $this->assertStringContainsString('상태', $filterSelect);
        $this->assertStringContainsString('selected', $filterSelect);
        $this->assertStringContainsString('2026-06-01', $dateRange);
        $this->assertStringContainsString('2026-06-27', $dateRange);
        $this->assertStringContainsString('token-123', $copyButton);
        $this->assertStringContainsString('navigator.clipboard', $copyButton);
        $this->assertStringContainsString('응답', $codeBlock);
        $this->assertStringContainsString('{ "ok": true }', $codeBlock);
        $this->assertStringContainsString('⌘K', $kbd);
        $this->assertStringContainsString('<hr', $divider);
        $this->assertStringContainsString('bg-green-500', $statusDot);
        $this->assertStringContainsString('admin@example.com', $userCell);
        $this->assertStringContainsString('작업 메뉴', $actionMenu);
        $this->assertStringContainsString('<circle cx="7" cy="12" r="1.35"', $actionMenu);
        $this->assertStringContainsString('size-10', $actionMenu);
        $this->assertStringContainsString('cursor-pointer', $actionMenu);
        $this->assertStringContainsString('[&amp;_*]:cursor-pointer', $actionMenu);
        $this->assertStringContainsString('size-7', $actionMenu);
        $this->assertStringContainsString('w-36', $actionMenu);
        $this->assertStringNotContainsString('rounded-xl bg-gray-50', $actionMenu);
        $this->assertStringContainsString('laravel-admin-action-menu-content overflow-hidden rounded-2xl border border-gray-200 bg-white p-2 shadow-xl', $actionMenu);
        $this->assertStringContainsString('updatePlacement()', $actionMenu);
        $this->assertStringContainsString("dropUp ? 'bottom-full mb-3 mt-0' : 'top-full mt-3 mb-0'", $actionMenu);
        $this->assertStringContainsString('z-[70]', $actionMenu);
        $this->assertStringNotContainsString('absolute z-50 rounded-md shadow-lg', $actionMenu);
        $this->assertStringContainsString('수정', $actionMenu);
        $this->assertStringContainsString('colspan="3"', $tableEmptyRow);
        $this->assertStringContainsString('데이터 없음', $tableEmptyRow);
        $this->assertStringContainsString('저장 중', $loadingOverlay);
        $this->assertStringContainsString('animate-spin', $loadingOverlay);
        $this->assertStringContainsString('주의', $notice);
        $this->assertStringContainsString('삭제 전 확인하세요.', $notice);
        $this->assertStringContainsString('환경', $keyValueGrid);
        $this->assertStringContainsString('production', $keyValueGrid);
        $this->assertStringContainsString('name="sort"', $sortControl);
        $this->assertStringContainsString('내림차순', $sortControl);
        $this->assertStringContainsString('컬럼', $columnToggle);
        $this->assertStringContainsString('이메일', $columnToggle);
        $this->assertStringContainsString('내보내기', $exportButton);
        $this->assertStringContainsString('/export.csv', $exportButton);
        $this->assertStringContainsString('name="title"', $inlineEdit);
        $this->assertStringContainsString('value="제목"', $inlineEdit);
        $this->assertStringContainsString('회원 수정', $permissionMatrix);
        $this->assertStringContainsString('checked', $permissionMatrix);
        $this->assertStringContainsString('회원 관리', $pageHeader);
        $this->assertStringContainsString('회원을 관리합니다.', $pageHeader);
    }

    public function test_menu_search_uses_full_icon_map_and_disposable_listeners(): void
    {
        $source = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/partials/header-menu-search.blade.php');

        $this->assertStringContainsString('AbortController', $source);
        $this->assertStringContainsString('disposeMenuSearches', $source);
        $this->assertStringContainsString('tags:', $source);
        $this->assertStringContainsString('lock:', $source);
        $this->assertStringContainsString('magnifying-glass', $source);
    }

    public function test_modal_stack_owns_drag_and_resize_contract(): void
    {
        $source = file_get_contents(__DIR__.'/../../resources/js/modal-stack.js');
        $view = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/modal-stack.blade.php');

        $this->assertStringContainsString('createDragHandler', $source);
        $this->assertStringContainsString('createResizeHandler', $source);
        $this->assertStringContainsString("Alpine.data('modalStackModal'", file_get_contents(__DIR__.'/../../resources/js/admin.js'));
        $this->assertStringContainsString('@livewire($modal[\'component\'], $modal[\'params\'], key($modal[\'key\']))', $view);
        $this->assertStringContainsString('wire:ignore.self', $view);
        $this->assertStringContainsString('x-on:mousedown.stop', $view);
        $this->assertStringContainsString('x-on:touchstart.stop', $view);
        $this->assertStringContainsString('wire:click="closeModal(\'{{ $modal[\'id\'] }}\')"', $view);
        $this->assertStringContainsString('rounded-full', $view);
        $this->assertStringContainsString('focus:ring-2 focus:ring-blue-500', $view);
        $this->assertStringContainsString('<x-laravel-admin::admin.icon name="xmark" class="size-4" />', $view);
    }

    public function test_menu_category_drag_sort_restores_cancelled_or_failed_reorders(): void
    {
        $index = file_get_contents(__DIR__.'/../../resources/views/admin/menu-categories/index.blade.php');

        $this->assertStringContainsString('x-data="menuCategoryDragSort()"', $index);
        $this->assertStringContainsString('class="drag-handle inline-flex size-8', $index);
        $this->assertStringContainsString(':draggable="sortMode === \'drag\'"', $index);
        $this->assertStringContainsString("const row = event.target.closest('tr[data-category-id]');", $index);
        $this->assertStringContainsString('this.draggedRow = row', $index);
        $this->assertStringNotContainsString('@dragstart="startDrag($event)"'.PHP_EOL.'                                        @dragover', $index);
        $this->assertStringNotContainsString('new Sortable', $index);
        $this->assertStringNotContainsString('Sortable.create', $index);

        $this->assertStringContainsString('originalOrder', $index);
        $this->assertStringContainsString('dropHandled', $index);
        $this->assertStringContainsString('restoreCategoryOrder', $index);
    }

    public function test_menu_categories_can_open_menu_order_modal_from_category_name(): void
    {
        $index = file_get_contents(__DIR__.'/../../resources/views/admin/menu-categories/index.blade.php');

        $this->assertStringContainsString('data-menu-order-category-id', $index);
        $this->assertStringContainsString('data-menu-order-category-name', $index);
        $this->assertStringContainsString('{{ $category->name }}', $index);
        $this->assertStringNotContainsString('<x-laravel-admin::admin.icon name="grip-lines" class="text-xs text-gray-400" />', $index);
        $this->assertStringContainsString('<livewire:admin.modal-stack />', $index);
        $this->assertStringContainsString("component: 'admin.menus.menu-order-modal'", $index);
        $this->assertStringContainsString("Livewire.dispatch('admin:modal-stack:push'", $index);
    }

    public function test_admin_users_search_uses_filter_bar_and_search_action_button(): void
    {
        $index = file_get_contents(__DIR__.'/../../resources/views/admin/admin-users/index.blade.php');

        $this->assertStringContainsString('<x-laravel-admin::admin.filter-bar', $index);
        $this->assertStringContainsString('x-data="{ filtersOpen: false }"', $index);
        $this->assertStringContainsString(':mobile-toggle="false"', $index);
        $this->assertStringContainsString('variant="secondary"', $index);
        $this->assertStringContainsString('class="sm:hidden"', $index);
        $this->assertStringContainsString('x-bind:aria-expanded="filtersOpen.toString()"', $index);
        $this->assertStringContainsString('@click="filtersOpen = ! filtersOpen"', $index);
        $this->assertStringContainsString('<x-laravel-admin::admin.action-button type="submit" variant="search"', $index);
        $this->assertStringContainsString('class="w-full shrink-0 sm:w-40"', $index);
        $this->assertStringContainsString('class="w-full shrink-0 whitespace-nowrap sm:w-auto"', $index);
        $this->assertStringContainsString('name="sortField"', $index);
        $this->assertStringContainsString('name="sortDirection"', $index);
        $this->assertStringContainsString("['sortField' => 'name', 'sortDirection' => \$getNextSortDirection('name')]", $index);
        $this->assertStringContainsString('name="{{ $currentSortDirection === \'asc\' ? \'arrow-up\' : \'arrow-down\' }}"', $index);
        $this->assertStringContainsString('<thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">', $index);
        $this->assertStringContainsString('class="py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 md:text-center dark:text-white"', $index);
        $this->assertStringContainsString('justify-start gap-1 !text-gray-900', $index);
        $this->assertStringContainsString('md:justify-center', $index);
        $this->assertStringContainsString('class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full', $index);
        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm text-gray-500 md:table-cell dark:text-gray-400"', $index);
        $this->assertStringContainsString('class="flex flex-wrap justify-center gap-1.5"', $index);
        $this->assertStringContainsString('<x-laravel-admin::admin.badge variant="info">{{ $role }}</x-laravel-admin::admin.badge>', $index);
        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm whitespace-nowrap sm:table-cell"', $index);
        $this->assertStringContainsString('class="py-3 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0"', $index);
        $this->assertStringNotContainsString('dark:bg-white dark:text-gray-900', $index);
    }

    public function test_users_tables_align_secondary_data_columns_to_center(): void
    {
        foreach ([
            'resources/views/admin/users/index.blade.php',
            'resources/views/livewire/admin/users/user-table.blade.php',
        ] as $relativePath) {
            $source = file_get_contents(__DIR__.'/../../'.$relativePath);

            $this->assertStringContainsString('sortField', $source);
            $this->assertStringContainsString('sortDirection', $source);
            $this->assertStringContainsString('name', $source);
            $this->assertStringContainsString('email', $source);
            $this->assertStringContainsString('created_at', $source);
            $this->assertStringContainsString('py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 md:text-center dark:text-white', $source);
            $this->assertStringContainsString('justify-start gap-1', $source);
            $this->assertStringContainsString('md:justify-center', $source);
            $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white"', $source);
            $this->assertStringContainsString('class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 md:table-cell dark:text-gray-300"', $source);
            if ($relativePath === 'resources/views/admin/users/index.blade.php') {
                $this->assertStringContainsString('class="whitespace-nowrap px-3 py-3 text-center text-sm"', $source);
            } else {
                $this->assertStringContainsString('class="hidden whitespace-nowrap px-3 py-3 text-center text-sm sm:table-cell"', $source);
            }
            $this->assertStringContainsString('class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-500 lg:table-cell dark:text-gray-400"', $source);
            $this->assertStringContainsString('class="whitespace-nowrap py-3 pr-4 pl-3 text-right text-sm font-medium sm:pr-0"', $source);
        }
    }

    public function test_menus_table_aligns_secondary_data_columns_to_center(): void
    {
        $source = file_get_contents(__DIR__.'/../../resources/views/admin/menus/index.blade.php');

        $this->assertStringContainsString('name="sort"', $source);
        $this->assertStringContainsString('name="direction"', $source);
        $this->assertStringContainsString("['sort' => 'name', 'direction' => \$getNextDirection('name')]", $source);
        $this->assertStringContainsString("['sort' => 'category', 'direction' => \$getNextDirection('category')]", $source);
        $this->assertStringContainsString("['sort' => 'route_name', 'direction' => \$getNextDirection('route_name')]", $source);
        $this->assertStringContainsString("['sort' => 'is_active', 'direction' => \$getNextDirection('is_active')]", $source);
        $this->assertStringContainsString('class="{{ $sortLinkClass }}"', $source);
        $this->assertStringContainsString('identitySortLinkClass', $source);
        $this->assertStringContainsString('px-3 py-3 text-left text-sm font-semibold text-gray-900 md:text-center dark:text-white', $source);
        $this->assertStringContainsString('justify-start gap-1 !text-gray-900', $source);
        $this->assertStringContainsString('md:justify-center', $source);
        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white"', $source);
        $this->assertStringContainsString('class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 md:table-cell dark:text-gray-300"', $source);
        $this->assertStringContainsString('class="hidden max-w-xs px-3 py-3 text-center text-sm text-gray-600 lg:table-cell dark:text-gray-300"', $source);
        $this->assertStringContainsString('class="whitespace-nowrap px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white"', $source);
        $this->assertStringContainsString('class="whitespace-nowrap px-3 py-3 text-center text-sm"', $source);
        $this->assertStringContainsString('class="whitespace-nowrap py-3 pr-4 pl-3 text-right text-sm font-medium sm:pr-0"', $source);
    }

    public function test_permissions_table_aligns_secondary_data_columns_to_center(): void
    {
        $source = file_get_contents(__DIR__.'/../../resources/views/admin/permissions/index.blade.php');

        $this->assertStringContainsString('class="py-3 pr-3 pl-3 text-center text-sm font-semibold text-gray-900 dark:text-white"', $source);
        $this->assertStringContainsString('class="py-3 pr-3 pl-3 text-left text-sm"', $source);
        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white"', $source);
        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm text-gray-500 md:table-cell dark:text-gray-400"', $source);
        $this->assertStringContainsString('class="py-3 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0"', $source);
    }

    public function test_menu_categories_tables_align_secondary_data_columns_to_center(): void
    {
        $index = file_get_contents(__DIR__.'/../../resources/views/admin/menu-categories/index.blade.php');
        $managerModal = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/menu-categories/menu-category-manager-modal.blade.php');

        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white"', $index);
        $this->assertStringContainsString('class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 md:table-cell dark:text-gray-300"', $index);
        $this->assertStringContainsString('name="sort"', $index);
        $this->assertStringContainsString('name="direction"', $index);
        $this->assertStringContainsString("['sort' => 'name', 'direction' => \$getNextDirection('name')]", $index);
        $this->assertStringContainsString("['sort' => 'menus_count', 'direction' => \$getNextDirection('menus_count')]", $index);
        $this->assertStringContainsString("['sort' => 'is_active', 'direction' => \$getNextDirection('is_active')]", $index);
        $this->assertStringContainsString("['sort' => 'created_at', 'direction' => \$getNextDirection('created_at')]", $index);
        $this->assertStringContainsString("{{ __('권한 수정') }}", $index);
        $this->assertStringContainsString('class="whitespace-nowrap px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white"', $index);
        $this->assertStringContainsString('onclick="openMenuCategoryRolesModal({{ $category->id }}, @js($category->name))"', $index);
        $this->assertMatchesRegularExpression("/\\{\\{ __\\('허용 역할'\\) \\}\\}.*\\{\\{ __\\('권한 수정'\\) \\}\\}/s", $index);
        $this->assertStringContainsString('class="hidden px-3 py-3 text-center text-sm xl:table-cell"', $index);
        $this->assertStringContainsString('class="flex flex-wrap justify-center gap-1.5"', $index);
        $this->assertStringNotContainsString(">{{ __('정렬 순서') }}</th>", $index);
        $this->assertStringNotContainsString('{{ $category->id }}</td>', $index);
        $this->assertStringContainsString('colspan="8"', $index);

        $this->assertStringContainsString('메뉴 카테고리 관리', $managerModal);
        $this->assertStringContainsString('역할 관리', $managerModal);
        $this->assertMatchesRegularExpression('/허용된 역할 없음.*역할 관리/s', $managerModal);
        $this->assertStringNotContainsString('<span class="sr-only">Edit</span>', $managerModal);
        $this->assertStringContainsString('class="mt-3 flex flex-wrap gap-1.5"', $managerModal);
        $this->assertStringNotContainsString('정렬 순서', $managerModal);
        $this->assertStringNotContainsString('{{ $category->id }}</td>', $managerModal);
        $this->assertStringContainsString('wire:click="openRolesModal({{ $category->id }})"', $managerModal);

        $show = file_get_contents(__DIR__.'/../../resources/views/admin/menu-categories/show.blade.php');

        $this->assertStringNotContainsString("{{ __('ID') }}", $show);
        $this->assertStringNotContainsString("{{ __('정렬 순서') }}", $show);
        $this->assertStringNotContainsString('{{ $menuCategory->sort_order }}', $show);
    }

    public function test_admin_table_contract_is_documented_and_applied_to_packaged_tables(): void
    {
        $contract = file_get_contents(__DIR__.'/../../docs/admin-ui-design-contract.md');
        $rules = file_get_contents(__DIR__.'/../../docs/admin-design-rules.md');

        $this->assertStringContainsString('Render table headers as a quiet header band', $contract);
        $this->assertStringContainsString('Align the first visible identity column header with the identity cell content on mobile', $contract);
        $this->assertStringContainsString('Do not expose technical identifiers or generated ordering values', $contract);
        $this->assertStringContainsString('For ordinary sortable list pages, make sortable column titles direct links', $contract);
        $this->assertStringContainsString('Render table row commands through `x-laravel-admin::admin.action-menu`', $contract);
        $this->assertStringContainsString('minimum desktop/tablet table-scroller height', $contract);
        $this->assertStringContainsString('collapse `filter-bar` by default', $contract);
        $this->assertStringContainsString('immediate light background before child slots finish rendering', $contract);
        $this->assertStringContainsString('variant="info"', $contract);
        $this->assertStringContainsString('default admin theme state is light', $contract);
        $this->assertStringContainsString('mobile left menu backdrop must use `x-cloak`', $contract);
        $this->assertStringContainsString('compact vertical rhythm with `py-3`', $rules);
        $this->assertStringContainsString('Table rows with multiple record commands should use `admin.action-menu`', $rules);
        $this->assertStringContainsString('minimum table-scroller height', $rules);
        $this->assertStringContainsString('collapse the filter bar by default', $rules);
        $this->assertStringContainsString('Default to light mode when no saved `theme` exists', $rules);
        $this->assertStringContainsString('Use `x-cloak` on Alpine-controlled full-screen overlays', $rules);
        $this->assertStringContainsString('Do not expose technical identifiers or generated ordering values', $rules);
        $this->assertStringContainsString('For ordinary sortable list pages, use clickable column titles', $rules);

        foreach ([
            'resources/views/admin/admin-users/index.blade.php',
            'resources/views/admin/users/index.blade.php',
            'resources/views/livewire/admin/users/user-table.blade.php',
            'resources/views/admin/permissions/index.blade.php',
            'resources/views/admin/menus/index.blade.php',
            'resources/views/admin/menu-categories/index.blade.php',
            'resources/views/admin/ui/components.blade.php',
        ] as $relativePath) {
            $source = file_get_contents(__DIR__.'/../../'.$relativePath);

            $this->assertStringContainsString('border-y border-gray-200 bg-gray-50', $source, "{$relativePath} should use the shared table header band.");
            $this->assertStringNotContainsString('py-3.5', $source, "{$relativePath} should use compact table header padding.");
            $this->assertStringNotContainsString('px-3 py-4', $source, "{$relativePath} should use compact table body padding.");
            $this->assertStringNotContainsString('whitespace-nowrap py-4', $source, "{$relativePath} should use compact table body padding.");
        }

        foreach ([
            'resources/views/admin/admin-users/index.blade.php',
            'resources/views/admin/menus/index.blade.php',
            'resources/views/admin/menu-categories/index.blade.php',
        ] as $relativePath) {
            $source = file_get_contents(__DIR__.'/../../'.$relativePath);

            $this->assertStringContainsString('overflow-x-auto sm:min-h-64', $source, "{$relativePath} should keep desktop row action menus away from the table edge.");
        }
    }

    public function test_packaged_table_row_actions_use_action_menus(): void
    {
        foreach ([
            'resources/views/admin/admin-users/index.blade.php',
            'resources/views/admin/users/index.blade.php',
            'resources/views/livewire/admin/users/user-table.blade.php',
            'resources/views/admin/permissions/index.blade.php',
            'resources/views/admin/menus/index.blade.php',
            'resources/views/admin/menu-categories/index.blade.php',
        ] as $relativePath) {
            $source = file_get_contents(__DIR__.'/../../'.$relativePath);

            $this->assertStringContainsString('<x-laravel-admin::admin.action-menu>', $source, "{$relativePath} should use the shared row action menu.");
            $this->assertStringContainsString('class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100"', $source, "{$relativePath} should render large dropdown-link action menu items.");
            $this->assertStringNotContainsString('class="block w-full rounded-lg px-6 py-1', $source, "{$relativePath} should reset native button styling for action menu buttons.");
            $this->assertStringNotContainsString('icon="eye" class="h-auto px-2 py-1"', $source, "{$relativePath} should not expose compact inline view buttons.");
            $this->assertStringNotContainsString('icon="pen-to-square" class="ml-1 h-auto px-2 py-1"', $source, "{$relativePath} should not expose compact inline edit buttons.");
        }

        foreach ([
            'resources/views/admin/users/index.blade.php',
            'resources/views/livewire/admin/users/user-table.blade.php',
        ] as $relativePath) {
            $source = file_get_contents(__DIR__.'/../../'.$relativePath);

            $this->assertStringContainsString('aria-hidden="true" class="my-1 border-t border-gray-200 dark:border-gray-700"', $source, "{$relativePath} should separate modal edit from link actions.");
        }
    }

    public function test_index_search_forms_use_consistent_search_action_buttons(): void
    {
        foreach ([
            'admin-users',
            'users',
            'roles',
            'permissions',
            'menus',
            'menu-categories',
        ] as $screen) {
            $index = file_get_contents(__DIR__."/../../resources/views/admin/{$screen}/index.blade.php");

            $this->assertStringContainsString('<x-laravel-admin::admin.filter-bar', $index, "{$screen} index should use the shared filter bar.");
            $this->assertStringContainsString('x-data="{ filtersOpen: false }"', $index, "{$screen} index should share one mobile filter toggle state.");
            $this->assertStringContainsString(':mobile-toggle="false"', $index, "{$screen} index should place the mobile filter toggle in the top action row.");
            $this->assertStringContainsString('x-bind:aria-expanded="filtersOpen.toString()"', $index, "{$screen} index should expose mobile filter toggle state.");
            $this->assertStringContainsString('@click="filtersOpen = ! filtersOpen"', $index, "{$screen} index should toggle the mobile filter bar from the action row.");
            $this->assertStringContainsString('<x-laravel-admin::admin.action-button type="submit" variant="search"', $index, "{$screen} index should use the shared search action button.");
            $this->assertStringContainsString('class="w-full shrink-0 whitespace-nowrap sm:w-auto"', $index, "{$screen} search button should not wrap or collapse.");
            $this->assertStringNotContainsString('dark:bg-white dark:text-gray-900', $index, "{$screen} index should not inline the old dark search button colors.");
        }
    }

    public function test_user_index_shows_email_verification_as_separate_column(): void
    {
        $index = file_get_contents(__DIR__.'/../../resources/views/admin/users/index.blade.php');

        $this->assertStringContainsString("{{ __('메일 인증') }}", $index);
        $this->assertStringContainsString('class="px-3 py-3 text-center text-sm font-semibold whitespace-nowrap text-gray-900 dark:text-white"', $index);
        $this->assertStringContainsString('class="whitespace-nowrap px-3 py-3 text-center text-sm"', $index);
        $this->assertStringNotContainsString('mt-1.5 sm:hidden', $index);
    }

    public function test_admin_action_buttons_do_not_use_hard_coded_action_styles(): void
    {
        $viewFiles = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(__DIR__.'/../../resources/views/admin')
        );

        foreach ($viewFiles as $file) {
            if (! $file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $path = $file->getPathname();
            $contents = file_get_contents($path);

            preg_match_all('/<(?:a|button)\b[^>]*\sclass="([^"]*)"/', $contents, $matches);

            foreach ($matches[1] as $classes) {
                $this->assertDoesNotMatchRegularExpression(
                    '/(?:bg-indigo-600|bg-gray-900|border-red-200|dark:bg-white dark:text-gray-900)/',
                    $classes,
                    "{$path} should use admin.action-button instead of hard-coded action button colors."
                );
            }
        }
    }

    public function test_search_action_button_dark_mode_text_remains_readable(): void
    {
        $css = file_get_contents(__DIR__.'/../../resources/css/admin.css');
        $button = Blade::render('<x-laravel-admin::admin.action-button variant="search">검색</x-laravel-admin::admin.action-button>');

        $this->assertStringContainsString('.laravel-admin-action-button *', $css);
        $this->assertStringContainsString('cursor: pointer;', $css);
        $this->assertStringContainsString('laravel-admin-search-button', $button);
        $this->assertStringContainsString('.laravel-admin-action-menu-content > *:hover', $css);
        $this->assertStringContainsString('background-color: #2f7df6 !important;', $css);
        $this->assertStringContainsString('.laravel-admin-action-menu-content > *:hover *', $css);
        $this->assertStringNotContainsString('.laravel-admin-action-menu-content > :first-child', $css);
        $this->assertStringContainsString('.laravel-admin-action-menu-content > * *', $css);
        $this->assertStringContainsString('display: flex !important;', $css);
        $this->assertStringContainsString('align-items: center;', $css);
        $this->assertStringContainsString('justify-content: flex-start;', $css);
        $this->assertStringContainsString('appearance: none;', $css);
        $this->assertStringContainsString('background-color: transparent;', $css);
        $this->assertStringContainsString('box-sizing: border-box;', $css);
        $this->assertStringContainsString('font-size: 1rem !important;', $css);
        $this->assertStringContainsString('font-weight: 500;', $css);
        $this->assertStringContainsString('line-height: 1.5rem !important;', $css);
        $this->assertStringContainsString('min-height: 2rem;', $css);
        $this->assertStringContainsString('padding: 0.25rem 1.5rem !important;', $css);
        $this->assertStringContainsString('.laravel-admin-action-menu-content > [aria-hidden="true"]', $css);
        $this->assertStringContainsString('text-align: left !important;', $css);
        $this->assertStringContainsString('border-radius: 0.5rem;', $css);
        $this->assertStringNotContainsString('border-radius: 0.875rem;', $css);
        $this->assertStringContainsString('.dark .laravel-admin-search-button', $css);
        $this->assertStringContainsString('color: #111827 !important;', $css);
    }

    public function test_admin_shell_guards_optional_navigation_features(): void
    {
        $layout = file_get_contents(__DIR__.'/../../resources/views/components/yaverstyle/layouts/admin.blade.php');
        $header = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/header-nav.blade.php');
        $legacyHeader = file_get_contents(__DIR__.'/../../resources/views/components/yaverstyle/admin-header.blade.php');
        $login = file_get_contents(__DIR__.'/../../resources/views/admin/auth/login.blade.php');
        $forbidden = file_get_contents(__DIR__.'/../../resources/views/errors/403.blade.php');
        $darkModeToggle = file_get_contents(__DIR__.'/../../resources/views/components/yaverstyle/dark-mode-toggle.blade.php');

        $this->assertStringContainsString('this.isMobileMenuOpen = false', $layout);
        $this->assertStringContainsString('adminSidebarWidth', $layout);
        $this->assertStringContainsString('startSidebarResize', $layout);
        $this->assertStringContainsString('role="separator"', $layout);
        $this->assertStringContainsString('admin-sidebar-surface', $layout);
        $this->assertStringContainsString('h-full min-h-screen bg-white font-sans antialiased md:bg-[#E7E7D6] dark:bg-gray-900', $layout);
        $this->assertStringContainsString('min-h-screen flex pt-16 bg-white md:bg-[#E7E7D6] dark:bg-gray-900', $layout);
        $this->assertStringContainsString('min-w-0 flex-1 flex flex-col md:mt-2 mx-0 md:mx-4 lg:mx-6', $layout);
        $this->assertStringContainsString('mb-2 border-[0px] border-gray-200 bg-white p-[0px] dark:border-gray-700 dark:bg-gray-900', $layout);
        $this->assertStringContainsString('id="page-content" class="border-[0px] border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900"', $layout);
        $this->assertStringContainsString('border-gray-400 dark:border-gray-800 shadow-lg', $header);
        $this->assertStringNotContainsString('sidebarBackground', $layout);
        $this->assertStringNotContainsString("e.key === 'Escape' && open", $layout);
        $this->assertStringNotContainsString("route('home')", $legacyHeader);
        $this->assertStringNotContainsString('favicon.ico', $layout);
        $this->assertStringNotContainsString('favicon.ico', $login);
        $this->assertStringContainsString("theme === 'dark' || theme === 'system' && prefersDark", $layout);
        $this->assertStringContainsString("theme === 'dark' || theme === 'system' && prefersDark", $login);
        $this->assertStringContainsString("theme === 'dark' || theme === 'system' && prefersDark", $forbidden);
        $this->assertStringContainsString("theme === 'dark' || (theme === 'system' && prefersDark)", $darkModeToggle);
        $this->assertStringNotContainsString('!theme && prefersDark', $layout);
        $this->assertStringNotContainsString('!theme && prefersDark', $login);
        $this->assertStringNotContainsString('!theme && prefersDark', $forbidden);
        $this->assertStringNotContainsString('!theme && prefersDark', $darkModeToggle);

        $this->assertStringContainsString("Route::has('profile.show')", $header);
        $this->assertStringContainsString("Route::has('logout')", $header);
        $this->assertStringContainsString("Route::has('teams.show')", $header);
        $this->assertStringNotContainsString("route('profile.show')", $header);
    }

    public function test_sidebar_surface_uses_css_backgrounds_instead_of_background_image_js(): void
    {
        $css = file_get_contents(__DIR__.'/../../resources/css/admin.css');
        $adminJs = file_get_contents(__DIR__.'/../../resources/js/admin.js');
        $mobileMenu = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/left-menu-mobile.blade.php');

        $this->assertStringContainsString('.admin-sidebar-surface', $css);
        $this->assertStringContainsString('.dark .admin-sidebar-surface', $css);
        $this->assertStringContainsString('--admin-sidebar-rail-width: 25px', $css);
        $this->assertStringContainsString('admin-sidebar-surface', $mobileMenu);
        $this->assertStringNotContainsString('menu_bg.gif', $css);
        $this->assertStringNotContainsString('sidebarBackground', $adminJs);
        $this->assertFileDoesNotExist(__DIR__.'/../../resources/js/sidebarBackground.js');
    }

    public function test_left_menu_uses_styleable_controls_for_primary_tree_icons(): void
    {
        $leftMenu = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/left-menu.blade.php');
        $mobileMenu = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/left-menu-mobile.blade.php');
        $css = file_get_contents(__DIR__.'/../../resources/css/admin.css');

        $this->assertStringContainsString('name="chevron-right"', $leftMenu);
        $this->assertStringContainsString('name="chevron-down"', $leftMenu);
        $this->assertStringContainsString('dtree-folder-icon', $leftMenu);
        $this->assertStringContainsString('dtree-folder-icon-open', $leftMenu);
        $this->assertStringContainsString('dtree-text ml-1', $leftMenu);
        $this->assertStringContainsString('h-[100dvh]', $mobileMenu);
        $this->assertStringContainsString('h-[calc(100dvh-64px)]', $mobileMenu);
        $this->assertStringContainsString('pb-[calc(env(safe-area-inset-bottom)+24px)]', $mobileMenu);
        $this->assertStringContainsString('<div x-cloak x-show="isMobileMenuOpen"', $mobileMenu);
        $this->assertStringContainsString('<aside x-cloak x-show="isMobileMenuOpen"', $mobileMenu);
        $this->assertStringContainsString('bg-gray-950/35 backdrop-blur-[1px] dark:bg-black/45', $mobileMenu);
        $this->assertStringNotContainsString('bg-black bg-opacity-60', $mobileMenu);
        $this->assertStringContainsString("window.location.href = @js(route('admin.index'))", $leftMenu);
        $this->assertStringContainsString("const link = \$el.querySelector('a.node')", $leftMenu);
        $this->assertStringContainsString("window.open(link.href, '_blank', 'noopener')", $leftMenu);
        $this->assertStringContainsString('class="node ml-1', $leftMenu);
        $this->assertStringContainsString("\$menu->icon ?: 'file-lines'", $leftMenu);
        $this->assertStringContainsString("\$dtreeImg('empty.gif')", $leftMenu);
        $this->assertStringNotContainsString("'line.gif'", $leftMenu);
        $this->assertStringContainsString('.dtree .dTreeNode:hover', $css);
        $this->assertStringContainsString('.dark .dtree .dTreeNode:hover', $css);
        $this->assertStringContainsString('.dtree-folder-icon::after', $css);
        $this->assertStringContainsString('.dark .dtree .dtree-folder-icon::after', $css);

        foreach (['plus.gif', 'minus.gif', 'plusbottom.gif', 'minusbottom.gif', 'folder.gif', 'folderopen.gif', 'page.gif'] as $legacyIcon) {
            $this->assertStringNotContainsString($legacyIcon, $leftMenu);
        }
    }

    public function test_packaged_views_do_not_assume_host_home_route_or_favicons(): void
    {
        $viewFiles = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(__DIR__.'/../../resources/views')
        );

        foreach ($viewFiles as $viewFile) {
            if (! $viewFile->isFile() || $viewFile->getExtension() !== 'php') {
                continue;
            }

            $source = file_get_contents($viewFile->getPathname());

            $this->assertStringNotContainsString("route('home')", $source, $viewFile->getPathname());
            $this->assertStringNotContainsString('favicon.ico', $source, $viewFile->getPathname());
            $this->assertStringNotContainsString('/site.webmanifest', $source, $viewFile->getPathname());
        }
    }

    private function assertPublishesTo(string $tag, string $targetPath): void
    {
        $targets = array_values(ServiceProvider::pathsToPublish(LaravelAdminUiServiceProvider::class, $tag));

        $this->assertContains($targetPath, $targets);
    }
}
