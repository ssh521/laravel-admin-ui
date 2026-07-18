# Packagist 공개 작업 지시서

## 목적

`ssh521/laravel-admin-ui`를 Packagist에 공개 가능한 Composer 패키지 상태로 정리한다.
런타임 동작은 변경하지 않고, 공개 메타데이터, 라이선스, README, 릴리스 검증, GitHub 태그, Packagist 등록 절차만 다룬다.

공개 기준은 Composer schema와 Packagist 안내를 따른다.

- Composer schema: https://getcomposer.org/doc/04-schema.md
- Packagist: https://packagist.org/about

## 1. 공개 전 메타데이터 정리

`composer.json`을 Packagist 공개 기준에 맞춘다.

- `version` 필드를 제거한다. Packagist 공개 패키지는 Git 태그로 버전을 판단한다.
- `keywords`를 추가한다.
  - `laravel`
  - `admin`
  - `blade`
  - `ui`
  - `components`
  - `assets`
- `homepage`을 추가한다.
  - `https://github.com/ssh521/laravel-admin-ui`
- `support`를 추가한다.
  - `issues`: `https://github.com/ssh521/laravel-admin-ui/issues`
  - `source`: `https://github.com/ssh521/laravel-admin-ui`
- `authors`를 추가한다.
  - 이름은 `ssh521`
  - 역할은 `Developer`
  - 공개 이메일은 넣지 않는다.
- `license`는 현재 값 `MIT`를 유지한다.

## 2. 문서와 라이선스 정리

Packagist 사용자가 패키지 목적과 설치 방법을 바로 확인할 수 있도록 루트 문서를 정리한다.

- 루트에 `LICENSE` 파일을 추가하고 MIT 전문을 넣는다.
- `README.md`를 한국어 기준으로 정리한다.
- README에 다음 내용을 포함한다.
  - 패키지 역할: `ssh521/laravel-admin`의 재사용 가능한 Blade view, component, CSS, JavaScript, image asset 패키지
  - 설치 명령: `composer require ssh521/laravel-admin-ui`
  - publish tags
    - `laravel-admin-ui-assets`
    - `laravel-admin-ui-views`
    - `laravel-admin-ui-components`
    - `laravel-admin-ui-maintenance-view`
  - publish 경로
    - `resources/vendor/laravel-admin/admin.css`
    - `resources/vendor/laravel-admin/admin.js`
    - `resources/views/vendor/laravel-admin`
    - `resources/views/errors/503.blade.php`
    - `public/images/dtree`
  - Vite 입력
    - `resources/vendor/laravel-admin/admin.css`
    - `resources/vendor/laravel-admin/admin.js`
  - 패키지 책임 범위
    - 이 패키지는 UI resource layer를 담당한다.
    - 인증, 라우트, 정책, 모델, 명령, 시더, 통합 서비스는 `ssh521/laravel-admin`이 담당한다.
  - 디자인 문서 링크
    - `docs/admin-design-rules.md`
    - `docs/admin-ui-design-contract.md`

## 3. 유지할 공개 인터페이스

Packagist 공개 준비 중에도 기존 사용자가 의존하는 인터페이스는 변경하지 않는다.

- 서비스 프로바이더: `Ssh521\LaravelAdminUi\LaravelAdminUiServiceProvider`
- view namespace: `laravel-admin::`
- anonymous component namespace: `laravel-admin::`
- publish tags
  - `laravel-admin-ui-assets`
  - `laravel-admin-ui-views`
  - `laravel-admin-ui-components`
  - `laravel-admin-ui-maintenance-view`

## 4. 검증 절차

공개 전 아래 명령을 실행한다.

```bash
composer install
composer validate --strict
composer test
git diff --check
```

로컬 `vendor/bin/phpunit`이 없으면 `composer install` 후 다시 실행한다.
그래도 PHPUnit 실행이 불가능하면 최소한 아래 문법 검사를 수행하고, 테스트 미실행 사유를 릴리스 메모에 남긴다.

```bash
php -l src/LaravelAdminUiServiceProvider.php
php -l tests/Feature/LaravelAdminUiServiceProviderTest.php
```

공개 직전 Git 상태도 확인한다.

```bash
git status --short --branch
git remote -v
git tag --list --sort=-version:refname | head -20
```

## 5. 커밋과 태그

메타데이터와 문서 정리가 끝나면 변경 사항을 커밋한다.

```bash
git add composer.json README.md LICENSE docs/packagist-publication.md
git commit -m "Prepare laravel-admin-ui for Packagist publication"
git push origin main
```

첫 공개 태그는 `v1.0.0`으로 생성한다.

```bash
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0
```

## 6. Packagist 등록

Packagist에 로그인한 뒤 Submit 화면에서 저장소 URL을 등록한다.

```text
https://github.com/ssh521/laravel-admin-ui.git
```

등록 후 패키지 페이지에서 `v1.0.0`이 수집되었는지 확인한다.
GitHub 연동 계정이면 Packagist GitHub hook 자동 설정 여부를 확인한다.
자동 연동이 안 되면 Packagist 안내에 따라 GitHub webhook을 수동 설정한다.

## 7. 공개 후 설치 검증

path repository 설정이 없는 환경에서 Packagist 설치를 검증한다.

```bash
composer require ssh521/laravel-admin-ui:^1.0
```

설치 후 다음을 확인한다.

- Laravel package discovery가 서비스 프로바이더를 자동 등록하는지 확인한다.
- `laravel-admin::` view namespace가 동작하는지 확인한다.
- publish tag가 정상 노출되는지 확인한다.
- `laravel-admin-ui-assets` 퍼블리시 후 Vite 입력 경로가 존재하는지 확인한다.

## 현재 확인된 상태

- 현재 브랜치는 `main...origin/main`이다.
- 현재 작업트리는 깨끗한 상태에서 문서 작성이 시작되었다.
- 현재 `composer validate --strict`는 유효하지만 `version` 필드 경고가 있다.
- 현재 로컬 `vendor/bin/phpunit`은 없다.
- 첫 공개 버전은 현재 패키지 의도에 맞춰 `v1.0.0`으로 태그한다.
