import AuthStateUserInterface from '@/interfaces/auth/AuthStateUserInterface';

export default interface AuthStateInterface {
    user: AuthStateUserInterface | null;
    token: string | null;
}
