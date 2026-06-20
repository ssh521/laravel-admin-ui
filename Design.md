# Laravel Admin UI Design System

This document defines the shared design rules for the laravel-admin-ui package.

## Purpose

All Blade, Livewire, and Tailwind components should follow this document.

## Package Namespace

The package registers views and anonymous Blade components under the `laravel-admin` namespace.

Usage examples:

- x-laravel-admin::button
- x-laravel-admin::card
- x-laravel-admin::badge

## Color Tokens

Brand colors are used for primary actions.

- brand-50: light background
- brand-100: soft background
- brand-500: primary action
- brand-600: hover state
- brand-700: emphasized text

Neutral colors are used for layout and text.

- neutral-0: white background
- neutral-50: page background
- neutral-100: soft section background
- neutral-200: border
- neutral-500: secondary text
- neutral-800: body text
- neutral-900: heading text

State colors are used for feedback.

- success-500: success
- warning-500: warning
- danger-500: error or destructive action

## Spacing

Use a 4px grid.

- 1 = 4px
- 2 = 8px
- 3 = 12px
- 4 = 16px
- 6 = 24px
- 8 = 32px
- 10 = 40px
- 12 = 48px

Default component padding is p-4. Default component gap is gap-3 or gap-4.

## Typography

- Page title: text-2xl md:text-3xl font-semibold text-neutral-900
- Section title: text-lg font-semibold text-neutral-900
- Body: text-base leading-7 text-neutral-800
- Caption: text-sm text-neutral-500
- Label: text-sm font-medium text-neutral-700

## Radius and Shadow

- Button: rounded-lg
- Card: rounded-xl shadow-sm
- Modal: rounded-xl shadow-lg
- Input: rounded-lg

## Interaction States

- Hover: hover:bg-brand-600
- Focus: focus:outline-none focus:ring-2 focus:ring-brand-400
- Disabled: disabled:opacity-50 disabled:cursor-not-allowed

## Responsive Rules

Use mobile-first layout.

- sm: small tablet
- md: two-column grid
- lg: sidebar or three-column grid
- xl: expanded desktop spacing

## Component Naming

- laravel-admin::button
- laravel-admin::card
- laravel-admin::modal
- laravel-admin::badge
- laravel-admin::table

## Props Convention

Common props:

- variant: solid, outline, ghost, danger
- size: sm, md, lg

## Expansion Priority

1. Button
2. Card
3. Input
4. Select
5. Badge
6. Modal
7. Table
8. AdminList
9. Sidebar
10. Topbar
