import { defineStore } from 'pinia';

import { fetchWrapper } from '@/helpers';


const baseUrl = `${import.meta.env.VITE_API_URL}/businesses`;

export const useBusinessesStore = defineStore({
    id: 'businesses',
    state: () => ({
        businesses: {},
        business: {}
    }),
    actions: {
        async getAll() {
            this.businesses = { loading: true };
            try {
                this.businesses = await fetchWrapper.get(baseUrl);
            } catch (error) {
                this.businesses = { error };
            }
        },
        async getById(id) {
            this.business = { loading: true };
            try {
                this.business = await fetchWrapper.get(`${baseUrl}/${id}`);
            } catch (error) {
                this.business = { error };
            }
        },
        async store(params) {
            await fetchWrapper.post(`${baseUrl}`, params);
        },
        async update(id, params) {
            await fetchWrapper.put(`${baseUrl}/${id}`, params);
        },
        async delete(id) {
            this.businesses.find(x => x.id === id).isDeleting = true;
            await fetchWrapper.delete(`${baseUrl}/${id}`);
            this.business = this.business.filter(x => x.id !== id);
        }
    }
});