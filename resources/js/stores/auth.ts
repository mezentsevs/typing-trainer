import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthStateInterface from '@/interfaces/auth/AuthStateInterface';
import axios, { AxiosResponse } from 'axios';
import { AuthStateTokenType, AuthStateUserType } from '@/types/AuthTypes';
import { applyToken, purgeToken, retrieveToken } from '@/helpers/TokenHelper';
import { defineStore, StoreDefinition } from 'pinia';

export const useAuthStore: StoreDefinition<string, AuthStateInterface, AuthGettersInterface, AuthActionsInterface> = defineStore('auth', {
    state: (): AuthStateInterface => ({
        user: null as AuthStateUserType,
        token: retrieveToken(),
    }),
    getters: {
        //
    },
    actions: {
        async login(email: string, password: string): Promise<void> {
            const response: AxiosResponse<{
                token: AuthStateTokenType;
                user: AuthStateUserType;
            }> = await axios.post('/login', { email, password });

            this.token = response.data.token;
            this.user = response.data.user;

            applyToken(this.token);
        },
        async register(name: string, email: string, password: string, passwordConfirmation: string): Promise<void> {
            const response: AxiosResponse<{
                token: AuthStateTokenType;
                user: AuthStateUserType;
            }> = await axios.post('/register', {
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
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
