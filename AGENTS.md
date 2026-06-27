# AGENTS.md

## Package Boundary

`ssh521/laravel-admin-ui` owns the reusable admin presentation layer for `ssh521/laravel-admin`.

It provides Blade views, anonymous Blade components, CSS, JavaScript, image assets, and the packaged 403 page. It does not own admin authentication, guards, routes, policies, models, seeders, console commands, or feature package domain behavior.

## Source Of Truth

- Package behavior: `README.md`
- Service provider: `src/LaravelAdminUiServiceProvider.php`
- Design rules: `docs/admin-design-rules.md`
- Cross-package UI contract: `docs/admin-ui-design-contract.md`
- Components: `resources/views/components/admin/`
- Admin views and Livewire view resources: `resources/views/admin/` and `resources/views/livewire/admin/`
- Assets: `resources/css/admin.css`, `resources/js/`, and `public/images/dtree/`
- Tests: `tests/`

## Change Rules

- Treat this package as the source of truth for admin UI patterns used by other `ssh521/*` packages.
- Preserve the `laravel-admin` view namespace and `x-laravel-admin::admin.*` anonymous component namespace.
- Keep publish tags and host app paths stable: `laravel-admin-ui-views`, `laravel-admin-ui-components`, and `laravel-admin-ui-assets`.
- Do not move authentication, authorization, route ownership, model behavior, menu registration, or seeders into this package.
- Keep visible admin labels Korean by default unless the task explicitly asks for another language.
- Preserve existing `id`, `wire:*`, `x-*`, `data-*`, route names, form field names, and JavaScript event hooks when making UI-only changes.
- Prefer improving or reusing shared admin components before adding one-off styling to individual screens.
- Keep light and dark mode classes aligned with `docs/admin-design-rules.md`.
- Do not add external icon dependencies; use `x-laravel-admin::admin.icon` and its local icon map.

## Verification

```bash
git diff --check
composer test
```

If package-local dependencies are unavailable, run the relevant shared host-app test command from the consuming workspace and still run `git diff --check`.
