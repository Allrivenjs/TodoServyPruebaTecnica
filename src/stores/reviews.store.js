import { defineStore } from 'pinia';
import {axiosInstance} from "@/helpers";

const baseUrl = `/reviews`;

export const useReviewsStore = defineStore({
    id: 'reviews',
    state: () => ({
        reviews: {},
        review: {}
    }),
    actions: {
        async getAll(id) {
            this.reviews = { loading: true };
            try {
                this.reviews = (await axiosInstance.get(`${baseUrl}/${id}`)).data;
            } catch (error) {
                this.reviews = { error };
            }
        },
        async getById(id) {
            this.review = { loading: true };
            try {
                this.review = (await axiosInstance.get(`${baseUrl}/${id}`)).data;
            } catch (error) {
                this.review = { error };
            }
        },
        async store(params, config) {
            await axiosInstance.post(`${baseUrl}`, params, {
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
            this.reviews = this.reviews.filter(x => x.id !== id);
        }
    }
});