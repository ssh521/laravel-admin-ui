<x-laravel-admin::admin.layouts.admin title="메뉴 등록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menus.index') }}">메뉴 관리</a>
            </x-slot>
            <x-slot name="description">{{ __('Create New Menu') }}</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $inputClass = 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
        $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
    @endphp

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('Menu Information') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('새 메뉴의 기본 정보, 연결 경로, 표시 상태를 설정합니다.') }}
                </p>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf

                <div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

                    <div class="md:col-span-4">
                        <div class="flex flex-col">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                {{ __('메뉴명과 분류, 상위 메뉴를 지정합니다.') }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-8">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="name" class="{{ $labelClass }}">{{ __('메뉴명') }}</label>
                                <div class="mt-2">
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" placeholder="Enter menu name" required class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('name')" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="category_id" class="{{ $labelClass }}">{{ __('카테고리') }}</label>
                                <div class="mt-2">
                                    <select id="category_id" name="category_id" class="{{ $inputClass }}">
                                        <option value="">{{ __('선택하세요') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('category_id')" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="parent_id" class="{{ $labelClass }}">{{ __('상위 메뉴') }}</label>
                                <div class="mt-2">
                                    <select id="parent_id" name="parent_id" class="{{ $inputClass }}">
                                        <option value="">{{ __('선택하세요') }}</option>
                                        @foreach($parentMenus as $parentMenu)
                                            <option value="{{ $parentMenu->id }}" @selected(old('parent_id') == $parentMenu->id)>{{ $parentMenu->name }}</option>
                                        @endforeach
                                    </select>
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
                                {{ __('라우트명 또는 직접 URL을 입력하고 링크 대상 창을 선택합니다.') }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-8">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="route_name" class="{{ $labelClass }}">{{ __('Route Name') }}</label>
                                <div class="mt-2">
                                    <input id="route_name" name="route_name" type="text" value="{{ old('route_name') }}" placeholder="예: users.index" class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('route_name')" />
                            </div>

                            <div class="sm:col-span-4">
                                <label for="route_parameters" class="{{ $labelClass }}">{{ __('Route Params') }}</label>
                                <div class="mt-2">
                                    <input id="route_parameters" name="route_parameters" type="text" value="{{ old('route_parameters') }}" placeholder='예: {"id": 1}' class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('route_parameters')" />
                            </div>

                            <div class="sm:col-span-4">
                                <label for="url" class="{{ $labelClass }}">{{ __('Direct URL') }}</label>
                                <div class="mt-2">
                                    <input id="url" name="url" type="text" value="{{ old('url') }}" placeholder="예: /admin/users" class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('url')" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="target" class="{{ $labelClass }}">{{ __('Target') }}</label>
                                <div class="mt-2">
                                    <select id="target" name="target" class="{{ $inputClass }}">
                                        <option value="">{{ __('선택하세요') }}</option>
                                        <option value="_self" @selected(old('target') == '_self')>{{ __('현재 창') }}</option>
                                        <option value="_blank" @selected(old('target') == '_blank')>{{ __('새 창') }}</option>
                                        <option value="_parent" @selected(old('target') == '_parent')>{{ __('부모 창') }}</option>
                                        <option value="_top" @selected(old('target') == '_top')>{{ __('최상위 창') }}</option>
                                    </select>
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
                                    <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', 0) }}" min="0" class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="icon" class="{{ $labelClass }}">{{ __('Icon') }}</label>
                                <div class="mt-2">
                                    <input id="icon" name="icon" type="text" value="{{ old('icon') }}" placeholder="fas fa-home" class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('icon')" />
                            </div>

                            <div class="sm:col-span-5">
                                <label for="is_active" class="flex min-h-12 cursor-pointer items-start gap-3 rounded-md border border-gray-200 bg-white p-4 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-800">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', true)) class="mt-0.5 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                                    <span>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('활성화') }}</span>
                                        <span class="block text-sm text-gray-500 dark:text-gray-400">{{ __('체크하면 관리자 메뉴에 노출됩니다.') }}</span>
                                    </span>
                                </label>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="description" class="{{ $labelClass }}">{{ __('설명') }}</label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="4" class="{{ $inputClass }}">{{ old('description') }}</textarea>
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('description')" />
                            </div>
                        </div>
                    </div>

                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

                    <div class="col-span-full mt-6 flex items-center justify-end gap-x-3">
                        <a href="{{ route('admin.menus.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            {{ __('목록보기') }}
                        </a>
                        <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            {{ __('등록하기') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
