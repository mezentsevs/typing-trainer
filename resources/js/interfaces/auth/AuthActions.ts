export default interface AuthActions {
    fetchMe(): Promise<void>;
    login(email: string, password: string): Promise<void>;
    register(
        name: string,
        email: string,
        password: string,
        passwordConfirmation: string,
    ): Promise<void>;
    logout(): Promise<void>;
}
