import { AuthStateTokenType, AuthStateUserType } from '@/types/AuthTypes';

export default interface AuthState {
    user: AuthStateUserType;
    token: AuthStateTokenType;
}
