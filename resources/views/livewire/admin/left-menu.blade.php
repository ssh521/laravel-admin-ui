{{-- resources/views/livewire/admin/left-menu.blade.php - dTree 스타일 (Classic ASP 형식) --}}

@php
    $dtreeImg = fn ($name) => asset('images/dtree/' . $name);
@endphp

<div class="dtree">
    <div class="p-2">
        {{-- Root: 사이트명 --}}
        <div class="dTreeNode flex items-center cursor-pointer select-none"
            @click="if (! $event.target.closest('a')) window.location.href = @js(route('admin.index'))">
            <img src="{{ $dtreeImg('base.gif') }}" alt="" class="dtree-img flex-shrink-0" />
            <a href="{{ route('admin.index') }}" class="node {{ request()->routeIs('admin.index') ? 'nodeSel' : '' }} ml-0.5" title="{{ config('app.name') }}">
                {{ config('app.name') }}
            </a>
        </div>
        @if($sidebarMenuCategories && $sidebarMenuCategories->count() > 0)
            @foreach($sidebarMenuCategories as $catIndex => $category)
                @php
                    $menus = $category->activeMenus;
                    $hasChildren = $menus->count() > 0;
                    $isLastCategory = $catIndex === $sidebarMenuCategories->count() - 1;
                @endphp
                <div class="dtree-node" x-data="window.dtreeNode('category-{{ $category->id }}')"
                    data-node-id="category-{{ $category->id }}">
                    {{-- 폴더 노드 (카테고리) --}}
                    <div class="dTreeNode flex items-center {{ $hasChildren ? 'cursor-pointer select-none' : '' }}"
                        @if($hasChildren) @click="toggleNode()" @endif>
                        <span class="dtree-indent flex items-center">
                            @if($hasChildren)
                                <a href="javascript:void(0)" class="dtree-toggle inline-flex items-center justify-center">
                                    <span x-show="!isOpen" class="dtree-toggle-control" aria-hidden="true">
                                        <x-laravel-admin::admin.icon name="chevron-right" class="size-3.5" />
                                    </span>
                                    <span x-show="isOpen" x-cloak class="dtree-toggle-control" aria-hidden="true">
                                        <x-laravel-admin::admin.icon name="chevron-down" class="size-3.5" />
                                    </span>
                                </a>
                            @else
                                <img src="{{ $dtreeImg($isLastCategory ? 'joinbottom.gif' : 'join.gif') }}" alt="" class="dtree-img" />
                            @endif
                        </span>
                        @if($hasChildren)
                            <span x-show="!isOpen" class="dtree-folder-icon" aria-hidden="true"></span>
                            <span x-show="isOpen" x-cloak class="dtree-folder-icon dtree-folder-icon-open" aria-hidden="true"></span>
                        @else
                            <span class="dtree-folder-icon" aria-hidden="true"></span>
                        @endif
                        <span class="dtree-text ml-1">{{ $category->name }}</span>
                    </div>
                    {{-- 하위 메뉴 --}}
                    @if($hasChildren)
                    <div x-show="isOpen" x-cloak x-collapse class="dtree-children clip">
                        @foreach($menus as $menuIndex => $menu)
                            @php
                                $isLastMenu = $menuIndex === $menus->count() - 1;
                            @endphp
                            <div class="dTreeNode flex items-center cursor-pointer select-none"
                                @click="if (! $event.target.closest('a')) { const link = $el.querySelector('a.node'); if (link?.target === '_blank') { window.open(link.href, '_blank', 'noopener'); } else if (link) { window.location.href = link.href; } }">
                                <span class="dtree-indent flex items-center flex-shrink-0 ml-[0.1rem]">
                                    <img src="{{ $dtreeImg('empty.gif') }}" alt="" class="dtree-img" />
                                    <img src="{{ $dtreeImg($isLastMenu ? 'joinbottom.gif' : 'join.gif') }}" alt="" class="dtree-img" />
                                </span>
                                <x-laravel-admin::admin.icon :name="$menu->icon ?: 'file-lines'" class="dtree-menu-icon dtree-menu-icon-page" />
                                @if($menu->target === '_blank')
                                    <a href="{{ $menu->url }}" target="_blank" title="{{ $menu->name }}"
                                        class="node ml-1 {{ $menu->isCurrentPage() ? 'nodeSel' : '' }}">
                                        {{ $menu->name }}
                                    </a>
                                    <img src="{{ $dtreeImg('globe.gif') }}" alt="" class="w-3 h-3 ml-1 opacity-60 flex-shrink-0" />
                                @else
                                    <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" title="{{ $menu->name }}"
                                        class="node ml-1 {{ $menu->isCurrentPage() ? 'nodeSel' : '' }}">
                                        {{ $menu->name }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="flex items-center justify-center px-4 py-4 text-gray-500 text-sm">
                등록된 메뉴가 없습니다.
            </div>
        @endif
    </div>
</div>
