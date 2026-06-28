# Admin Design Rules

This document records the UI direction used for the `admin-users` and `roles` pilot screens.
Use it as the baseline when modernizing other admin list, form, and detail pages.
For rules that other packages can adopt as a cross-package contract, see [admin-ui-design-contract.md](admin-ui-design-contract.md).

## References

- Lists: https://tailwindcss.com/plus/ui-blocks/application-ui/lists/tables
- Forms: https://tailwindcss.com/plus/ui-blocks/application-ui/forms/form-layouts
- Detail views: https://tailwindcss.com/plus/ui-blocks/application-ui/data-display/description-lists

## Overall Direction

- Keep admin screens quiet, structured, and task-focused.
- Prefer Tailwind Plus Application UI patterns over legacy dashed boxes and dense 12px table layouts.
- Use restrained neutral surfaces with clear borders, subtle shadows, and indigo as the primary action color.
- Keep layout width consistent across related screens. For resource management pages, use `max-w-4xl` for forms/detail. Lists may be full-width tables or card grids depending on the data shape.
- Preserve existing routes, authorization checks, validation, and data behavior when changing presentation.
- Prefer `x-laravel-admin::admin.*` components over raw utility class clusters when the pattern already exists. This keeps screens compatible with folder-based styles such as `yaverstyle` and `daisystyle`.

## Style Switching

The public Blade API is `x-laravel-admin::admin.*`. Screens should not reference style folders directly.

The host app selects the style with:

```env
LARAVEL_ADMIN_UI_STYLE=yaverstyle
LARAVEL_ADMIN_UI_STYLE=daisystyle
```

`components/admin` dispatches to `components/{style}` and falls back to `components/yaverstyle`. New reusable patterns should be added as admin components first, then implemented in the required style folders.

## Page Structure

- Use a concise page title with a short helper description below it.
- Put primary actions in the top-right on desktop and below the title on mobile.
- Use `bg-white dark:bg-gray-900` for the main page surface.
- Use `mx-auto w-full max-w-5xl` for resource create, edit, and show page canvases.
- Use `w-full` without a max-width cap for resource list pages that contain tables or wide filter bars.
- Keep the inner form/detail content aligned on `mx-auto max-w-4xl`.
- Avoid nested decorative cards. Use cards only when they frame a concrete data object or form group.
- Keep spacing generous but operational: `px-4 py-6 sm:px-6 lg:px-8` is the default page padding.

## Lists

- Use a table when each row is mostly comparable scalar data, such as users with name, email, status, and row actions.
- Use a card grid when each item has a variable-length collection, such as roles with many permission badges.
- Base table screens on Tailwind table patterns:
  - `flow-root` wrapper
  - responsive horizontal overflow
  - `divide-y` table separators
  - compact text with `text-sm`
- Base card list screens on:
  - `ul role="list"`
  - `grid grid-cols-1 gap-4 lg:grid-cols-2`
  - card items with border, white/dark background, subtle shadow, and hover state
- Put the primary identity field first.
- Use avatars only when they add recognition value, such as user records. Do not add decorative avatars to abstract records like roles.
- Hide secondary columns on small screens and repeat critical secondary info inside the first column when needed.
- Render statuses and roles as small badges, not plain comma-separated text.
- Use icon+text actions for view and edit.
- If a name opens a quick modal, keep that behavior on the name and make the explicit `상세보기` action navigate to the show page.
- Keep search and filters in a compact bordered filter bar above the list.
- Search controls should be one line on desktop and stack cleanly on small screens, for example `flex flex-col sm:flex-row`.
- Place fixed-width filter selects before the search input; let only the search input expand, and keep the submit button shrink-wrapped on desktop.
- Do not render a `목록보기` button on an index/list page that already represents that resource list. Keep only meaningful actions such as `등록하기`, search, reset, sort, or resource-specific management actions.
- Use the term `목록` instead of `리스트` in visible Korean page titles and breadcrumbs.

## Forms

