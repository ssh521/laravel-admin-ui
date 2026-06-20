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
    }

    public function test_icon_component_logs_unknown_icon_names_and_renders_warning_icon(): void
    {
        Log::shouldReceive('warning')
            ->once()
            ->with('Unknown laravel-admin icon name.', ['name' => 'legacy-icon']);

        $html = Blade::render('<x-laravel-admin::admin.icon name="legacy-icon" />');

        $this->assertStringContainsString('M12 9v4m0 4h.01', $html);
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

    public function test_modal_manager_clears_stale_pointer_event_styles(): void
    {
        $source = file_get_contents(__DIR__.'/../../resources/js/modal-manager.js');

        $this->assertStringContainsString('resetModalElement', $source);
        $this->assertStringContainsString("modalElement.style.pointerEvents = ''", $source);
    }

    public function test_menu_category_drag_sort_restores_cancelled_or_failed_reorders(): void
    {
        $index = file_get_contents(__DIR__.'/../../resources/views/admin/menu-categories/index.blade.php');
        $livewire = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/menu-categories/menu-category-list.blade.php');

        $this->assertStringContainsString('x-data="menuCategoryDragSort()"', $index);
        $this->assertStringContainsString(':draggable="sortMode === \'drag\'"', $index);
        $this->assertStringContainsString('this.draggedRow = event.currentTarget', $index);
        $this->assertStringNotContainsString('new Sortable', $index);
        $this->assertStringNotContainsString('Sortable.create', $index);

        foreach ([$index, $livewire] as $source) {
            $this->assertStringContainsString('originalOrder', $source);
            $this->assertStringContainsString('dropHandled', $source);
            $this->assertStringContainsString('restoreCategoryOrder', $source);
        }
    }

    public function test_admin_shell_guards_optional_navigation_features(): void
    {
        $layout = file_get_contents(__DIR__.'/../../resources/views/components/admin/layouts/admin.blade.php');
        $header = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/header-nav.blade.php');
        $legacyHeader = file_get_contents(__DIR__.'/../../resources/views/components/admin/admin-header.blade.php');
        $login = file_get_contents(__DIR__.'/../../resources/views/admin/auth/login.blade.php');

        $this->assertStringContainsString('this.isMobileMenuOpen = false', $layout);
        $this->assertStringContainsString('adminSidebarWidth', $layout);
        $this->assertStringContainsString('startSidebarResize', $layout);
        $this->assertStringContainsString('role="separator"', $layout);
        $this->assertStringContainsString('admin-sidebar-surface', $layout);
        $this->assertStringNotContainsString('sidebarBackground', $layout);
        $this->assertStringNotContainsString("e.key === 'Escape' && open", $layout);
        $this->assertStringNotContainsString("route('home')", $legacyHeader);
        $this->assertStringNotContainsString('favicon.ico', $layout);
        $this->assertStringNotContainsString('favicon.ico', $login);

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
        $this->assertStringContainsString('admin-sidebar-surface', $mobileMenu);
        $this->assertStringNotContainsString('menu_bg.gif', $css);
        $this->assertStringNotContainsString('sidebarBackground', $adminJs);
        $this->assertFileDoesNotExist(__DIR__.'/../../resources/js/sidebarBackground.js');
    }

    public function test_left_menu_uses_themeable_controls_for_primary_tree_icons(): void
    {
        $leftMenu = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/left-menu.blade.php');
        $css = file_get_contents(__DIR__.'/../../resources/css/admin.css');

        $this->assertStringContainsString('name="chevron-right"', $leftMenu);
        $this->assertStringContainsString('name="chevron-down"', $leftMenu);
        $this->assertStringContainsString('dtree-folder-icon', $leftMenu);
        $this->assertStringContainsString('dtree-folder-icon-open', $leftMenu);
        $this->assertStringContainsString('name="file-lines"', $leftMenu);
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
