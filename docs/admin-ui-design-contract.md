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

For implementation details and AI-agent workflow, use [style-development-contract.md](style-development-contract.md).

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

- List pages should use the full-width `admin/admin-users` canvas rhythm: `w-full bg-white px-2 py-2` with an inner `min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8`, or an equivalent shared component that renders that structure.
- The admin layout main area must own the admin shell background so long list pages do not reveal the body background while scrolling.
- Forms and detail cards should align on `mx-auto max-w-4xl`.
- Page title should be concise, with one short helper sentence below it.
- Primary actions should sit at the top-right on desktop and below the title on mobile.
- Admin header navigation should follow the `admin/popups` pattern. Dashboard and list pages use `관리자 홈 - {리소스 관리}`. Create, detail, and edit pages use `관리자 홈 - {리소스 목록} - 등록|상세|수정`.
- Use short action crumbs such as `등록`, `상세`, and `수정`; do not append long record titles to the admin-header breadcrumb.
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
- Do not expose technical identifiers or generated ordering values such as database IDs, key IDs, or sort order as primary list/detail display fields unless an admin workflow explicitly needs the raw value.
- Render table headers as a quiet header band: `border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80`.
- Use compact table rhythm: `py-3` on header cells and body cells. Reduce avatars/icons inside dense rows to `h-9 w-9` or `size-9` when needed.
- Center the first visible identity column header when the table starts with the primary name/title column. If utility columns such as order handles, checkboxes, or row numbers appear before it, keep those utility headers visually minimal and center the first real identity header instead.
- For ordinary sortable list pages, make sortable column titles direct links that preserve the current query string and toggle sort direction. Reserve drag-sort and click/drag mode switches for resource-ordering pages such as `admin/permissions`.
- For paginator controls on resource list pages, match the `admin/users` baseline: render Laravel's paginator links inside `@if($items->hasPages()) <div class="mt-6 text-sm">...</div> @endif`, using `links()` with `appends(request()->query())` or `withQueryString()` so filters remain intact. Do not replace numbered list pagination with a custom previous/next-only component unless the resource explicitly uses simple pagination.
- Use avatars only for person/user records where recognition helps.
- Render statuses as badges.
- Hide secondary columns on small screens and repeat critical info inside the first column.
- Keep name/title modal triggers separate from explicit `상세보기` links.
- Render table row commands through `x-laravel-admin::admin.action-menu` when the row has multiple commands such as `보기`/`상세보기` and `수정`. The trigger should be an unboxed horizontal ellipsis hit area, and the menu should use an adaptive dropdown that opens down by default and up near scroll boundaries.
- Action-menu panels should keep a compact command-menu feel: about `w-36`, a white rounded panel with `p-2`, left-aligned full-width items, `rounded-lg` hover surfaces, and blue hover/focus states with white text. Use `x-laravel-admin::admin.dropdown-link` for normal link commands such as `보기`/`상세보기` and `수정`; use a reset button for modal/Livewire commands and place secondary modal commands below the normal link commands after a thin separator line. Do not keep several compact text buttons inline inside the table cell.

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
- Keep destructive and save actions visible on the same footer row on mobile and desktop.
- Use `flex-row`, `items-center`, `justify-between`, and non-wrapping action groups for edit footers so a narrow viewport does not split delete and save actions into separate rows.
- Avoid extra top margin on footer rows immediately after section dividers.
- Reuse a shared form partial for create/edit when fields overlap, while keeping page titles, routes, HTTP methods, and edit-only external actions in the page wrapper.
- Form page titles should include the resource, information scope, and action, such as `회원 정보 등록` or `회원 정보 수정`.
- Edit page wrappers should follow the `admin/admin-users/edit` baseline: keep the top header informational, avoid extra top-right navigation such as `상세보기` unless the workflow explicitly requires it, and place delete/cancel/update actions in the footer row.
- Use `수정하기` for the primary submit button on edit pages that update an existing record.

## Detail Contract

Detail screens should:

- Use a single bordered card for the main record.
- Include a summary header for identity.
- Use semantic `dl`, `dt`, and `dd` markup.
- Use one column on mobile and two columns when there is enough width.
- Render statuses, roles, and categories as badges.
- Put repeated actions in the card footer.
- Show only list navigation in the top action area, using the visible label `목록보기`.
- Show only the primary continuation action, usually edit, in the footer.

## ModalStack Contract

`admin.modal-stack` is the only admin modal contract. Legacy Alpine wrappers, trigger dispatchers, and HTML injection modals are not part of the current contract.

Ownership:

- `laravel-admin-ui` owns the ModalStack shell view, drag/resize JavaScript, z-index presentation, and documentation contract.
- `laravel-admin` owns the `admin.modal-stack` Livewire class and domain child components.
- Feature packages should expose modal content as mountable Livewire child components and open them through the stack events.

