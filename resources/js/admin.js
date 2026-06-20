import draggableModal, { draggableModalAlert } from './modal-manager';
import './dtree';

// Alpine.js 컴포넌트들
document.addEventListener('alpine:init', () => {
    
    // 다중 모달을 지원하는 드래그 가능한 모달 컴포넌트
    Alpine.data('draggableModal', draggableModal);
    // Alert 전용 모달 컴포넌트 등록
    Alpine.data('draggableModalAlert', draggableModalAlert);
   
    // 토글 가능한 드롭다운 컴포넌트
    Alpine.data('dropdown', () => ({
        isOpen: false,
        closeOnClickOutsideHandler: null,
        
        toggle() {
            this.isOpen = !this.isOpen;
        },
        
        close() {
            this.isOpen = false;
        },
        
        init() {
            this.closeOnClickOutsideHandler = this.closeOnClickOutside.bind(this);

            // 외부 클릭 시 닫기
            this.$watch('isOpen', (value) => {
                if (value) {
                    this.$nextTick(() => {
                        document.addEventListener('click', this.closeOnClickOutsideHandler);
                    });
                } else {
                    document.removeEventListener('click', this.closeOnClickOutsideHandler);
                }
            });
        },

        destroy() {
            document.removeEventListener('click', this.closeOnClickOutsideHandler);
        },
        
        closeOnClickOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.close();
            }
        }
    }));

    // 탭 컴포넌트
    Alpine.data('tabs', (defaultTab = null) => ({
        activeTab: defaultTab,
        
        setTab(tabName) {
            this.activeTab = tabName;
        },
        
        isActive(tabName) {
            return this.activeTab === tabName;
        }
    }));

});
