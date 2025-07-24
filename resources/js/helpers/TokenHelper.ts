import axios from 'axios';
import { AuthStateToken } from '@/types/AuthTypes';

export const applyBearer = (token: AuthStateToken): void => {
    if (!token) { return; }

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
};

export const applyToken = (token: AuthStateToken): void => {
    if (!token) { return; }

    localStorage.setItem('token', token);
    applyBearer(token);
};

export const retrieveToken = (): AuthStateToken => localStorage.getItem('token');

export const purgeToken = (): void => {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
};
