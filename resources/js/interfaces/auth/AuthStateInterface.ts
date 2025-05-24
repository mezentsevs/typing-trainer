import { AuthStateTokenType, AuthStateUserType } from '@/types/AuthTypes';

export default interface AuthStateInterface {
    user: AuthStateUserType;
    token: AuthStateTokenType;
}
