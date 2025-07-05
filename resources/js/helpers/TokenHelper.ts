import axios from 'axios';
import { AuthStateToken } from '@/types/AuthTypes';

export function applyBearer(token: AuthStateToken): void {
    if (!token) { return; }

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export function applyToken(token: AuthStateToken): void {
    if (!token) { return; }

    localStorage.setItem('token', token);
    applyBearer(token);
}

export function retrieveToken(): AuthStateToken { return localStorage.getItem('token'); }

export function purgeToken(): void {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
}
