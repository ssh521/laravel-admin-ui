<?php

namespace Ssh521\LaravelAdminUi\Tests\Feature;

use Illuminate\Support\Facades\Blade;
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

    public function test_it_does_not_register_legacy_publish_tags(): void
    {
        $this->assertSame([], ServiceProvider::pathsToPublish(LaravelAdminUiServiceProvider::class, 'laravel-admin-views'));
        $this->assertSame([], ServiceProvider::pathsToPublish(LaravelAdminUiServiceProvider::class, 'laravel-admin-components'));
        $this->assertSame([], ServiceProvider::pathsToPublish(LaravelAdminUiServiceProvider::class, 'laravel-admin-assets'));
    }

    public function test_admin_shell_guards_optional_navigation_features(): void
    {
        $layout = file_get_contents(__DIR__.'/../../resources/views/components/admin/layouts/admin.blade.php');
        $header = file_get_contents(__DIR__.'/../../resources/views/livewire/admin/header-nav.blade.php');
        $legacyHeader = file_get_contents(__DIR__.'/../../resources/views/components/admin/admin-header.blade.php');
        $login = file_get_contents(__DIR__.'/../../resources/views/admin/auth/login.blade.php');

        $this->assertStringContainsString('this.isMobileMenuOpen = false', $layout);
        $this->assertStringNotContainsString("e.key === 'Escape' && open", $layout);
        $this->assertStringNotContainsString("route('home')", $legacyHeader);
        $this->assertStringNotContainsString('favicon.ico', $layout);
        $this->assertStringNotContainsString('favicon.ico', $login);

        $this->assertStringContainsString("Route::has('profile.show')", $header);
        $this->assertStringContainsString("Route::has('logout')", $header);
        $this->assertStringContainsString("Route::has('teams.show')", $header);
        $this->assertStringNotContainsString("route('profile.show')", $header);
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
