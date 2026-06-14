# ssh521/laravel-admin-ui

Reusable Blade views, Blade components, CSS, JavaScript, and image assets for `ssh521/laravel-admin`.

This package owns the admin UI resource layer. The core `ssh521/laravel-admin` package owns auth, routes, policies, models, commands, seeders, and package integration services.

## Publish Tags

New UI-specific tags:

```bash
php artisan vendor:publish --tag=laravel-admin-ui-assets
php artisan vendor:publish --tag=laravel-admin-ui-views
php artisan vendor:publish --tag=laravel-admin-ui-components
```

Legacy compatibility tags are also registered so existing install/update flows keep working:

```bash
php artisan vendor:publish --tag=laravel-admin-assets
php artisan vendor:publish --tag=laravel-admin-views
php artisan vendor:publish --tag=laravel-admin-components
```

## Published Paths

Assets are published to the same host-app paths used before the package split:

```text
resources/vendor/laravel-admin/admin.css
resources/vendor/laravel-admin/admin.js
resources/views/vendor/laravel-admin
public/images/dtree
```

Host apps should keep these Vite inputs:

```js
'resources/vendor/laravel-admin/admin.css',
'resources/vendor/laravel-admin/admin.js',
```

## Scope

This package intentionally does not own the Livewire component classes yet. For the first extraction phase, those classes stay in `ssh521/laravel-admin` while their views live here.
