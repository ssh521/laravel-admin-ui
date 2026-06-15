<?php

namespace Ssh521\LaravelAdminUi\Tests\Feature;

use Illuminate\Support\Facades\Blade;
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

        $html = Blade::render('<x-laravel-admin::admin.primary-button>Save</x-laravel-admin::admin.primary-button>');

        $this->assertStringContainsString('Save', $html);
        $this->assertStringContainsString('<button', $html);
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

    private function assertPublishesTo(string $tag, string $targetPath): void
    {
        $targets = array_values(ServiceProvider::pathsToPublish(LaravelAdminUiServiceProvider::class, $tag));

        $this->assertContains($targetPath, $targets);
    }
}
