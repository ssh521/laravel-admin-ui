# Admin UI Design Contract

This document defines the portable design contract for packages that render screens inside the `ssh521/laravel-admin` admin area.
Use it when another package needs to match the `laravel-admin-ui` look, layout, and interaction model.

## Purpose

- Keep admin screens consistent across separately maintained packages.
- Make UI modernization repeatable without copying one-off page implementations.
- Preserve package-specific routes, policies, Livewire events, and form behavior while sharing the same visual rules.
- Treat `ssh521/laravel-admin-ui` as the source of truth for admin presentation patterns.

## Required Baseline

Packages that adopt this contract should:

- Render inside the existing admin layout component when available.
- Use existing `x-laravel-admin::admin.*` Blade components for layout, session messages, buttons, form controls, list wrappers, modal wrappers, and validation messages when they are available.
- Avoid adding package-local visual systems unless the package has a truly specialized workflow.
- Keep package screens style-neutral where possible so the host app can switch `laravel-admin-ui` styles without editing feature package views.

## Style Folder Contract

`x-laravel-admin::admin.*` is the stable public Blade API. The `components/admin` folder is a dispatcher layer and must not be removed or renamed.

Actual component implementations live in style folders:

```text
resources/views/components/admin
resources/views/components/yaverstyle
resources/views/components/daisystyle
```

The host app selects the implementation with:

```env
LARAVEL_ADMIN_UI_STYLE=yaverstyle
LARAVEL_ADMIN_UI_STYLE=daisystyle
```

Dispatcher lookup order:

```php
laravel-admin::components.{style}.{component}
laravel-admin::components.yaverstyle.{component}
```

Rules:

- `yaverstyle` is the default implementation and fallback.
- `daisystyle` uses DaisyUI classes and may implement components incrementally.
- Custom styles should be added as sibling folders such as `components/customstyle`, not by editing or renaming `components/admin`.
- A missing component in the selected style must fall back to `yaverstyle`.
- Feature packages should keep using `x-laravel-admin::admin.*`; they should not call `components.yaverstyle.*` or `components.daisystyle.*` directly.
- PHP class resolver internals are not a public styling API. Folder-based styles are the cross-package styling API.

## Page Contract

Every resource page should use the same structural rhythm:

- Prefer `x-laravel-admin::admin.page-section` for page canvas, title, description, and actions.
- The admin layout main area must own the admin shell background so long list pages do not reveal the body background while scrolling.
- Forms and detail cards should align on `mx-auto max-w-4xl`.
- Page title should be concise, with one short helper sentence below it.
- Primary actions should sit at the top-right on desktop and below the title on mobile.
- Do not use legacy dashed panels, hard-coded gray hex colors, or inline focus scripts for new screens.

## Resource Pattern

A package resource should provide these screens when applicable:

- `index`: list, search/filter bar, pagination, and row actions.
- `create`: sectioned form with submit/cancel actions.
- `edit`: sectioned form with destructive action on the left and submit/cancel actions on the right.
- `show`: description-list detail card with footer actions.
- `modal`: quick view or short edit flow that links to full show/edit pages when deeper work exists.

If a package resource does not need all screens, the implemented screens should still follow the same layout and action placement rules.

## List Contract

Use a table when rows are comparable scalar data.
Use a card grid when each item contains variable-length nested data such as badges or permissions.

List screens should:

- Keep search and filters in `x-laravel-admin::admin.filter-bar` above the list.
- Keep search controls on one line on desktop and stacked on small screens.
- Put fixed-width filter selects before the flexible search input; selects and action buttons should not stretch on desktop.
- Do not show a self-referential list navigation button on the list page itself.
- Put the primary identity field first.
- Use avatars only for person/user records where recognition helps.
- Render statuses as badges.
- Hide secondary columns on small screens and repeat critical info inside the first column.
- Keep name/title modal triggers separate from explicit `상세보기` links.

## Form Contract

Resource forms should use the sectioned 12-column layout:

```html
<div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
```

Section rules:

- Divider: `my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10`.
- Section copy: `md:col-span-4`.
- Controls: `md:col-span-8`.
- Inputs: rounded `md`, gray border, white/dark background, indigo focus ring.
- Text descriptions should use `textarea`.
- Checkbox groups should use bordered selectable rows.
- Wide checkbox groups should expand responsively instead of staying cramped.

