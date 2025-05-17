import AuthStateUserInterface from '@/interfaces/AuthStateUserInterface';

export default interface AuthStateInterface {
    user: AuthStateUserInterface | null;
    token: string | null;
}