Modal entry shape:

| Field | Required | Purpose |
| --- | --- | --- |
| `id` | yes | Stable stack entry id used for close/remove. |
| `component` | yes | Livewire component alias, for example `admin.users.user-edit-modal`. |
| `params` | yes | Mount parameters for the child component. `modalStackId` is injected when missing. |
| `key` | generated | Unique Livewire key. Generated from component name, modal id, params hash, and version. |
| `title` | yes | Shell title. |
| `size` | yes | Semantic width hint: `sm`, `md`, `lg`, `xl`, `2xl`, or `full`. |
| `version` | generated | Monotonic stack version used to force fresh child identity. |
| `width`, `height` | optional | Initial shell dimensions in pixels. |
| `minWidth`, `minHeight` | optional | Resize limits. |
| `draggable`, `resizable` | optional | Enable shell drag and resize. Defaults to enabled. |
| `closeOnBackdrop` | optional | Whether backdrop click closes the top modal. Defaults to enabled. |

Open and close API:

- `admin:modal-stack:open` replaces the current stack with one modal.
- `admin:modal-stack:push` appends a modal and supports nested modals.
- Event payloads may be sent as a single array/object or as named Livewire arguments. The ModalStack Livewire class must preserve `width`, `height`, `minWidth`, `minHeight`, `draggable`, `resizable`, and `closeOnBackdrop` from named event payloads instead of falling back to defaults.
- `admin:modal-stack:close` removes a specific `id`; without an id it closes the top modal.
- `admin:modal-stack:close-top` closes only the last modal.
- `admin:modal-stack:close-all` clears the stack.

Lifecycle rules:

- Closing a modal must remove its stack entry so the child Livewire component is removed from the DOM.
- Reopening a modal must create a new child Livewire instance with a new generated key.
- The same component may be opened multiple times with different params; state and validation errors must not cross between entries.
- Do not rely on changing parent props to refresh an already mounted child component.
- Do not rely on `mount()` being called again unless the stack entry was removed and a new key was generated.

UI and interaction rules:

- Modal content should reuse the same page design language: bordered card surfaces, description lists for detail content, bordered selectable rows for checkboxes, and footer actions separated by a top border.
- Prefer wider modal dimensions when content contains badges, grids, or selectable rows.
- Detail-only inspection modals should stay compact. User detail modals use a 680px width and 480px initial height unless the content grows beyond that pattern.
- Keep quick-edit forms short; move complex editing to the full edit page.
- ModalStack owns drag, resize, z-index ordering, ESC close, backdrop close, and top-modal-only close behavior.
- The last modal in the stack must render with the highest z-index.
- ESC, backdrop click, and shell close buttons should affect only the top modal unless an explicit modal id is supplied.

Forbidden patterns:

- Do not use `x-show` alone to hide dynamic Livewire modal content.
- Do not put `wire:ignore` on the whole nested Livewire component.
- Do not reintroduce `draggable-modal`, `modal-trigger`, `modal-manager.js`, `open-modal`, or `close-modal`.
- Do not inject fetched HTML into a modal shell for admin workflows that need Livewire state.

Event refresh rules:

- Child modal components should dispatch a saved event such as `user-saved` or a package-scoped equivalent.
- Parent list components should listen with `#[On]` and rebuild their query on render.
- Child components may close their own stack entry by dispatching `admin:modal-stack:close` with `id: $this->modalStackId`.

## Button Contract

Use consistent action hierarchy:

- Use `x-laravel-admin::admin.action-button` for primary, secondary, destructive, search, and standalone link actions.
- Use `variant="primary"`, `variant="secondary"`, `variant="danger"`, `variant="search"`, and `variant="link"` instead of hard-coded style classes in feature package views.
- Use `variant="search"` for list filter submit buttons; keep the search button shrink-wrapped on desktop with `shrink-0 whitespace-nowrap` when it sits next to a flexible input.
- Use `x-laravel-admin::admin.action-menu` for table row actions such as `보기`, `상세보기`, and `수정`; reserve `variant="link"` for standalone inline links or card/detail actions where an overflow menu is not the expected interaction.
- Action buttons must expose a pointer cursor on the button/link and its icon/text children. Keep the shared `laravel-admin-action-button` hook in every style implementation and mirror any required cursor CSS into the published admin CSS/build output used by the host app.
- Dynamic state controls such as sort mode toggles may keep local `:class`/`x-bind:class` color logic when the visual state itself is the behavior.
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

- Style development contract: [style-development-contract.md](style-development-contract.md)
- Detailed implementation rules: [admin-design-rules.md](admin-design-rules.md)
- Component catalog: [components.md](components.md)
- Package README: [../README.md](../README.md)
