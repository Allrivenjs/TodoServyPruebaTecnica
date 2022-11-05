import { defineStore } from 'pinia';
import {axiosInstance} from "@/helpers";

const baseUrl = `/businesses`;

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
                this.businesses = (await axiosInstance.get(baseUrl)).data.data;
            } catch (error) {
                this.businesses = { error };
            }
        },
        async getById(id) {
            this.business = { loading: true };
            try {
                this.business = (await axiosInstance.get(`${baseUrl}/${id}`)).data.data;
            } catch (error) {
                this.business = { error };
            }
        },
        async store(params, config) {
            await axiosInstance.post(`${baseUrl}`, params, {
                headers: {
                    ...config,
                }
            });
        },

        async updateImage(id, params, config) {
            await axiosInstance.post(`${baseUrl}/${id}`, params, {
                headers: {
                    ...config,
                }
            });
        },
        async update(id, params, config) {
            await axiosInstance.post(`${baseUrl}/${id}`, params, {
                headers: {
                    ...config,
                }
            });
        },
        async delete(id) {
            await axiosInstance.delete(`${baseUrl}/${id}`);
            this.businesses = this.businesses.filter(x => x.id !== id);
        }
    }
});