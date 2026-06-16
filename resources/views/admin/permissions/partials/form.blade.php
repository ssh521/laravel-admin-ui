@php
    $permission = $permission ?? null;
    $showActions = $showActions ?? true;
    $submitLabel = $submitLabel ?? __('저장하기');
    $inputClass = 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
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
                    <input id="name" name="name" type="text" value="{{ old('name', $permission?->name) }}" autocomplete="name" placeholder="{{ __('Enter permission name') }}" class="{{ $inputClass }}">
                </div>
                @if ($errors->has('name'))
                    <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="['Please enter a permission name!']" />
                @endif
            </div>

            <div class="sm:col-span-5">
                <label for="description" class="{{ $labelClass }}">{{ __('Description') }}</label>
                <div class="mt-2">
                    <textarea id="description" name="description" rows="4" placeholder="{{ __('Enter permission description') }}" class="{{ $inputClass }}">{{ old('description', $permission->description ?? '') }}</textarea>
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('description')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <a href="{{ route('admin.permissions.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                {{ __('목록보기') }}
            </a>
            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                {{ $submitLabel }}
            </button>
        </div>
    @endif
</div>
