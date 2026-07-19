# ssh521/laravel-admin-ui

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ssh521/laravel-admin-ui.svg?style=flat-square)](https://packagist.org/packages/ssh521/laravel-admin-ui)
[![Total Downloads](https://img.shields.io/packagist/dt/ssh521/laravel-admin-ui.svg?style=flat-square)](https://packagist.org/packages/ssh521/laravel-admin-ui)
[![License](https://img.shields.io/packagist/l/ssh521/laravel-admin-ui.svg?style=flat-square)](LICENSE)

[`ssh521/laravel-admin`](https://packagist.org/packages/ssh521/laravel-admin)의 관리자 화면에 필요한 Blade 뷰, 컴포넌트, CSS, JavaScript, 이미지 자산과 오류 화면을 제공하는 표현 계층 패키지입니다.

인증, 관리자 guard, route, 정책, 모델, seeder와 콘솔 명령은 코어 패키지인 `ssh521/laravel-admin`이 담당합니다.

## 주요 기능

- `laravel-admin::` Blade 뷰 네임스페이스
- `x-laravel-admin::admin.*` 익명 Blade 컴포넌트
- 관리자 목록·폼·상세·필터·액션 UI
- 반응형 레이아웃, 다크 모드와 키보드 접근성
- `yaverstyle`과 선택형 `daisystyle` 스타일
- Livewire `ModalStack` 표현 계약
- 패키지 기본 403·419 오류 화면
- 퍼블리시 가능한 독립형 503 유지보수 화면

## 요구 사항

- PHP `^8.3`
- Laravel/Illuminate `^13.0`
- `ssh521/laravel-admin`을 사용하는 Laravel 호스트 애플리케이션

## 설치

일반적으로 코어 패키지를 설치하면 `laravel-admin-ui`가 함께 설치됩니다.

```bash
composer require ssh521/laravel-admin
php artisan laravel-admin:install
npm install
npm run build
```

UI 패키지만 직접 개발하거나 의존성을 명시적으로 고정해야 할 때는 별도로 설치할 수 있습니다.

```bash
composer require ssh521/laravel-admin-ui
```

Laravel의 패키지 자동 발견을 통해 `Ssh521\LaravelAdminUi\LaravelAdminUiServiceProvider`가 등록됩니다.

## Blade 컴포넌트

패키지 뷰에서는 `x-laravel-admin::admin.*` 네임스페이스를 사용합니다.

```blade
<x-laravel-admin::admin.action-button
    :href="route('admin.users.create')"
    variant="primary"
    icon="plus"
>
    등록하기
</x-laravel-admin::admin.action-button>
```

버튼, 폼 컨트롤, 배지, 필터 바, 빈 상태와 액션 메뉴는 공용 컴포넌트를 우선 사용해야 스타일 전환과 다크 모드 계약이 유지됩니다.

전체 컴포넌트 목록은 [컴포넌트 카탈로그](docs/components.md)를 참고하십시오.

## 스타일 설정

기본 스타일은 `yaverstyle`입니다.

```dotenv
LARAVEL_ADMIN_UI_STYLE=yaverstyle
```

`daisystyle`을 사용할 때는 호스트 애플리케이션에 DaisyUI를 추가하고 관리자 CSS를 다시 빌드합니다.

```bash
npm install daisyui --save-dev
npm run build
php artisan config:clear
php artisan view:clear
```

스타일 구현 규칙은 [스타일 개발 계약](docs/style-development-contract.md)을 참고하십시오. 특정 스타일에 구현되지 않은 컴포넌트는 `yaverstyle` 구현으로 fallback됩니다.

## 뷰와 자산 퍼블리시

호스트 애플리케이션에서 직접 커스터마이징해야 하는 리소스만 선택적으로 퍼블리시합니다.

```bash
php artisan vendor:publish --tag=laravel-admin-ui-config
php artisan vendor:publish --tag=laravel-admin-ui-assets
php artisan vendor:publish --tag=laravel-admin-ui-views
php artisan vendor:publish --tag=laravel-admin-ui-components
php artisan vendor:publish --tag=laravel-admin-ui-maintenance-view
```

주요 퍼블리시 경로는 다음과 같습니다.

```text
config/laravel-admin-ui.php
resources/vendor/laravel-admin/admin.css
resources/vendor/laravel-admin/admin.js
resources/views/vendor/laravel-admin
resources/views/errors/503.blade.php
public/images/dtree
```

퍼블리시된 호스트 뷰와 자산은 패키지 원본보다 우선합니다. 패키지 업데이트를 계속 받으려면 불필요한 전체 뷰 퍼블리시는 피하고 커스터마이징 범위를 작게 유지하십시오.

## Vite 자산

관리자 CSS와 JavaScript는 호스트 애플리케이션의 Vite input에 포함되어야 합니다.

```js
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/vendor/laravel-admin/admin.css',
        'resources/vendor/laravel-admin/admin.js',
    ],
})
```

`php artisan laravel-admin:install`과 `php artisan laravel-admin:update`가 필요한 자산과 Vite input을 관리합니다.

## Livewire ModalStack

동적 Livewire 모달을 사용하는 페이지에는 `admin.modal-stack`을 한 번 렌더링합니다.

```blade
<livewire:admin.modal-stack />
```

모달 열기, 중첩, 닫기, drag·resize와 인스턴스 격리 규칙은 [관리자 UI 계약의 ModalStack 섹션](docs/admin-ui-design-contract.md#modalstack-contract)을 참고하십시오.

## 403·419·503 화면

이 패키지는 `laravel-admin::errors.403`, `laravel-admin::errors.419`, `laravel-admin::errors.503` 뷰를 제공합니다.

- 403 화면은 호스트 애플리케이션에 자체 오류 뷰가 없을 때 사용됩니다.
- 419 화면은 일반 요청과 관리자 요청을 구분해 올바른 로그인 경로로 안내합니다.
- 503 화면은 외부 CSS, JavaScript, 이미지 없이 동작하는 독립형 유지보수 화면입니다.

패키지 기본 503 화면을 바로 사용하려면 다음 명령을 실행합니다.

```bash
php artisan down --render="laravel-admin::errors.503"
```

앱 이름, 로고와 문구를 변경하려면 호스트 애플리케이션으로 퍼블리시한 뒤 수정합니다.

```bash
php artisan vendor:publish --tag=laravel-admin-ui-maintenance-view
php artisan down --render="errors::503"
```

기존 `resources/views/errors/503.blade.php`는 기본적으로 덮어쓰지 않습니다. 의도적으로 교체할 때만 `--force`를 사용하십시오.

## 문서

- [컴포넌트 카탈로그](docs/components.md)
- [관리자 UI 디자인 계약](docs/admin-ui-design-contract.md)
- [스타일 개발 계약](docs/style-development-contract.md)
- [세부 디자인 규칙](docs/admin-design-rules.md)

## 개발과 테스트

```bash
composer test
git diff --check
```

Blade, CSS 또는 JavaScript를 변경한 경우 Laravel 13 호스트 애플리케이션에서 Vite build, Blade view cache, 데스크톱·모바일과 라이트·다크 모드를 함께 확인해야 합니다.

## 지원과 보안

버그와 기능 요청은 [GitHub Issues](https://github.com/ssh521/laravel-admin-ui/issues)에 등록해 주십시오. 보안 취약점은 공개 이슈 대신 [GitHub Security Advisory](https://github.com/ssh521/laravel-admin-ui/security/advisories/new)로 제보해 주십시오.

## 라이선스

이 패키지는 [MIT License](LICENSE)로 배포됩니다.
