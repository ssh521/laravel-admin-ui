@php
    $menu = $menu ?? null;
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
                {{ $menu ? __('메뉴명과 분류, 상위 메뉴를 관리합니다.') : __('메뉴명과 분류, 상위 메뉴를 지정합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <label for="name" class="{{ $labelClass }}">{{ __('메뉴명') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="name" name="name" value="{{ old('name', $menu?->name) }}" autocomplete="name" placeholder="Enter menu name" required />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('name')" />
            </div>

            <div class="sm:col-span-3">
                <label for="category_id" class="{{ $labelClass }}">{{ __('카테고리') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-select id="category_id" name="category_id">
                        <option value="">{{ __('선택하세요') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $menu?->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('category_id')" />
            </div>

            <div class="sm:col-span-3">
                <label for="parent_id" class="{{ $labelClass }}">{{ __('상위 메뉴') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-select id="parent_id" name="parent_id">
                        <option value="">{{ __('선택하세요') }}</option>
                        @foreach($parentMenus as $parentMenu)
                            <option value="{{ $parentMenu->id }}" @selected(old('parent_id', $menu?->parent_id) == $parentMenu->id)>{{ $parentMenu->name }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('parent_id')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('연결 정보') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ $menu ? __('라우트명 또는 직접 URL과 링크 대상 창을 관리합니다.') : __('라우트명 또는 직접 URL을 입력하고 링크 대상 창을 선택합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <label for="route_name" class="{{ $labelClass }}">{{ __('Route Name') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="route_name" name="route_name" value="{{ old('route_name', $menu?->route_name) }}" placeholder="예: users.index" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('route_name')" />
            </div>

            <div class="sm:col-span-4">
                <label for="route_parameters" class="{{ $labelClass }}">{{ __('Route Params') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="route_parameters" name="route_parameters" value="{{ old('route_parameters', $menu?->route_parameters) }}" placeholder='예: {"id": 1}' />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('route_parameters')" />
            </div>

            <div class="sm:col-span-4">
                <label for="url" class="{{ $labelClass }}">{{ __('Direct URL') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="url" name="url" value="{{ old('url', $menu?->getRawUrlAttribute()) }}" placeholder="예: /admin/users" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('url')" />
            </div>

            <div class="sm:col-span-3">
                <label for="target" class="{{ $labelClass }}">{{ __('Target') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-select id="target" name="target">
                        <option value="">{{ __('선택하세요') }}</option>
                        <option value="_self" @selected(old('target', $menu?->target) == '_self')>{{ __('현재 창') }}</option>
                        <option value="_blank" @selected(old('target', $menu?->target) == '_blank')>{{ __('새 창') }}</option>
                        <option value="_parent" @selected(old('target', $menu?->target) == '_parent')>{{ __('부모 창') }}</option>
                        <option value="_top" @selected(old('target', $menu?->target) == '_top')>{{ __('최상위 창') }}</option>
                    </x-laravel-admin::admin.form-select>
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('target')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('표시 설정') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ __('정렬 순서, 아이콘, 활성 상태와 설명을 관리합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <label for="sort_order" class="{{ $labelClass }}">{{ __('정렬 순서') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', $menu->sort_order ?? 0) }}" min="0" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('sort_order')" />
            </div>

            <div class="sm:col-span-3">
                <label for="icon" class="{{ $labelClass }}">{{ __('Icon') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="icon" name="icon" value="{{ old('icon', $menu?->icon) }}" placeholder="house" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('icon')" />
            </div>

            <div class="sm:col-span-5">
                <x-laravel-admin::admin.checkbox-row for="is_active" title="{{ __('활성화') }}" description="{{ __('체크하면 관리자 메뉴에 노출됩니다.') }}">
                    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $menu->is_active ?? true)) class="mt-0.5 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                </x-laravel-admin::admin.checkbox-row>
            </div>

            <div class="sm:col-span-6">
                <label for="description" class="{{ $labelClass }}">{{ __('설명') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-textarea id="description" name="description" rows="4">{{ old('description', $menu?->description) }}</x-laravel-admin::admin.form-textarea>
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('description')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <a href="{{ route('admin.menus.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                {{ __('목록보기') }}
            </a>
            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                {{ $submitLabel }}
            </button>
        </div>
    @endif
</div>
