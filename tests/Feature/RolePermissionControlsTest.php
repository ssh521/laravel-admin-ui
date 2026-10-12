<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ViewErrorBag;
use Ssh521\LaravelAdminUi\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    Route::get('/test-roles', fn (): string => 'roles')->name('admin.roles.index');
    Gate::define('assignToRoles', fn (?object $user, object $permission): bool => $permission->name === 'user-list');
});

function rolePermissionControls(array $overrides = []): DOMXPath
{
    $html = view('laravel-admin::admin.roles.partials.form', array_replace([
        'role' => (object) ['name' => 'Fixture role'],
        'permissions' => collect([(object) ['id' => 1, 'name' => 'super-admin-manage'], (object) ['id' => 2, 'name' => 'user-list']]),
        'rolePermissions' => [1, 2],
        'canAssignPermissions' => false,
        'errors' => new ViewErrorBag,
    ], $overrides))->render();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);

    return new DOMXPath($document);
}

test('metadata editors receive read only permission controls without a clearing marker', function (): void {
    $inputs = rolePermissionControls();
    expect($inputs->query('//input[@type="checkbox" and @disabled]')->length)->toBe(2);
    expect($inputs->query('//input[@name="permissions_present"]')->length)->toBe(0);
    expect($inputs->query('//input[@type="checkbox" and @checked]')->length)->toBe(2);
});

test('grantors can change ordinary permissions while retaining locked protected selections', function (): void {
    $inputs = rolePermissionControls(['canAssignPermissions' => true]);
    expect($inputs->query('//input[@id="permission_1" and @disabled and @checked]')->length)->toBe(1);
    expect($inputs->query('//input[@id="permission_2" and not(@disabled)]')->length)->toBe(1);
    expect($inputs->query('//input[@type="hidden" and @name="permissions[]" and @value="1"]')->length)->toBe(1);
    expect($inputs->query('//input[@name="permissions_present" and @value="1"]')->length)->toBe(1);
});

test('unassigned protected permissions are disabled without hidden grants', function (): void {
    $inputs = rolePermissionControls(['canAssignPermissions' => true, 'rolePermissions' => [2]]);
    expect($inputs->query('//input[@id="permission_1" and @disabled and not(@checked)]')->length)->toBe(1);
    expect($inputs->query('//input[@type="hidden" and @name="permissions[]"]')->length)->toBe(0);
});

test('modal permission controls reflect both role and individual grant capabilities', function (bool $canAssign): void {
    $html = view('laravel-admin::livewire.admin.roles.role-edit-modal', [
        'modalStackId' => 'fixture',
        'canAssignPermissions' => $canAssign,
        'availablePermissions' => [['id' => 1, 'name' => 'protected fixture', 'canAssign' => false], ['id' => 2, 'name' => 'ordinary fixture', 'canAssign' => true]],
        'errors' => new ViewErrorBag,
    ])->render();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
    $inputs = new DOMXPath($document);
    expect($inputs->query('//input[@value="1" and @disabled]')->length)->toBe(1);
    expect($inputs->query('//input[@value="2" and @disabled]')->length)->toBe($canAssign ? 0 : 1);
})->with([true, false]);
