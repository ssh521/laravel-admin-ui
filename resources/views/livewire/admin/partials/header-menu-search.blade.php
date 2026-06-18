<div class="w-full flex" data-admin-menu-search data-search-url="{{ route(config('laravel-admin.route_name_prefix', 'admin.').'menus.search', [], false) }}">
    <div class="flex w-full justify-center relative">
        <div class="hidden w-full max-w-sm sm:block lg:max-w-md relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center text-gray-400 dark:text-gray-500">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z" />
                </svg>
            </div>
            <input
                type="search"
                autocomplete="off"
                data-search-input
                class="h-9 w-full rounded-md border border-gray-300 bg-white pl-10 pr-16 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                placeholder="메뉴 검색"
            >
            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                <kbd class="rounded border border-gray-200 bg-gray-50 px-1 py-0.5 text-[10px] font-medium text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">⌘K</kbd>
            </div>
            <div data-search-panel class="hidden absolute top-full left-0 right-0 z-50 mt-2 max-h-96 overflow-y-auto rounded-md border border-gray-200 bg-white shadow-xl ring-1 ring-black/5 dark:border-gray-700 dark:bg-gray-900"></div>
        </div>
    </div>

    <div class="w-full sm:hidden flex justify-end">
        <button type="button" data-mobile-search-open class="rounded-md p-2 text-gray-700 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">
            <span class="sr-only">메뉴 검색 열기</span>
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z" />
            </svg>
        </button>
    </div>

    <div data-mobile-search-overlay class="hidden fixed inset-0 z-50 flex items-start justify-center bg-gray-900/40 px-4 sm:hidden">
        <div class="mt-20 w-full max-w-md rounded-lg border border-gray-200 bg-white p-4 shadow-xl dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">메뉴 검색</h2>
                <button type="button" data-mobile-search-close class="rounded-md p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                    <span class="sr-only">메뉴 검색 닫기</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center text-gray-400 dark:text-gray-500">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z" />
                    </svg>
                </div>
                <input
                    type="search"
                    autocomplete="off"
                    data-search-input
                    data-mobile-search-input
                    class="h-10 w-full rounded-md border border-gray-300 bg-white pl-10 pr-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                    placeholder="메뉴 검색"
                >
            </div>
            <div data-search-panel class="hidden mt-3 max-h-96 overflow-y-auto rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900"></div>
        </div>
    </div>
</div>

