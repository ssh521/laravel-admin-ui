# AGENTS.md

## Package Boundary

`ssh521/laravel-admin-ui` owns the reusable admin presentation layer for `ssh521/laravel-admin`.

It provides Blade views, anonymous Blade components, CSS, JavaScript, image assets, and the packaged 403 page. It does not own admin authentication, guards, routes, policies, models, seeders, console commands, or feature package domain behavior.

## Source Of Truth

- Package behavior: `README.md`
- Portable admin UI contract: `docs/admin-ui-design-contract.md`
- Detailed implementation rules: `docs/admin-design-rules.md`
- Component catalog: `docs/components.md`
- Style configuration: `config/laravel-admin-ui.php`
- Internal yaverstyle class helper: `src/Styles/YaverstyleClassResolver.php`
- Service provider and view namespace registration: `src/LaravelAdminUiServiceProvider.php`
- Admin views and Livewire view resources: `resources/views/admin/` and `resources/views/livewire/admin/`
- Assets: `resources/css/admin.css`, `resources/js/`, and `public/images/dtree/`
- Tests: `tests/`

## Style Contract

Reusable components must keep the `x-laravel-admin::admin.*` Blade API stable.

When a component needs style changes:

- add or update a style-folder component implementation under `resources/views/components/{style}`
- keep `resources/views/components/admin` as the public dispatcher API
- keep internal `YaverstyleClassResolver` changes limited to yaverstyle components that still depend on class keys
- keep style package assumptions out of consuming package screens
- update `docs/components.md` when a new public component is added

## Change Rules

- Treat this package as the source of truth for admin UI patterns used by other `ssh521/*` packages.
- Preserve the `laravel-admin` view namespace and `x-laravel-admin::admin.*` anonymous component namespace.
- Keep publish tags and host app paths stable: `laravel-admin-ui-config`, `laravel-admin-ui-views`, `laravel-admin-ui-components`, and `laravel-admin-ui-assets`.
- Do not reintroduce global `admin.*` view names. Runtime views resolve through the `laravel-admin::` namespace.
- Do not move authentication, authorization, route ownership, model behavior, menu registration, or seeders into this package.
- Keep visible admin labels Korean by default unless the task explicitly asks for another language.
- Preserve existing `id`, `wire:*`, `x-*`, `data-*`, route names, form field names, JavaScript event hooks, and authorization checks when making UI-only changes.
- Prefer improving or reusing shared admin components before adding one-off styling to individual screens.
- Keep light and dark mode classes aligned with `docs/admin-design-rules.md`.
- Do not add external icon dependencies; use `x-laravel-admin::admin.icon` and its local icon map.

## Verification

```bash
git diff --check
composer test
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```

If package-local dependencies are unavailable, run the relevant shared host-app test command from the consuming workspace and still run `git diff --check`.

Use `php artisan view:cache` in `/Users/ssh521/Projects/Packagist/adminTest` when Blade component resolution needs verification, then clear cached views after checking.
