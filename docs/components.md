# Admin Component Catalog

이 문서는 `x-laravel-admin::admin.*` Blade 컴포넌트의 역할과 사용 기준을 정리합니다.

컴포넌트는 Blade API를 안정적으로 유지하고, 실제 class 출력은 현재 등록된 `ThemeContract`가 결정합니다. 기본 테마는 `tailwind`이며, `ssh521/laravel-admin-ui-daisyui` 같은 어댑터 패키지는 같은 컴포넌트 API를 다른 class 체계로 렌더링합니다.

## Page And Layout

| Component | Purpose |
| --- | --- |
| `admin.page-section` | 관리자 페이지 기본 캔버스, 제목, 설명, action slot |
| `admin.page-header` | breadcrumb, 제목, 설명, action slot 조합 |
| `admin.card` | 제목/설명/action/body/footer가 있는 bordered surface |
| `admin.drawer` | 보조 상세/필터/편집을 위한 slide panel |
| `admin.divider` | 카드, 폼, 모달 내부 구획 분리 |
| `admin.accordion` | 페이지 흐름 안에서 접고 펼치는 상세 그룹 |
| `admin.tabs` | 설정/상세 하위 섹션 탭 |

## Actions And Menus

| Component | Purpose |
| --- | --- |
| `admin.action-button` | primary, secondary, danger, search, link action |
| `admin.primary-button` | legacy primary submit button |
| `admin.secondary-button` | legacy secondary button |
| `admin.danger-button` | legacy destructive button |
| `admin.dropdown` | compact command menu container |
| `admin.dropdown-link` | dropdown 내부 링크 item |
| `admin.action-menu` | row action dropdown trigger + content |
| `admin.confirm-dialog` | 삭제/위험 작업 확인 dialog |
| `admin.copy-button` | 값 표시와 clipboard 복사 action |
| `admin.export-button` | CSV/Excel/PDF 등 내보내기 dropdown |
| `admin.bulk-action-bar` | 선택된 행 수와 일괄 action |

## Lists And Tables

| Component | Purpose |
| --- | --- |
| `admin.filter-bar` | 목록 검색/필터 control wrapper |
| `admin.search-input` | 검색 icon, input, clear link |
| `admin.filter-select` | 목록 필터용 label/select |
| `admin.date-range` | 시작일/종료일 필터 |
| `admin.sort-control` | 정렬 필드와 방향 select |
| `admin.column-toggle` | 테이블 컬럼 표시/숨김 menu |
| `admin.table-shell` | responsive table overflow wrapper |
| `admin.table-empty-row` | `<tbody>` 내부 empty row |
| `admin.empty-state` | 표 밖의 빈 상태 안내 |
| `admin.pagination` | simple previous/next paginator wrapper |

## Forms

| Component | Purpose |
| --- | --- |
| `admin.form-section` | 12-column form section layout |
| `admin.field` | label, help text, validation error wrapper |
| `admin.form-input` | text/date/number 등 기본 input |
| `admin.form-select` | select control |
| `admin.form-textarea` | textarea control |
| `admin.checkbox-row` | bordered checkbox row |
| `admin.checkbox-card` | 카드형 checkbox option |
| `admin.radio-card` | 카드형 radio option |
| `admin.file-upload` | drag-style file input shell |
| `admin.inline-edit` | 짧은 값 빠른 수정 form |
| `admin.permission-matrix` | 권한 그룹 checkbox matrix |

## Data Display

| Component | Purpose |
| --- | --- |
| `admin.badge` | neutral/primary/success/warning/danger status label |
| `admin.status-dot` | 작은 점 + label 상태 표시 |
| `admin.stat` | dashboard metric card |
| `admin.description-list` | detail page `dl/dt/dd` list |
| `admin.key-value-grid` | compact settings/detail grid |
| `admin.user-cell` | avatar + name + email table cell |
| `admin.avatar` | image or initials fallback avatar |
| `admin.progress` | progressbar |
| `admin.stepper` | 단계형 진행 상태 |
| `admin.timeline` | 변경 이력/활동 기록 |
| `admin.code-block` | code, payload, log snippet display |
| `admin.kbd` | keyboard shortcut keycap |

## Feedback And State

| Component | Purpose |
| --- | --- |
| `admin.toast` | dismissible transient message |
| `admin.notice` | 정적인 안내/주의 box |
| `admin.alert` | existing alert component |
| `admin.session-messages` | session success/error/warning/info renderer |
| `admin.loading-overlay` | async operation loading overlay |
| `admin.skeleton` | loading placeholder |

## Shell And Utility

| Component | Purpose |
| --- | --- |
| `admin.layouts.admin` | admin layout component |
| `admin.admin-header` | legacy admin header |
| `admin.icon` | shared inline SVG icon map |
| `admin.input-error` | validation error line |
| `admin.input-label` | legacy input label |
| `admin.label` | label utility |
| `admin.validation-errors` | validation summary |
| `admin.checkbox` | base checkbox |
| `admin.checkbox-controls` | checkbox group controls |
| `admin.client-notification` | client notification surface |
| `admin.dark-mode-toggle` | dark mode toggle |
| `admin.nav-link` | navigation link |
| `admin.switchable-team` | team switch item |
| `admin.banner` | banner surface |
| `admin.section-border` | legacy section border |
| `admin.site-logo` | admin logo area |
| `admin.modal-trigger` | modal open trigger |
| `admin.draggable-modal` | draggable modal wrapper |

## Adoption Notes

- Keep package-owned routes, policies, form names, `wire:*`, `x-*`, and authorization checks in the consuming package.
- Prefer replacing repeated Tailwind class clusters with components before creating new component types.
- Add a new component only when at least one real package screen needs the pattern.
- When a component needs styling, add a stable key to `ThemeContract` implementations rather than embedding a style package assumption in package screens.
