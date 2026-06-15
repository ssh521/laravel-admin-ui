<x-laravel-admin::admin.layouts.admin title="부모창-자식창 데이터 전달 테스트">
    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">부모창-자식창 데이터 전달 테스트</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    사용자 검색 모달에서 선택한 값을 부모 폼으로 전달합니다.
                </p>
            </div>

            <div x-data="userForm()" class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <h2 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">사용자 정보 입력</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">ID, 이름, 이메일을 입력하거나 검색 모달에서 사용자를 선택합니다.</p>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-3">
                        <div>
                            <label for="user_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">사용자 ID</label>
                            <div class="mt-2">
                                <input type="text"
                                       id="user_id"
                                       name="user_id"
                                       placeholder="ID"
                                       x-model="formUserId"
                                       class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label for="user_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이름</label>
                            <div class="mt-2">
                                <input type="text"
                                       id="user_name"
                                       name="user_name"
                                       placeholder="이름"
                                       x-model="formUserName"
                                       class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label for="user_email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">이메일</label>
                            <div class="mt-2">
                                <input type="email"
                                       id="user_email"
                                       name="user_email"
                                       placeholder="이메일"
                                       x-model="formUserEmail"
                                       class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button type="button"
                                @click="openUserSearchModal()"
                                class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            사용자 검색
                        </button>

                        <button type="button"
                                @click="clearForm()"
                                class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                            폼 초기화
                        </button>
                    </div>

                    <div x-show="selectedUser" x-cloak class="mt-6 rounded-md border border-green-200 bg-green-50 p-4 dark:border-green-500/30 dark:bg-green-500/10">
                        <h3 class="text-sm font-medium text-green-800 dark:text-green-300">선택된 사용자 정보</h3>
                        <p class="mt-2 text-sm text-green-700 dark:text-green-200" x-text="selectedUser ? `ID: ${selectedUser.userId}, 이름: ${selectedUser.userName}, 이메일: ${selectedUser.userEmail}` : ''"></p>
                    </div>
                </div>
            </div>

            <x-laravel-admin::admin.draggable-modal
                id="user-search-modal"
                title="사용자 검색"
                width="800"
                height="550">
                <livewire:admin.users.user-search-modal
                    :modal-id="'user-search-modal'"
                />
            </x-laravel-admin::admin.draggable-modal>
        </div>
    </div>

    <script>
        function userForm() {
            return {
                selectedUser: null,
                formUserId: '',
                formUserName: '',
                formUserEmail: '',

                openUserSearchModal() {
                    Livewire.dispatch('admin-users:user-search-modal:prefill', { userId: this.formUserId || '', userName: this.formUserName || '', userEmail: this.formUserEmail || '' });

                    this.$dispatch('open-modal', { modalId: 'user-search-modal' });
                },

                init() {
                    window.addEventListener('user-selected', (event) => {
                        this.fillUser(event.detail);
                    });
                },

                fillUser(data) {
                    this.formUserId = data.userId;
                    this.formUserName = data.userName;
                    this.formUserEmail = data.userEmail;
                    this.selectedUser = data;

                    this.$dispatch('close-modal', { modalId: 'user-search-modal' });
                },

                clearForm() {
                    this.formUserId = '';
                    this.formUserName = '';
                    this.formUserEmail = '';
                    this.selectedUser = null;
                }
            }
        }
    </script>
</x-laravel-admin::admin.layouts.admin>
