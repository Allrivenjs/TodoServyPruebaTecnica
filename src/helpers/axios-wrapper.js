import { useAuthStore } from '@/stores';
import axios from "axios";

const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'Accept': 'application/json',
        'Access-Control-Allow-Origin' : '*',
        'Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS',
    }
});

axiosInstance.interceptors.request.use( (config) => {
    const { user } = useAuthStore();
    if (user && user?.access_token) {
        config.headers.Authorization = `Bearer ${user.access_token}`;
    }
    return config;
});

axiosInstance.interceptors.response.use(handleResponse);

async function handleResponse(response) {
    const isJson = response.headers?.get('Accept')?.includes('application/json');
    const data = isJson ? await response.json() : null;
    // check for error response
    if (response.status >= 400) {
        const { user, logout } = useAuthStore();
        if ([401, 403].includes(response.status) && user) {
            // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
            logout();
        }
        const error = (data && data.message) || response.status;
        return response;
    }
    return response;
}


export {axiosInstance};