- Base forms on sectioned Tailwind form layouts.
- Use a shared `partials/form.blade.php` for create/edit resource forms when the field structure is the same. The create/edit page should own the wrapper, route, method, page title, and external edit-only actions; the partial should own the repeated form fields and optional create footer.
- Use a 12-column form canvas for admin resource forms: `mx-auto grid max-w-4xl grid-cols-1 gap-x-8 md:grid-cols-12`.
- Separate form sections with a full-width border divider: `my-10 border-b ... md:col-span-12`.
- Split large forms into meaningful sections with:
  - section title
  - short description
  - form controls in the right column on desktop
- On desktop, place section copy in `md:col-span-4` and controls in `md:col-span-8`.
- Use consistent inputs:
  - rounded `md`
  - gray border
  - white/dark background
  - indigo focus ring
- Put related checkbox options in bordered selectable rows or grids.
- Let large checkbox groups expand within the controls column and increase columns responsively. If labels are long or the group is the main task, prefer a wider controls grid over a cramped nested card.
- For permission grids, use responsive columns such as `grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4`.
- Long option labels should stay on one line with `truncate`, and the full value should be available through `title`.
- Use `textarea` for description fields, not single-line inputs.
- Keep form footer actions on one shared horizontal row on desktop.
- Put destructive actions on the left side of the shared footer row and submit/cancel actions on the right.
- Do not add extra top margin to form footer rows after a section divider. Use `col-span-full flex items-center justify-end gap-x-3` for create footers and `mx-auto flex w-full max-w-4xl flex-col gap-3 px-2 sm:flex-row sm:items-center sm:justify-between` for edit external action rows.
- Use purpose-specific create/edit titles in the form header, such as `회원 정보 등록` and `회원 정보 수정`, instead of a generic shared title such as `회원 정보`.
- Preserve locked states with disabled controls plus muted color and helper text.

## Detail Views

- Base detail screens on description list patterns.
- Use a summary header for the record identity before the `dl`.
- Use semantic `dl`, `dt`, and `dd` markup for label/value pairs.
- Use two columns on wider screens, one column on mobile.
- Render status values and roles as badges.
- Put repeated page actions in a footer action area when the detail card is the main focus.
- On detail pages, keep the top-right action area focused on `목록보기` only.
- On detail page footers, show only the primary continuation action, usually `수정하기`, aligned to the right. Do not repeat `목록보기` in the footer and do not show destructive actions there unless a workflow explicitly requires deletion from detail.

## Modals

- Modal content should follow the same design language as pages: quiet card surfaces, section headers, badges, and consistent action buttons.
- Preserve all JavaScript and Livewire hooks when restyling modals. Keep existing `id`, `class`, `data-*`, and `wire:*` attributes unless the behavior is intentionally changed.
- Use modals for quick inspection and short editing flows. Provide a clear route to the full show or edit page when deeper work is available.
- For draggable modals, choose a width and height that fits the content without forcing cramped grids. Roles and menu category management modals should be wider than legacy 500px layouts when they contain badges or checkbox grids.
- Keep modal footers right-aligned and visually separated with a top border.
- Use bordered selectable rows for checkbox lists in modals, matching the page form checkbox style.

## Buttons And Links

- Primary action: indigo filled button.
- Secondary action: white/dark bordered button.
- Destructive action: red bordered button with a clear icon.
- Destructive actions should be spatially separated from primary actions, but remain in the same footer row on desktop. Prefer left alignment for delete buttons and right alignment for navigation/edit/save buttons.
- Use the package Blade icon component for common actions.
- Override global admin link colors with Tailwind important text classes, for example `!text-white` or `!text-gray-700`, when a link is styled as a button.

## Dark Mode

- Every new surface should include dark variants.
- Prefer:
  - `dark:bg-gray-900` for page/card backgrounds
  - `dark:bg-gray-800` for secondary surfaces
  - `dark:border-gray-700` for borders
  - `dark:text-white`, `dark:text-gray-300`, and `dark:text-gray-400` for text hierarchy
- Badge colors should use low-opacity dark backgrounds with readable text.

## Migration Checklist

When modernizing another admin resource:

1. Update the index page first, preserving filters, pagination, policies, and routes.
2. Update create/edit wrappers and shared form partials together.
3. Update show pages with a description list pattern.
4. Normalize visible Korean labels, page titles, and action text while preserving routes and behavior.
5. Run `git diff --check`.
6. Run the available test command if dependencies are installed.
7. Compare light and dark mode visually before shipping.
