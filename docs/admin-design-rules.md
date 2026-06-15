# Admin Design Rules

This document records the UI direction used for the `admin-users` pilot screens.
Use it as the baseline when modernizing other admin list, form, and detail pages.

## References

- Lists: https://tailwindcss.com/plus/ui-blocks/application-ui/lists/tables
- Forms: https://tailwindcss.com/plus/ui-blocks/application-ui/forms/form-layouts
- Detail views: https://tailwindcss.com/plus/ui-blocks/application-ui/data-display/description-lists

## Overall Direction

- Keep admin screens quiet, structured, and task-focused.
- Prefer Tailwind Plus Application UI patterns over legacy dashed boxes and dense 12px table layouts.
- Use restrained neutral surfaces with clear borders, subtle shadows, and indigo as the primary action color.
- Keep layout width consistent across related screens. For resource management pages, use `max-w-4xl` for forms/detail and full-width table layouts for lists.
- Preserve existing routes, authorization checks, validation, and data behavior when changing presentation.

## Page Structure

- Use a concise page title with a short helper description below it.
- Put primary actions in the top-right on desktop and below the title on mobile.
- Use `bg-white dark:bg-gray-900` for the main page surface.
- Avoid nested decorative cards. Use cards only when they frame a concrete data object or form group.
- Keep spacing generous but operational: `px-4 py-6 sm:px-6 lg:px-8` is the default page padding.

## Lists

- Base list screens on Tailwind table patterns:
  - `flow-root` wrapper
  - responsive horizontal overflow
  - `divide-y` table separators
  - compact text with `text-sm`
- Put the primary identity field first. For users, show name, email, and a small initial avatar.
- Hide secondary columns on small screens and repeat critical secondary info inside the first column when needed.
- Render statuses and roles as small badges, not plain comma-separated text.
- Use icon+text action links for row actions such as view and edit.
- Keep search and filters in a compact bordered filter bar above the table.

## Forms

- Base forms on sectioned Tailwind form layouts.
- Split large forms into meaningful sections with:
  - section title
  - short description
  - form controls in the right column on desktop
- Use consistent inputs:
  - rounded `md`
  - gray border
  - white/dark background
  - indigo focus ring
- Put related checkbox options in bordered selectable rows or grids.
- Keep submit/cancel actions right-aligned at the bottom.
- Preserve locked states with disabled controls plus muted color and helper text.

## Detail Views

- Base detail screens on description list patterns.
- Use a summary header for the record identity before the `dl`.
- Use semantic `dl`, `dt`, and `dd` markup for label/value pairs.
- Use two columns on wider screens, one column on mobile.
- Render status values and roles as badges.
- Put repeated page actions in a footer action area when the detail card is the main focus.

## Buttons And Links

- Primary action: indigo filled button.
- Secondary action: white/dark bordered button.
- Destructive action: red bordered button with a clear icon.
- Use Font Awesome icons already available in this package for common actions.
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
4. Run `git diff --check`.
5. Run the available test command if dependencies are installed.
6. Compare light and dark mode visually before shipping.
