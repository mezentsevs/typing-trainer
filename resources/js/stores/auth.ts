import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthStateInterface from '@/interfaces/auth/AuthStateInterface';
import AuthStateUserInterface from '@/interfaces/auth/AuthStateUserInterface';
import axios, { AxiosResponse } from 'axios';
import { defineStore, StoreDefinition } from 'pinia';

export const useAuthStore: StoreDefinition<string, AuthStateInterface, AuthGettersInterface, AuthActionsInterface> = defineStore('auth', {
    state: (): AuthStateInterface => ({
        user: null as AuthStateUserInterface | null,
        token: localStorage.getItem('token') || null,
    }),
    getters: {
        //
    },
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
