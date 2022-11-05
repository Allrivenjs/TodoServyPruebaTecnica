import { defineStore } from 'pinia';

export const useModalStore = defineStore({
    id: 'modal',
    state: () => ({
        openModal: false,
        data: null,
    }),
    actions: {
        change(data = null) {
            this.data = data;
            this.openModal = !this.openModal;
        }
    }
});