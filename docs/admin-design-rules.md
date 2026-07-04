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
- Put the same light/dark background on the admin body, main slot wrapper, and `#page-content` so slots do not reveal a dark or transparent surface while rendering.
- Use `mx-auto w-full max-w-5xl` for resource create, edit, and show page canvases.
- Use `w-full` without a max-width cap for resource list pages that contain tables or wide filter bars.
- Keep the admin layout main area on the admin shell background. Transparent gutters around long list pages let the body background show through at the bottom of tables.
- Keep the inner form/detail content aligned on `mx-auto max-w-4xl`.
- Keep the admin-header breadcrumb aligned with the `admin/popups` baseline: dashboard and list pages use `관리자 홈 - {리소스 관리}`, while create/detail/edit pages use `관리자 홈 - {리소스 목록} - 등록|상세|수정`. Do not append long record titles.
- Avoid nested decorative cards. Use cards only when they frame a concrete data object or form group.
- Keep spacing generous but operational: `px-4 py-6 sm:px-6 lg:px-8` is the default page padding.

## Lists

- Use a table when each row is mostly comparable scalar data, such as users with name, email, status, and row actions.
- Use a card grid when each item has a variable-length collection, such as roles with many permission badges.
- Base table screens on Tailwind table patterns:
  - `flow-root` wrapper
  - responsive horizontal overflow
  - `divide-y` table separators
  - quiet header band with `border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80`
  - compact text with `text-sm`
  - compact vertical rhythm with `py-3` on header and body cells
- Base card list screens on:
  - `ul role="list"`
  - `grid grid-cols-1 gap-4 lg:grid-cols-2`
  - card items with border, white/dark background, subtle shadow, and hover state
- Put the primary identity field first.
- Do not expose technical identifiers or generated ordering values such as database IDs, key IDs, or sort order as primary list/detail display fields unless an admin workflow explicitly needs the raw value.
- Align the first visible identity column header with the identity cell on mobile, normally left for avatar + name cells, then center it from `md` upward when the desktop table uses centered comparable columns. Utility columns such as order handles, checkboxes, or row numbers may appear before it, but they should not compete visually with the identity column.
- For ordinary sortable list pages, use clickable column titles that preserve the current query string and toggle direction. Keep drag-sort and click/drag sort mode switches only for resource-ordering pages such as `admin/permissions`.
- Use avatars only when they add recognition value, such as user records. Do not add decorative avatars to abstract records like roles.
- Hide secondary columns on small screens and repeat critical secondary info inside the first column when needed.
- Render statuses and roles as small badges, not plain comma-separated text.
- Use `variant="info"` for role/category taxonomy badges when they need to stand apart from neutral empty-state text.
- Use icon+text actions for view and edit.
- If a name opens a quick modal, keep that behavior on the name and make the explicit `보기` action navigate to the show page.
- Keep search and filters in a compact bordered filter bar above the list.
- On mobile, collapse the filter bar by default behind a compact `검색/필터` toggle so the first list rows are visible without extra scrolling. Keep the full filter bar visible on tablet and desktop.
- If a mobile list page has a primary action such as `등록하기`, place the compact `검색/필터` toggle in the same top action row when space allows, then expand the filter form below the header.
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
- Keep edit page headers informational like `admin/admin-users/edit`; avoid extra top-right detail/navigation actions unless the resource workflow explicitly needs them.
- Use `수정하기` as the primary submit label on ordinary edit pages.
- Preserve locked states with disabled controls plus muted color and helper text.
- Mark validation-required fields with a visible red `*` beside the label and the matching HTML `required` attribute when applicable. Conditional fields should only show the marker in the action where they are actually required, such as passwords on create but not ordinary edit.
- Remove the first visible section divider in form partials and replace it with a small responsive spacer. It prevents the page header and first form section from being separated by an unnecessary line.
- On mobile, add field-body top spacing after each section title/description. The desktop grid separates header and body horizontally, but mobile needs vertical rhythm to avoid a dense block of text and controls.
- Use tighter mobile divider spacing between form sections, then restore the wider desktop rhythm at `sm` and above.
- Apply the same form rhythm to package-local admin forms that use the shared `laravel-admin-ui` shell. Do not leave sibling packages on the older visible-first-divider pattern.

## Detail Views

