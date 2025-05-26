export default interface AuthActionsInterface {
    login(email: string, password: string): Promise<void>;
    register(name: string, email: string, password: string, passwordConfirmation: string): Promise<void>;
    logout(): Promise<void>;
}
