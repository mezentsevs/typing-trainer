import AuthStateInterface from '@/interfaces/AuthStateInterface';
import AuthStateUserInterface from '@/interfaces/AuthStateUserInterface';
import axios, { AxiosResponse } from 'axios';
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: (): AuthStateInterface => ({
        user: null as AuthStateUserInterface | null,
        token: localStorage.getItem('token') || null,
    }),
    actions: {
        async login(email: string, password: string): Promise<void> {
            const response: AxiosResponse<any, any> = await axios.post('/login', { email, password });

            this.token = response.data.token;
            this.user = response.data.user;

            localStorage.setItem('token', this.token!);
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        async register(name: string, email: string, password: string, password_confirmation: string): Promise<void> {
            const response: AxiosResponse<any, any> = await axios.post('/register', {
                name,
                email,
                password,
                password_confirmation,
            });

            this.token = response.data.token;
            this.user = response.data.user;

            localStorage.setItem('token', this.token!);
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        async logout(): Promise<void> {
            await axios.post('/logout');

            this.token = null;
            this.user = null;

            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        },
    },
});
