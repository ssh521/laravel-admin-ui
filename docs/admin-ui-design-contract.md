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

- Use Tailwind CSS utility classes compatible with the host admin UI build.
- Render inside the existing admin layout component when available.
- Support light and dark mode classes on every new surface.
- Use existing admin Blade components for layout, session messages, buttons, modal wrappers, and validation messages when they are available.
- Avoid adding package-local visual systems unless the package has a truly specialized workflow.

## Page Contract

Every resource page should use the same structural rhythm:

- Page canvas: `mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900`.
- Inner page padding: `px-4 py-6 sm:px-6 lg:px-8`.
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

- Keep search and filters in a compact bordered bar above the list.
- Keep search controls on one line on desktop and stacked on small screens.
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

## Detail Contract

Detail screens should:

- Use a single bordered card for the main record.
- Include a summary header for identity.
- Use semantic `dl`, `dt`, and `dd` markup.
- Use one column on mobile and two columns when there is enough width.
- Render statuses, roles, and categories as badges.
- Put repeated actions in the card footer.

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

- Primary: indigo filled button.
- Secondary: white/dark bordered button.
- Destructive: red bordered button, preferably with an icon.
- Links styled as buttons should override global admin link colors with Tailwind important text classes, such as `!text-white` or `!text-gray-700`.

## Dark Mode Contract

Every package screen should include dark mode variants:

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
- Package README: [../README.md](../README.md)
