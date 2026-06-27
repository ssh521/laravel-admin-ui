# AGENTS.md

## Package Boundary

`ssh521/laravel-admin-ui` owns the presentation layer for `ssh521/laravel-admin`: Blade views, anonymous Blade components, admin CSS, admin JavaScript, packaged images, and default admin error pages.

It does not own admin authentication, route registration, policies, models, seeders, console install commands, or feature package domain behavior.

## Source Of Truth

- Package behavior: `README.md`
- Portable admin UI contract: `docs/admin-ui-design-contract.md`
- Detailed implementation rules: `docs/admin-design-rules.md`
- Component catalog: `docs/components.md`
- Theme configuration: `config/laravel-admin-ui.php`
- Default component class output: `src/Themes/TailwindTheme.php`
- Service provider and view namespace registration: `src/LaravelAdminUiServiceProvider.php`

## Theme Contract

Reusable components must keep the `x-laravel-admin::admin.*` Blade API stable.

When a component needs style changes:

- add or update a stable class key in `ThemeContract` implementations
- keep the default Tailwind output in `TailwindTheme`
- keep style package assumptions out of consuming package screens
- update `docs/components.md` when a new public component is added

## Change Rules

- Do not reintroduce global `admin.*` view names. Runtime views resolve through the `laravel-admin::` namespace.
- Do not add compatibility publish tags unless explicitly requested. Current tags are `laravel-admin-ui-config`, `laravel-admin-ui-assets`, `laravel-admin-ui-views`, and `laravel-admin-ui-components`.
- Preserve existing `wire:*`, `x-*`, `data-*`, route names, and authorization checks in packaged screens.
- Prefer existing components over one-off Tailwind class clusters.
- Keep public visible labels in Korean when editing shipped admin screens.

## Verification

```bash
git diff --check
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```

Use `php artisan view:cache` in `/Users/ssh521/Projects/Packagist/adminTest` when Blade component resolution needs verification, then clear cached views after checking.
