# ssh521/laravel-admin-ui

`ssh521/laravel-admin-ui`는 `ssh521/laravel-admin` 관리자 화면에서 사용하는 Blade 뷰, Blade 컴포넌트, CSS, JavaScript, 이미지 자산을 분리해 담은 UI 리소스 패키지입니다.

이 패키지는 관리자 UI의 표현 계층을 담당합니다. 인증, 라우트, 정책, 모델, 콘솔 명령, 시더, 패키지 통합 서비스는 코어 패키지인 `ssh521/laravel-admin`이 담당합니다.

## 요구 사항

- PHP `^8.3`
- Laravel Illuminate `^13.0`
- `ssh521/laravel-admin`과 함께 사용하는 호스트 Laravel 앱

## 설치

일반 설치는 Composer로 진행합니다.

```bash
composer require ssh521/laravel-admin-ui
```

로컬 패키지 개발 환경에서는 호스트 앱의 `composer.json`에 path repository로 연결해 사용할 수 있습니다.

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../packages/ssh521/laravel-admin-ui",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

Laravel의 패키지 자동 발견을 통해 `Ssh521\LaravelAdminUi\LaravelAdminUiServiceProvider`가 등록됩니다.

## 패키지 역할

이 패키지가 제공하는 항목은 다음과 같습니다.

- `resources/views` 아래의 관리자 Blade 화면
- `x-laravel-admin::...` 형태로 사용하는 관리자 Blade 컴포넌트
- 관리자 전용 CSS와 JavaScript
- `dtree` 이미지 자산
- 앱에 자체 `resources/views/errors/403.blade.php`가 없을 때 사용하는 패키지 기본 403 화면

Livewire 컴포넌트 클래스는 아직 이 패키지의 책임이 아닙니다. 현재 추출 단계에서는 Livewire 클래스는 `ssh521/laravel-admin`에 남아 있고, 해당 뷰 리소스만 이 패키지에서 제공합니다.

## 뷰와 컴포넌트 해석

서비스 프로바이더는 `laravel-admin` 뷰 네임스페이스를 등록합니다.

```php
view('laravel-admin::admin.index');
```

패키지 기본 뷰보다 호스트 앱에 퍼블리시된 뷰가 우선됩니다.

```text
resources/views/vendor/laravel-admin
resources/views/vendor/laravel-admin/components
```

익명 컴포넌트도 같은 네임스페이스로 사용할 수 있습니다.

```blade
<x-laravel-admin::admin.primary-button>
    저장하기
</x-laravel-admin::admin.primary-button>
```

## 퍼블리시 태그

UI 리소스를 호스트 앱으로 퍼블리시할 때는 아래 태그를 사용합니다.

```bash
php artisan vendor:publish --tag=laravel-admin-ui-config
php artisan vendor:publish --tag=laravel-admin-ui-assets
php artisan vendor:publish --tag=laravel-admin-ui-views
php artisan vendor:publish --tag=laravel-admin-ui-components
```

## 스타일 설정

관리자 Blade 화면에서는 기존처럼 `x-laravel-admin::admin.*` 컴포넌트를 사용합니다.
`admin` 컴포넌트 네임스페이스는 외부 API로 유지되고, 실제 구현은 설정된 스타일 폴더로 위임됩니다.

```blade
<x-laravel-admin::admin.action-button variant="primary">
    저장하기
</x-laravel-admin::admin.action-button>
```

관리자 화면의 주요 액션은 hard-coded Tailwind `<a>`/`<button>` 스타일 대신 `admin.action-button`을 사용합니다.
상단 `등록하기`, form footer의 `목록보기`/`취소`/`저장하기`/`수정하기`/`삭제하기`, 검색 submit, row link action은 같은 컴포넌트 API를 공유해야 style 전환과 dark mode 계약이 깨지지 않습니다.

```blade
<x-laravel-admin::admin.action-button :href="route('admin.users.create')" size="sm" icon="plus">
    {{ __('등록하기') }}
</x-laravel-admin::admin.action-button>

<x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass">
    {{ __('검색') }}
</x-laravel-admin::admin.action-button>
```

기본 스타일은 현재 관리자 UI와 같은 `yaverstyle`입니다.

```php
// config/laravel-admin-ui.php
'style' => env('LARAVEL_ADMIN_UI_STYLE', 'yaverstyle'),
```

환경 변수로 스타일을 전환할 수 있습니다.

```env
LARAVEL_ADMIN_UI_STYLE=yaverstyle
LARAVEL_ADMIN_UI_STYLE=daisystyle
```

컴포넌트 dispatcher는 아래 순서로 구현을 찾습니다.

```php
laravel-admin::components.{style}.{component}
laravel-admin::components.yaverstyle.{component}
```

따라서 특정 스타일 폴더에 아직 없는 컴포넌트는 `yaverstyle` 구현으로 fallback 됩니다.

`daisystyle`을 사용할 때는 호스트 앱에 DaisyUI 플러그인을 추가하고 관리자 CSS를 다시 빌드해야 합니다.

```bash
npm install daisyui --save-dev
```

`resources/vendor/laravel-admin/admin.css`:

```css
@import "tailwindcss";
@plugin "daisyui";
```

```bash
npm run build
php artisan config:clear
php artisan view:clear
```

기존 PHP class resolver는 공개 설정으로 노출하지 않습니다. 스타일 전환의 기준 API는 `LARAVEL_ADMIN_UI_STYLE`입니다.

