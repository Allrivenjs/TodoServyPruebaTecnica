import { defineStore } from 'pinia';

import { axiosInstance } from '@/helpers';
import router from '@/router';
import { useAlertStore } from '@/stores';

const baseUrl = `${import.meta.env.VITE_API_URL}`;

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        // initialize state from local storage to enable user to stay logged in
        user: JSON.parse(localStorage.getItem('user')),
        returnUrl: null
    }),
    actions: {
        async login(email, password) {
            try {
                const user = (await axiosInstance.post(`${baseUrl}/login`, JSON.stringify({email, password}), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })).data;
                // update pinia state
                this.user = user;
                console.log(this.user);
                // store user details and jwt in local storage to keep user logged in between page refreshes
                localStorage.setItem('user', JSON.stringify(user));
                // redirect to previous url or default to home page
                await router.push(this.returnUrl || '/');
            } catch (error) {
                const alertStore = useAlertStore();
                alertStore.error(error);
            }
        },
       async logout() {
            this.user = null;
            localStorage.removeItem('user');
            await router.push('/login');
        }
    }
});