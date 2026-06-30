import modalStackModal from './modal-stack';
import './dtree';

// Alpine.js 컴포넌트들
document.addEventListener('alpine:init', () => {
    
    Alpine.data('modalStackModal', modalStackModal);
   
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
