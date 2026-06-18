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
php artisan vendor:publish --tag=laravel-admin-ui-assets
php artisan vendor:publish --tag=laravel-admin-ui-views
php artisan vendor:publish --tag=laravel-admin-ui-components
```

## 퍼블리시 경로

자산은 패키지 분리 전과 같은 호스트 앱 경로로 퍼블리시됩니다.

```text
resources/vendor/laravel-admin/admin.css
resources/vendor/laravel-admin/admin.js
resources/vendor/laravel-admin/dtree.js
resources/vendor/laravel-admin/modal-manager.js
resources/vendor/laravel-admin/modal-utils.js
resources/vendor/laravel-admin/sidebarBackground.js
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

다른 패키지에서 관리자 화면을 만들거나 수정할 때는 `laravel-admin-ui`를 표현 계층의 기준으로 보고, 위 계약 문서를 먼저 확인합니다.

## 개발과 검증

의존성이 설치되어 있다면 패키지 테스트는 아래 명령으로 실행합니다.

```bash
composer test
```

문서나 Blade/CSS 변경 후에는 최소한 아래 항목을 확인합니다.

```bash
git diff --check
```

호스트 앱에서 화면을 검증할 때는 퍼블리시된 override 뷰와 자산이 패키지 원본보다 우선될 수 있다는 점을 함께 확인해야 합니다.
