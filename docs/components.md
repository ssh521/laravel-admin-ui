# Admin Component Catalog

이 문서는 `x-laravel-admin::admin.*` Blade 컴포넌트의 역할과 사용 기준을 정리합니다.

컴포넌트는 Blade API를 안정적으로 유지하고, 실제 구현은 `laravel-admin-ui.style` 설정에 따라 style 폴더에서 선택됩니다.
새 style 개발 절차와 검증 기준은 [style-development-contract.md](style-development-contract.md)를 기준으로 합니다.

```text
resources/views/components/admin       dispatcher, public API
resources/views/components/yaverstyle  default implementation
resources/views/components/daisystyle  DaisyUI implementation
```

기본 style은 `yaverstyle`입니다.

```env
LARAVEL_ADMIN_UI_STYLE=yaverstyle
LARAVEL_ADMIN_UI_STYLE=daisystyle
```

`components/admin`은 외부 API용 dispatcher이므로 제거하거나 이름을 바꾸지 않습니다. 커스텀 style은 `components/customstyle` 같은 새 폴더로 추가합니다.

Dispatcher는 선택된 style 구현을 먼저 찾고, 없으면 `yaverstyle`로 fallback 합니다.

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
| `admin.action-button` | primary, secondary, danger, search, link action; use for `등록하기`, `목록보기`/`취소`, `저장하기`/`수정하기`, `삭제하기`, 검색 submit, and compact row actions; must keep pointer cursor on the whole hit area |
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
| `admin.filter-bar` | 목록 검색/필터 control wrapper; pair with `admin.action-button variant="search"` for submit |
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

## DaisyUI Coverage

현재 `daisystyle`에 별도 구현이 있는 컴포넌트는 다음과 같습니다.

| Area | Components |
| --- | --- |
| Actions | `admin.action-button`, `admin.primary-button`, `admin.secondary-button` |
| Feedback | `admin.alert`, `admin.badge`, `admin.notice` |
| Forms | `admin.form-input`, `admin.form-select`, `admin.form-textarea`, `admin.checkbox-row`, `admin.input-error-message` |
| Lists | `admin.filter-bar`, `admin.filter-select`, `admin.search-input`, `admin.table-shell`, `admin.table-empty-row`, `admin.empty-state` |
| Page/Data | `admin.page-section`, `admin.page-header`, `admin.card`, `admin.key-value-grid`, `admin.stat` |

나머지 컴포넌트는 `daisystyle`에서도 `yaverstyle` 구현으로 fallback 됩니다.

## Adoption Notes

- Keep package-owned routes, policies, form names, `wire:*`, `x-*`, and authorization checks in the consuming package.
- Prefer replacing repeated Tailwind class clusters with `x-laravel-admin::admin.*` components before creating new component types.
- Add a new component only when at least one real package screen needs the pattern.
- When a package needs custom styling, add a style folder implementation such as `components/customstyle/{component}.blade.php` rather than editing feature package screens for each style.
