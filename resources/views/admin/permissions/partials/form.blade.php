@php
    $permission = $permission ?? null;
    $showActions = $showActions ?? true;
    $submitLabel = $submitLabel ?? __('저장하기');
    $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
@endphp

<div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ $permission ? __('역할에 연결할 수 있는 권한 식별자를 관리합니다.') : __('역할에 연결할 수 있는 권한 식별자를 입력합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <label for="name" class="{{ $labelClass }}">{{ __('Permission Name') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="name" name="name" value="{{ old('name', $permission?->name) }}" autocomplete="name" placeholder="{{ __('Enter permission name') }}" />
                </div>
                @if ($errors->has('name'))
                    <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="['Please enter a permission name!']" />
                @endif
            </div>

            <div class="sm:col-span-5">
                <label for="description" class="{{ $labelClass }}">{{ __('Description') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-textarea id="description" name="description" rows="4" placeholder="{{ __('Enter permission description') }}">{{ old('description', $permission->description ?? '') }}</x-laravel-admin::admin.form-textarea>
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('description')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.permissions.index')">
                {{ __('목록보기') }}
            </x-laravel-admin::admin.action-button>
            <x-laravel-admin::admin.action-button type="submit">
                {{ $submitLabel }}
            </x-laravel-admin::admin.action-button>
        </div>
    @endif
</div>