- Base detail screens on description list patterns.
- Use a summary header for the record identity before the `dl`.
- Use semantic `dl`, `dt`, and `dd` markup for label/value pairs.
- Use two columns on wider screens, one column on mobile.
- When a detail page has enough fields that a flat list becomes hard to scan, split the body into named sections inside the same card. Use short section titles and muted helper text so mobile users can distinguish the information groups without adding nested cards.
- Keep sectioned detail pages inside one bordered card. Use `h3` section labels, muted helper text, and semantic `dl` groups instead of nested cards or unrelated panels.
- Apply the sectioned detail pattern to sibling package detail screens that use local Blade markup but share the same admin UI language.
- Render status values and roles as badges.
- Put repeated page actions in a footer action area when the detail card is the main focus.
- On detail pages, keep the top-right action area focused on `목록보기` only.
- On detail page footers, show only the primary continuation action, usually `수정하기`, aligned to the right. Do not repeat `목록보기` in the footer and do not show destructive actions there unless a workflow explicitly requires deletion from detail.

## Modals

- Modal content should follow the same design language as pages: quiet card surfaces, section headers, badges, and consistent action buttons.
- Preserve all JavaScript and Livewire hooks when restyling modals. Keep existing `id`, `class`, `data-*`, and `wire:*` attributes unless the behavior is intentionally changed.
- Use modals for quick inspection and short editing flows. Provide a clear route to the full show or edit page when deeper work is available.
- For draggable modals, choose a width and height that fits the content without forcing cramped grids. Roles and menu category management modals should be wider than legacy 500px layouts when they contain badges or checkbox grids.
- Keep detail-only inspection modals compact. Use explicit `width`, `height`, and minimum size payloads so Livewire does not fall back to ModalStack defaults; user detail modals use `width: 680`, `height: 480`, and `minHeight: 420`.
- Keep modal footers right-aligned and visually separated with a top border.
- Use bordered selectable rows for checkbox lists in modals, matching the page form checkbox style.

## Buttons And Links

- Primary action: indigo filled button.
- Secondary action: white/dark bordered button.
- Destructive action: red bordered button with a clear icon.
- Destructive actions should be spatially separated from primary actions, but remain in the same footer row on desktop. Prefer left alignment for delete buttons and right alignment for navigation/edit/save buttons.
- Use the package Blade icon component for common actions.
- Override global admin link colors with Tailwind important text classes, for example `!text-white` or `!text-gray-700`, when a link is styled as a button.
- Buttons, action-menu triggers, and link-style row actions should show the pointer cursor across the whole hit area, including nested SVG icons. If CSS is published into a host app, rebuild or republish the host admin CSS so the cursor rule is present in the loaded asset.
- Table rows with multiple record commands should use `admin.action-menu`: an unboxed horizontal ellipsis trigger with adaptive up/down placement and full-width menu items for actions such as `보기` and `수정`, instead of several compact text buttons laid out inline. The dropdown should open downward by default, flip upward near the bottom edge of the viewport or nearest scroll container, and avoid creating a new table-body scrollbar merely to show the menu. Use `admin.dropdown-link` for normal link commands and a reset button for modal/Livewire commands; place secondary modal commands below the normal link commands after a thin separator line. Keep the menu compact (`w-36`), padded (`p-2`), left-aligned, and use blue hover/focus states with white text.
- Desktop and tablet list tables with row action menus should keep a minimum table-scroller height, normally `sm:min-h-64`, so one-row result sets still leave enough vertical room for the action menu without immediately hitting the table wrapper edge. Avoid applying this minimum only to mobile layouts, where the responsive table shape already reduces the overflow problem.

## Dark Mode

- Every new surface should include dark variants.
- Prefer:
  - `dark:bg-gray-900` for page/card backgrounds
  - `dark:bg-gray-800` for secondary surfaces
  - `dark:border-gray-700` for borders
  - `dark:text-white`, `dark:text-gray-300`, and `dark:text-gray-400` for text hierarchy
- Badge colors should use low-opacity dark backgrounds with readable text.
- Default to light mode when no saved `theme` exists. Apply dark mode before first paint only for explicit `dark`, or `system` with an OS dark preference.
- Use `x-cloak` on Alpine-controlled full-screen overlays such as the mobile left menu backdrop and panel so they cannot flash over the page before Alpine initializes.

## Migration Checklist

When modernizing another admin resource:

1. Update the index page first, preserving filters, pagination, policies, and routes.
2. Update create/edit wrappers and shared form partials together.
3. Update show pages with a description list pattern.
4. Normalize visible Korean labels, page titles, and action text while preserving routes and behavior.
5. Run `git diff --check`.
6. Run the available test command if dependencies are installed.
7. Compare light and dark mode visually before shipping.
