import axios from 'axios';
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null as { id: number; name: string; email: string } | null,
        token: localStorage.getItem('token') || null,
    }),
    actions: {
        async login(email: string, password: string) {
            const response = await axios.post('/login', { email, password });
            this.token = response.data.token;
            this.user = response.data.user;
            localStorage.setItem('token', this.token!);
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        async register(name: string, email: string, password: string, password_confirmation: string) {
            const response = await axios.post('/register', { name, email, password, password_confirmation });
            this.token = response.data.token;
            this.user = response.data.user;
            localStorage.setItem('token', this.token!);
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        async logout() {
            await axios.post('/logout');
            this.token = null;
            this.user = null;
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        },
    },
});
