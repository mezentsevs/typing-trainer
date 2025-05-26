import axios from 'axios';
import { AuthStateTokenType } from '@/types/AuthTypes';

export function applyToken(token: AuthStateTokenType): void {
    localStorage.setItem('token', token!);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export function retrieveToken(): AuthStateTokenType { return localStorage.getItem('token'); }

export function purgeToken(): void {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
}
