import { AuthStateToken, AuthStateUser } from '@/types/AuthTypes';

export default interface AuthState {
    user: AuthStateUser;
    token: AuthStateToken;
}
