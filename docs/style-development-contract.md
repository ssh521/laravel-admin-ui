# Admin Style Development Contract

This document is the implementation contract for developing or extending `laravel-admin-ui` component styles.
Use it as the first reference when an AI agent or maintainer creates a new style folder such as `daisystyle` or `customstyle`.

## Goal

Style development must let host apps change the admin component implementation without changing feature package Blade screens.

Feature package screens must keep using:

```blade
<x-laravel-admin::admin.action-button>
<x-laravel-admin::admin.badge>
<x-laravel-admin::admin.form-input>
```

They must not reference a concrete style folder directly.

## Public API

The stable public Blade API is:

```text
x-laravel-admin::admin.*
```

The stable public configuration key is:

```php
config('laravel-admin-ui.style', 'yaverstyle')
```

The environment variable is:

```env
LARAVEL_ADMIN_UI_STYLE=yaverstyle
LARAVEL_ADMIN_UI_STYLE=daisystyle
```

Do not reintroduce a public `theme`, `themes`, `ThemeContract`, or package-specific theme adapter API for component styling.

## Folder Contract

The component folders have distinct responsibilities:

```text
resources/views/components/admin       public dispatcher layer
resources/views/components/yaverstyle  default implementation and fallback
resources/views/components/daisystyle  DaisyUI implementation
resources/views/components/{style}     custom implementation
```

`resources/views/components/admin` must remain present because external package screens call `x-laravel-admin::admin.*`.

Files in `components/admin` should only dispatch to style implementations. They should not contain real UI markup.

Dispatcher lookup order:

```blade
@includeFirst([
    'laravel-admin::components.'.config('laravel-admin-ui.style', 'yaverstyle').'.action-button',
    'laravel-admin::components.yaverstyle.action-button',
])
```

Rules:

- `yaverstyle` is the default implementation.
- `yaverstyle` is the fallback for missing components in any selected style.
- A style folder may implement components incrementally.
- A missing custom style folder must not break pages when the required component exists in `yaverstyle`.
- Feature packages must not call `laravel-admin::components.yaverstyle.*`, `laravel-admin::components.daisystyle.*`, or another concrete style view directly.

## New Style Procedure

When creating a new style:

1. Create `resources/views/components/{style}`.
2. Implement only the components that need a different visual treatment.
3. Keep the same accepted props, slots, attributes, and default behavior as the matching `yaverstyle` component.
4. Preserve existing `wire:*`, `x-*`, `data-*`, `id`, `name`, `type`, route, authorization, and form behavior.
5. Do not edit feature package screens to target the new style.
6. Do not remove or rename files in `components/admin`.
7. Let unimplemented components fall back to `components/yaverstyle`.
8. Update `docs/components.md` when the new style intentionally covers more components.
9. Update `README.md` if the style requires host app CSS, JavaScript, or build configuration.
10. Verify Blade rendering with the commands in this document.

## Component Implementation Rules

Each style component must:

- Accept the same public props as the `yaverstyle` implementation unless a documented component contract changes.
- Forward `$attributes` using `merge()` or equivalent Blade-safe handling.
- Preserve named slots and default slot behavior.
- Keep Korean visible labels when the existing component provides default Korean text.
- Avoid inline scripts unless the original component already owns that behavior.
- Avoid changing form submission, validation, Livewire, or Alpine behavior for visual-only style work.
- Keep layout stable on mobile and desktop.
- Keep dark mode support when the style supports dark mode.

When adding a new public component:

1. Add the public dispatcher in `resources/views/components/admin/{component}.blade.php`.
2. Add the default implementation in `resources/views/components/yaverstyle/{component}.blade.php`.
3. Add style-specific implementations only where needed.
4. Document the component in `docs/components.md`.
5. Add focused tests when the component affects shared behavior or fallback logic.

## DaisyUI Rules

`daisystyle` should actively use DaisyUI classes:

```text
button:   btn, btn-primary, btn-outline, btn-error, btn-ghost
badge:    badge, badge-primary, badge-success, badge-warning, badge-error, badge-info
input:    input input-bordered
select:   select select-bordered
textarea: textarea textarea-bordered
card:     card, card-body, card-title
layout:   bg-base-100, bg-base-200, border-base-300, rounded-box
state:    alert, alert-info, alert-success, alert-warning, alert-error
```

Host apps that use `daisystyle` must install and build DaisyUI:

```bash
npm install daisyui --save-dev
```

`resources/vendor/laravel-admin/admin.css`:

```css
@import "tailwindcss";
@plugin "daisyui";
```

Then run:

```bash
npm run build
php artisan config:clear
php artisan view:clear
```

## Internal Resolver Boundary

`src/Contracts/StyleClassResolver.php` and `src/Styles/YaverstyleClassResolver.php` are internal helpers for existing `yaverstyle` components.

They are not the public styling extension point.

Do not require custom styles to implement PHP resolver classes. The public extension point is the Blade style folder.

## AI Development Checklist

Before editing:

1. Read this document.
2. Read `docs/components.md` for component names and current style coverage.
3. Inspect the matching `yaverstyle` component before implementing another style.
4. Inspect existing `daisystyle` components when working on DaisyUI.

While editing:

1. Keep feature package screens on `x-laravel-admin::admin.*`.
2. Add or update files under `resources/views/components/{style}`.
3. Keep `components/admin` as dispatcher-only.
4. Keep fallback behavior intact.
5. Avoid unrelated refactors.

Before finishing:

1. Search for direct concrete style usage in feature screens:

```bash
rg -n "components\\.(yaverstyle|daisystyle)|laravel-admin::components\\.(yaverstyle|daisystyle)" resources/views
```

2. Check for public theme API regressions:

```bash
rg -n "LARAVEL_ADMIN_UI_THEME|laravel-admin-ui\\.theme|ThemeContract|ThemeManager|TailwindTheme" .
```

3. Run syntax and test checks:

```bash
git diff --check
../../../adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```

4. Verify both default and alternate styles compile:

```bash
cd ../../../adminTest
LARAVEL_ADMIN_UI_STYLE=yaverstyle php artisan view:cache
LARAVEL_ADMIN_UI_STYLE=daisystyle php artisan view:cache
php artisan view:clear
```

5. If DaisyUI classes changed, rebuild the host app:

```bash
npm run build
```

## Non-Goals

Do not do these as part of style folder development:

- Do not create a separate `laravel-admin-ui-daisyui` package.
- Do not change feature package routes, controllers, policies, models, seeders, migrations, or form contracts.
- Do not convert package screens to concrete style view includes.
- Do not remove `components/admin`.
- Do not remove `yaverstyle` fallback.
- Do not treat PHP class resolvers as the public style API.