컴포넌트 목록과 사용 기준은 [docs/components.md](docs/components.md)를 기준으로 관리합니다.
새 style 개발 계약과 AI 개발 체크리스트는 [docs/style-development-contract.md](docs/style-development-contract.md)를 기준으로 합니다.

## Livewire ModalStack

관리자 모달 표준은 `laravel-admin`의 `admin.modal-stack`입니다. 모달 안에 Livewire 컴포넌트를 동적으로 띄우고, 닫을 때 stack entry를 제거해 내부 컴포넌트가 DOM에서 함께 제거되도록 합니다.

```blade
<livewire:admin.modal-stack />
```

부모 Livewire 컴포넌트에서는 원하는 child component를 stack에 추가합니다.

```php
$this->dispatch('admin:modal-stack:push', [
    'id' => 'user-edit-'.$user->id.'-'.uniqid(),
    'component' => 'admin.users.user-edit-modal',
    'params' => ['userId' => $user->id],
    'title' => '사용자 수정',
    'size' => 'md',
    'width' => 576,
    'height' => 560,
]);
```

`admin:modal-stack:open`은 기존 stack을 교체하고, `admin:modal-stack:push`는 nested modal을 추가합니다. 닫기는 `admin:modal-stack:close`, `admin:modal-stack:close-top`, `admin:modal-stack:close-all`을 사용합니다.

ModalStack 항목은 `id`, `component`, `params`, `key`, `title`, `size`, `version`, `width`, `height`, `minWidth`, `minHeight`, `draggable`, `resizable`, `closeOnBackdrop` 정보를 가집니다. `key`는 component name, modal id, params hash, version 조합으로 생성됩니다. 따라서 A 사용자 모달을 닫고 B 사용자 모달을 열면 B는 새 Livewire 인스턴스로 mount되고 A의 입력값이나 validation error를 공유하지 않습니다.

자식 모달은 저장 후 이벤트를 dispatch하고 필요하면 자신의 stack entry를 닫습니다.

```php
$this->dispatch('user-saved', userId: $this->userId);
$this->dispatch('admin:modal-stack:close', id: $this->modalStackId);
```

부모 목록은 `#[On]`으로 저장 이벤트를 수신해 목록을 다시 렌더링합니다. 동적 child component 전체에 `wire:ignore`를 걸지 말고, Alpine drag/resize가 필요한 경우 ModalStack shell wrapper에만 `wire:ignore.self`를 사용합니다.

금지된 레거시 계약:

- `draggable-modal`
- `modal-trigger`
- `modal-manager.js`
- `open-modal` / `close-modal`
- fetched HTML modal injection

## 퍼블리시 경로

자산은 패키지 분리 전과 같은 호스트 앱 경로로 퍼블리시됩니다.

```text
resources/vendor/laravel-admin/admin.css
resources/vendor/laravel-admin/admin.js
resources/vendor/laravel-admin/dtree.js
resources/vendor/laravel-admin/modal-utils.js
config/laravel-admin-ui.php
resources/views/vendor/laravel-admin
public/images/dtree
```

호스트 앱의 Vite 입력에는 관리자 CSS와 JavaScript를 포함해야 합니다.

```js
'resources/vendor/laravel-admin/admin.css',
'resources/vendor/laravel-admin/admin.js',
```

CSS 또는 JavaScript를 변경한 뒤에는 호스트 앱에 자산을 다시 퍼블리시하고 Vite 빌드를 갱신해야 실제 화면에 반영됩니다.

## 403 화면

이 패키지는 관리자 UI 스타일의 기본 403 화면을 제공합니다.

앱에 `resources/views/errors/403.blade.php`가 있으면 Laravel 앱의 뷰가 우선됩니다. 앱에 해당 파일이 없고, JSON 응답이 아닌 403 예외가 발생하면 패키지의 `laravel-admin::errors.403` 뷰가 렌더링됩니다.

## 디자인 기준

관리자 UI 개편 기준은 아래 문서가 기준입니다.

- [docs/admin-design-rules.md](docs/admin-design-rules.md): 이 패키지 내부 화면을 현대화할 때 따르는 세부 규칙
- [docs/admin-ui-design-contract.md](docs/admin-ui-design-contract.md): 다른 `ssh521/*` 패키지가 관리자 화면을 구현할 때 공유해야 하는 이식 가능한 UI 계약
- [docs/components.md](docs/components.md): `x-laravel-admin::admin.*` 컴포넌트 카탈로그와 적용 기준

다른 패키지에서 관리자 화면을 만들거나 수정할 때는 `laravel-admin-ui`를 표현 계층의 기준으로 보고, 위 계약 문서를 먼저 확인합니다.
반복되는 버튼, 배지, 필터 바, 빈 상태, 폼 컨트롤은 `x-laravel-admin::admin.*` 컴포넌트를 우선 사용합니다.

## 개발과 검증

의존성이 설치되어 있다면 패키지 테스트는 아래 명령으로 실행합니다.

```bash
composer test
```

문서나 Blade/CSS 변경 후에는 최소한 아래 항목을 확인합니다.

```bash
git diff --check
```

패키지 루트에 PHPUnit 의존성이 없을 때는 워크벤치의 공유 runner를 사용할 수 있습니다.

```bash
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```

호스트 앱에서 화면을 검증할 때는 퍼블리시된 override 뷰와 자산이 패키지 원본보다 우선될 수 있다는 점을 함께 확인해야 합니다.
