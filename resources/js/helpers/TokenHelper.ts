import axios from 'axios';
import { AuthStateTokenType } from '@/types/AuthTypes';

export function applyBearer(token: AuthStateTokenType): void {
    if (!token) { return; }

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export function applyToken(token: AuthStateTokenType): void {
    if (!token) { return; }

    localStorage.setItem('token', token);
    applyBearer(token);
}

export function retrieveToken(): AuthStateTokenType { return localStorage.getItem('token'); }

export function purgeToken(): void {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
}