Footer rules:

- Place destructive actions on the left.
- Place cancel/list/save actions on the right.
- Keep both groups on the same row on desktop and stacked cleanly on mobile.
- Avoid extra top margin on footer rows immediately after section dividers.
- Reuse a shared form partial for create/edit when fields overlap, while keeping page titles, routes, HTTP methods, and edit-only external actions in the page wrapper.
- Form page titles should include the resource, information scope, and action, such as `회원 정보 등록` or `회원 정보 수정`.

## Detail Contract

Detail screens should:

- Use a single bordered card for the main record.
- Include a summary header for identity.
- Use semantic `dl`, `dt`, and `dd` markup.
- Use one column on mobile and two columns when there is enough width.
- Render statuses, roles, and categories as badges.
- Put repeated actions in the card footer.
- Show only list navigation in the top action area.
- Show only the primary continuation action, usually edit, in the footer.

## Modal Contract

Modal content should reuse the same page design language:

- Bordered card surfaces.
- Description-list detail content.
- Bordered selectable rows for checkboxes.
- Footer actions separated by a top border.
- A clear route to the full show or edit page when available.

Implementation rules:

- Preserve existing `id`, `wire:*`, `x-*`, `data-*`, and JavaScript event hooks unless intentionally changing behavior.
- Prefer wider modal dimensions when content contains badges, grids, or selectable rows.
- Keep quick-edit forms short; move complex editing to the full edit page.

## Button Contract

Use consistent action hierarchy:

- Use `x-laravel-admin::admin.action-button` for primary, secondary, destructive, search, and link-style row actions.
- Use `variant="primary"`, `variant="secondary"`, `variant="danger"`, `variant="search"`, and `variant="link"` instead of hard-coded style classes in feature package views.
- Korean visible labels should prefer `목록`, `등록하기`, `수정하기`, `저장하기`, and `삭제하기` consistently.
- Icons should use the shared `x-laravel-admin::admin.icon` Blade component instead of external icon font packages.

## Reusable Components

The package exposes small Blade components under the existing `x-laravel-admin::admin.*` namespace for repeated admin UI patterns.
These components define the stable UI contract. Their implementation is selected by the `laravel-admin-ui.style` config value so style folders can reuse the same Blade API without forking package screens.

- Start from the component catalog: [components.md](components.md).
- Use page/list/form/detail components before copying raw utility classes into package screens.
- Keep component usage semantic: list controls use filter components, record summaries use card/detail components, row actions use action menu/button components.
- Keep route names, form names, `wire:*`, `x-*`, and authorization checks in the package screen that owns the behavior.

## Dark Mode Contract

When a package must write raw classes directly, every package screen should include dark mode variants:

- Main background: `dark:bg-gray-900`.
- Secondary background: `dark:bg-gray-800`.
- Borders: `dark:border-gray-700`.
- Primary text: `dark:text-white`.
- Secondary text: `dark:text-gray-300` or `dark:text-gray-400`.
- Badges should use low-opacity dark backgrounds with readable text.

## Compatibility Rules

When applying this contract to another package:

- Do not rename routes, form field names, Livewire properties, or event names for visual-only work.
- Do not remove authorization checks.
- Do not change validation behavior.
- Do not introduce new dependencies just for styling.
- Keep package-owned domain behavior inside that package.
- Use `laravel-admin-ui` examples as implementation references, not as code that must be copied verbatim.

## Adoption Checklist

For each resource migrated in another package:

1. Confirm the package renders inside the admin layout.
2. Update the index screen.
3. Update create/edit forms and shared partials.
4. Update show/detail screens.
5. Update related Livewire or Alpine modals.
6. Check mobile layout for search bars, action footers, and long labels.
7. Check dark mode classes.
8. Run `git diff --check`.
9. Run the package test or view-render command when available.
10. Commit UI-only changes separately from behavior changes.

## Source Documents

- Detailed implementation rules: [admin-design-rules.md](admin-design-rules.md)
- Component catalog: [components.md](components.md)
- Package README: [../README.md](../README.md)
