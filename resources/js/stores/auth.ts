import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthStateInterface from '@/interfaces/auth/AuthStateInterface';
import axios, { AxiosResponse } from 'axios';
import { AuthStateTokenType, AuthStateUserType } from '@/types/AuthTypes';
import { defineStore, StoreDefinition } from 'pinia';

const applyToken = (token: AuthStateTokenType): void => {
    localStorage.setItem('token', token!);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
};

const purgeToken = (): void => {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
};

export const useAuthStore: StoreDefinition<string, AuthStateInterface, AuthGettersInterface, AuthActionsInterface> = defineStore('auth', {
    state: (): AuthStateInterface => ({
        user: null as AuthStateUserType,
        token: (localStorage.getItem('token') || null) as AuthStateTokenType,
    }),
    getters: {
        //
    },
    actions: {
        async login(email: string, password: string): Promise<void> {
            const response: AxiosResponse<any, any> = await axios.post('/login', { email, password });

            this.token = response.data.token;
            this.user = response.data.user;

            applyToken(this.token);
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

            applyToken(this.token);
        },
        async logout(): Promise<void> {
            await axios.post('/logout');

            this.token = null;
            this.user = null;

            purgeToken();
        },
    },
});
