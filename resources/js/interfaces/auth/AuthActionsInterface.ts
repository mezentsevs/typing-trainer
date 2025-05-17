export default interface AuthActionsInterface {
    login(email: string, password: string): Promise<void>;
    register(name: string, email: string, password: string, password_confirmation: string): Promise<void>;
    logout(): Promise<void>;
}
