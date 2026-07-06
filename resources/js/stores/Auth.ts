import axios, { AxiosResponse } from 'axios';
import { defineStore, StoreDefinition } from 'pinia';

import { applyToken, purgeToken, retrieveToken } from '@/helpers/TokenHelper';
import { AuthStateToken, AuthStateUser } from '@/types/AuthTypes';
import AuthActions from '@/interfaces/auth/AuthActions';
import AuthGetters from '@/interfaces/auth/AuthGetters';
import AuthState from '@/interfaces/auth/AuthState';

export const useAuthStore: StoreDefinition<string, AuthState, AuthGetters, AuthActions> =
    defineStore('auth', {
        state: (): AuthState => ({
            user: null as AuthStateUser,
            token: retrieveToken(),
        }),
        getters: {
            //
        },
        actions: {
            async fetchMe(): Promise<void> {
                const response: AxiosResponse<{
                    user: AuthStateUser;
                }> = await axios.get('/me');

                if (response.data?.user) {
                    this.user = response.data.user;
                }
            },
            async login(email: string, password: string): Promise<void> {
                const response: AxiosResponse<{
                    token: AuthStateToken;
                    user: AuthStateUser;
                }> = await axios.post('/login', { email, password });

                if (response.data?.token && response.data?.user) {
                    this.token = response.data.token;
                    this.user = response.data.user;

                    applyToken(this.token);
                }
            },
            async register(
                name: string,
                email: string,
                password: string,
                passwordConfirmation: string,
            ): Promise<void> {
                const response: AxiosResponse<{
                    token: AuthStateToken;
                    user: AuthStateUser;
                }> = await axios.post('/register', {
                    name,
                    email,
                    password,
                    password_confirmation: passwordConfirmation,
                });

                if (response.data?.token && response.data?.user) {
                    this.token = response.data.token;
                    this.user = response.data.user;

                    applyToken(this.token);
                }
            },
            async logout(): Promise<void> {
                await axios.post('/logout');

                this.token = null;
                this.user = null;

                purgeToken();
            },
        },
    });
