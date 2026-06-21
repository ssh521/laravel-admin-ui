@php
    $menuCategory = $menuCategory ?? null;
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
                {{ $menuCategory ? __('메뉴를 묶는 카테고리 이름과 표시 순서를 관리합니다.') : __('메뉴를 묶는 카테고리 이름과 표시 순서를 입력합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <label for="name" class="{{ $labelClass }}">{{ __('카테고리명') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="name" name="name" value="{{ old('name', $menuCategory?->name) }}" autocomplete="name" placeholder="Enter category name" required />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('name')" />
            </div>

            <div class="sm:col-span-2">
                <label for="sort_order" class="{{ $labelClass }}">{{ __('정렬 순서') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', $menuCategory->sort_order ?? 0) }}" min="0" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('sort_order')" />
            </div>

            <div class="sm:col-span-5">
                <x-laravel-admin::admin.checkbox-row for="is_active" title="{{ __('활성화') }}" description="{{ __('체크하면 메뉴 카테고리가 활성 상태로 표시됩니다.') }}">
                    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $menuCategory->is_active ?? true)) class="mt-0.5 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                </x-laravel-admin::admin.checkbox-row>
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <a href="{{ route('admin.menu-categories.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                {{ __('목록보기') }}
            </a>
            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                {{ $submitLabel }}
            </button>
        </div>
    @endif
</div>