@once
    <script>
        (() => {
            const loadingMarkup = `
                <div class="flex items-center justify-center gap-2 px-4 py-5 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>검색 중...</span>
                </div>
            `;

            const emptyMarkup = `
                <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    <div class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z" />
                        </svg>
                    </div>
                    <span>검색 결과가 없습니다.</span>
                </div>
            `;

            const arrowMarkup = `
                <svg class="h-4 w-4 flex-none text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            `;

            const iconPaths = {
                'arrow-down': 'M12 5v14m0 0 7-7m-7 7-7-7',
                'arrow-left': 'M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18',
                'arrow-up': 'M12 19V5m0 0-7 7m7-7 7 7',
                'arrow-up-wide-short': 'M3 7h18M6 12h12M10 17h4M3 17l3 3 3-3M6 20V4',
                bars: 'M3 6h18M3 12h18M3 18h18',
                'circle-exclamation': 'M12 9v4m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z',
                eye: 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178ZM15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
                'file-lines': 'M19.5 14.25v-7.5L14.25 1.5H6A1.5 1.5 0 0 0 4.5 3v18A1.5 1.5 0 0 0 6 22.5h12A1.5 1.5 0 0 0 19.5 21v-3.75M14.25 1.5v5.25H19.5M8.25 12h7.5M8.25 15h7.5M8.25 18h4.5',
                folder: 'M3 7.5A1.5 1.5 0 0 1 4.5 6h5.25l2.25 2.25h7.5A1.5 1.5 0 0 1 21 9.75V18a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V7.5Z',
                'folder-open': 'M3 7.5A1.5 1.5 0 0 1 4.5 6h5.25l2.25 2.25h7.5A1.5 1.5 0 0 1 21 9.75v1.5M3 7.5v10.125A2.625 2.625 0 0 0 5.625 20.25h11.409a2.625 2.625 0 0 0 2.56-2.036l1.14-4.95A1.5 1.5 0 0 0 19.272 11.25H7.128a1.5 1.5 0 0 0-1.462 1.164L3.36 22.5',
                gauge: 'M3.75 13.5a8.25 8.25 0 1 1 16.5 0M12 13.5l3.75-3.75M6.75 13.5h.01M17.25 13.5h.01M8.25 8.25h.01M15.75 8.25h.01M12 6.75h.01',
                'grip-lines': 'M4 9h16M4 15h16',
                'grip-vertical': 'M9 5h.01M9 12h.01M9 19h.01M15 5h.01M15 12h.01M15 19h.01',
                house: 'm3 10.5 9-7.5 9 7.5M5.25 9.75V21h13.5V9.75M9.75 21v-6h4.5v6',
                key: 'M15.75 7.5a5.25 5.25 0 1 1-1.463 3.645L6 19.432V21H3v-3h3v-3h3v-1.568l2.355-2.355A5.229 5.229 0 0 1 15.75 7.5ZM17.25 6.75h.008v.008h-.008V6.75Z',
                list: 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01',
                lock: 'M16.5 10.5V7.5a4.5 4.5 0 0 0-9 0v3M6.75 10.5h10.5A1.5 1.5 0 0 1 18.75 12v8.25a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z',
                'magnifying-glass': 'm21 21-5.197-5.197M15.803 15.803A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z',
                'pen-to-square': 'm16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487ZM19.5 7.125 16.875 4.5M18 14.25V19.5A1.5 1.5 0 0 1 16.5 21h-12A1.5 1.5 0 0 1 3 19.5v-12A1.5 1.5 0 0 1 4.5 6H9.75',
                plus: 'M12 4.5v15m7.5-7.5h-15',
                'right-to-bracket': 'M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 15l3-3m0 0-3-3m3 3H3',
                sort: 'M8 7l4-4 4 4M16 17l-4 4-4-4',
                tags: 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l8.182 8.182a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.659A2.25 2.25 0 0 0 9.568 3ZM6.75 6.75h.008v.008H6.75V6.75Z',
                'trash-can': 'm14.74 9-.346 9m-4.788 0L9.26 9M4.5 6.75h15M9.75 6.75V4.5A1.5 1.5 0 0 1 11.25 3h1.5a1.5 1.5 0 0 1 1.5 1.5v2.25M6.75 6.75l.75 14.25A1.5 1.5 0 0 0 9 22.5h6a1.5 1.5 0 0 0 1.5-1.5l.75-14.25',
                'user-shield': 'M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 10.5-6.87M18 13.5l3 1.125v2.25a5.25 5.25 0 0 1-3 4.75 5.25 5.25 0 0 1-3-4.75v-2.25L18 13.5Z',
                'user-tag': 'M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 10.5-6.87M16.5 15h3.568c.398 0 .779.158 1.06.44l1.432 1.432a1.5 1.5 0 0 1 0 2.121l-2.067 2.067a1.5 1.5 0 0 1-2.121 0l-1.432-1.432a1.5 1.5 0 0 1-.44-1.06V15Zm2.25 2.25h.01',
                xmark: 'M6 18 18 6M6 6l12 12',
            };

            const activeMenuSearches = new Map();

            function disposeMenuSearches() {
                activeMenuSearches.forEach(cleanup => cleanup());
                activeMenuSearches.clear();
            }

            function initMenuSearch(root) {
                if (activeMenuSearches.has(root)) {
                    return;
                }

                root.dataset.initialized = 'true';
                const controller = new AbortController();
                const listenerOptions = { signal: controller.signal };

                const searchUrl = root.dataset.searchUrl;
                const inputs = Array.from(root.querySelectorAll('[data-search-input]'));
                const panels = Array.from(root.querySelectorAll('[data-search-panel]'));
                const mobileOverlay = root.querySelector('[data-mobile-search-overlay]');
                const mobileInput = root.querySelector('[data-mobile-search-input]');
                const mobileOpenButton = root.querySelector('[data-mobile-search-open]');
                const mobileCloseButton = root.querySelector('[data-mobile-search-close]');

                const state = {
                    query: '',
                    results: [],
                    selectedIndex: -1,
                    isLoading: false,
                    hasSearched: false,
                    isVisible: false,
                    token: 0,
                    timer: null,
                };

                activeMenuSearches.set(root, () => {
                    clearTimeout(state.timer);
                    state.token += 1;
                    controller.abort();
                    delete root.dataset.initialized;
                });

                const setPanelVisibility = () => {
                    const shouldShow = state.isVisible && (
                        state.isLoading ||
                        state.results.length > 0 ||
                        (state.hasSearched && state.query.trim().length >= 2)
                    );

                    panels.forEach((panel) => panel.classList.toggle('hidden', !shouldShow));
                };

                const setInputValues = () => {
                    inputs.forEach((input) => {
                        if (input.value !== state.query) {
                            input.value = state.query;
                        }
                    });
                };

                const clearResults = () => {
                    state.results = [];
                    state.selectedIndex = -1;
                    state.isLoading = false;
                    state.hasSearched = false;
                    render();
                };

                const hideResults = () => {
                    state.isVisible = false;
                    setPanelVisibility();
                };

                const resetSearch = () => {
                    state.query = '';
                    state.isVisible = false;
                    setInputValues();
                    clearResults();
                };

                const visitResult = (result) => {
                    mobileOverlay?.classList.add('hidden');
                    resetSearch();

                    if (result.target === '_blank') {
                        window.open(result.url, '_blank');
                    } else {
                        window.location.href = result.url;
                    }
                };

                const makeText = (tagName, className, text) => {
                    const element = document.createElement(tagName);
                    element.className = className;
                    element.textContent = text || '';
                    return element;
                };

                const makeIcon = (name) => {
                    const path = iconPaths[name];

                    if (! path) {
                        return null;
                    }

                    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    svg.setAttribute('class', 'size-4 text-sm');
                    svg.setAttribute('viewBox', '0 0 24 24');
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('stroke', 'currentColor');
                    svg.setAttribute('stroke-width', '1.8');
                    svg.setAttribute('stroke-linecap', 'round');
                    svg.setAttribute('stroke-linejoin', 'round');
                    svg.setAttribute('aria-hidden', 'true');

                    const pathElement = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    pathElement.setAttribute('d', path);
                    svg.appendChild(pathElement);

                    return svg;
                };

                const makeResultItem = (result, index) => {
                    const item = document.createElement('a');
                    item.href = result.url || '#';
                    item.target = result.target || '_self';
                    item.dataset.searchResult = 'true';

                    if (index === state.selectedIndex) {
                        item.dataset.selected = 'true';
                    }

                    item.className = [
                        'block border-b border-gray-100 px-3 py-3 transition-colors last:border-b-0 dark:border-gray-800',
                        index === state.selectedIndex
                            ? 'bg-indigo-50 dark:bg-indigo-500/10'
                            : 'hover:bg-gray-50 dark:hover:bg-gray-800/80',
                    ].join(' ');

                    item.addEventListener('mousedown', (event) => event.preventDefault(), listenerOptions);
                    item.addEventListener('click', (event) => {
                        event.preventDefault();
                        visitResult(result);
                    }, listenerOptions);

                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-3';

                    const iconWrap = document.createElement('div');
                    iconWrap.className = 'flex-shrink-0';

                    const iconBox = document.createElement('div');
                    iconBox.className = 'flex h-9 w-9 items-center justify-center rounded-md bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20';

                    if (result.icon) {
                        const icon = makeIcon(result.icon);

                        if (icon) {
                            iconBox.appendChild(icon);
                        } else {
                            iconBox.innerHTML = arrowMarkup;
                        }
                    } else {
                        iconBox.innerHTML = arrowMarkup;
                    }

                    iconWrap.appendChild(iconBox);

                    const content = document.createElement('div');
                    content.className = 'min-w-0 flex-1';
                    content.appendChild(makeText('div', 'truncate text-sm font-medium text-gray-900 dark:text-white', result.name));

                    if (result.category) {
                        const badge = document.createElement('div');
                        badge.className = 'mt-1 inline-flex max-w-full items-center rounded-md bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700';
                        badge.appendChild(makeText('span', 'truncate', result.category));
                        content.appendChild(badge);
                    }

                    row.append(iconWrap, content);
                    const arrow = document.createElement('div');
                    arrow.innerHTML = arrowMarkup;
                    row.appendChild(arrow.firstElementChild);
                    item.appendChild(row);

                    return item;
                };

                const scrollSelectedItemIntoView = () => {
                    panels.forEach((panel) => {
                        if (panel.classList.contains('hidden')) {
                            return;
                        }

                        panel.querySelector('[data-selected="true"]')?.scrollIntoView({
                            block: 'nearest',
                            inline: 'nearest',
                        });
                    });
                };

                function render() {
                    setInputValues();

                    panels.forEach((panel) => {
                        panel.replaceChildren();

                        if (state.isLoading) {
                            panel.innerHTML = loadingMarkup;
                            return;
                        }

                        if (state.results.length > 0) {
                            state.results.forEach((result, index) => {
                                panel.appendChild(makeResultItem(result, index));
                            });
                            return;
                        }

                        if (state.hasSearched && state.query.trim().length >= 2) {
                            panel.innerHTML = emptyMarkup;
                        }
                    });

                    setPanelVisibility();
                    scrollSelectedItemIntoView();
                }

                const performSearch = async () => {
                    const query = state.query.trim();

                    if (query.length < 2) {
                        clearResults();
                        return;
                    }

                    const token = ++state.token;
                    state.isLoading = true;
                    state.hasSearched = false;
                    state.selectedIndex = -1;
                    state.isVisible = true;
                    render();

                    try {
                        const response = await fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
                            headers: {'Accept': 'application/json'},
                        });

                        if (!response.ok) {
                            throw new Error(`Search failed: ${response.status}`);
                        }

                        const data = await response.json();

                        if (token !== state.token || query !== state.query.trim()) {
                            return;
                        }

                        state.results = Array.isArray(data) ? data : [];
                        state.selectedIndex = state.results.length > 0 ? 0 : -1;
                        state.hasSearched = true;
                    } catch (error) {
                        console.error('메뉴 검색 오류:', error);
                        state.results = [];
                        state.selectedIndex = -1;
                        state.hasSearched = true;
                    } finally {
                        if (token === state.token) {
                            state.isLoading = false;
                            render();
                        }
                    }
                };

                const queueSearch = (value) => {
                    state.query = value;
                    state.isVisible = true;
                    clearTimeout(state.timer);

                    if (state.query.trim().length < 2) {
                        clearResults();
                        return;
                    }

                    state.timer = setTimeout(performSearch, 250);
                };

                const moveSelection = (direction) => {
                    if (state.results.length === 0) {
                        return;
                    }

                    state.selectedIndex = Math.max(
                        0,
                        Math.min(state.selectedIndex + direction, state.results.length - 1)
                    );
                    render();
                };

                const chooseSelected = () => {
                    if (state.selectedIndex < 0 || !state.results[state.selectedIndex]) {
                        return;
                    }

                    visitResult(state.results[state.selectedIndex]);
                };

                inputs.forEach((input) => {
                    input.addEventListener('input', () => queueSearch(input.value), listenerOptions);
                    input.addEventListener('focus', () => {
                        state.isVisible = true;

                        if (state.query.trim().length >= 2 && state.results.length === 0) {
                            performSearch();
                        } else {
                            render();
                        }
                    }, listenerOptions);
                    input.addEventListener('keydown', (event) => {
                        if (event.key === 'ArrowDown') {
                            event.preventDefault();
                            moveSelection(1);
                        } else if (event.key === 'ArrowUp') {
                            event.preventDefault();
                            moveSelection(-1);
                        } else if (event.key === 'Enter') {
                            event.preventDefault();
                            chooseSelected();
                        } else if (event.key === 'Escape') {
                            event.preventDefault();
                            resetSearch();
                        }
                    }, listenerOptions);
                });

                mobileOpenButton?.addEventListener('click', () => {
                    mobileOverlay?.classList.remove('hidden');
                    state.isVisible = true;
                    render();
                    window.requestAnimationFrame(() => mobileInput?.focus());
                }, listenerOptions);

                mobileCloseButton?.addEventListener('click', () => {
                    mobileOverlay?.classList.add('hidden');
                    hideResults();
                }, listenerOptions);

                mobileOverlay?.addEventListener('click', (event) => {
                    if (event.target === mobileOverlay) {
                        mobileOverlay.classList.add('hidden');
                        hideResults();
                    }
                }, listenerOptions);

                document.addEventListener('click', (event) => {
                    if (!root.contains(event.target)) {
                        hideResults();
                    }
                }, listenerOptions);

                document.addEventListener('keydown', (event) => {
                    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                        event.preventDefault();

                        if (window.innerWidth < 640) {
                            mobileOpenButton?.click();
                        } else {
                            inputs[0]?.focus();
                        }
                    }
                }, listenerOptions);
            }

            function initAllMenuSearches() {
                document.querySelectorAll('[data-admin-menu-search]').forEach(initMenuSearch);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAllMenuSearches);
            } else {
                initAllMenuSearches();
            }

            document.addEventListener('livewire:navigated', () => {
                disposeMenuSearches();
                initAllMenuSearches();
            });
        })();
    </script>
@endonce
