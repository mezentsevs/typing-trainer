describe('Authentication', () => {
    it('allows a user to register', () => {
        cy.visit('/register');
        cy.get('input[placeholder="Name"]').type('Test User');
        cy.get('input[placeholder="Email"]').type('test@example.com');
        cy.get('input[placeholder="Password"]').type('password');
        cy.get('input[placeholder="Confirm Password"]').type('password');
        cy.get('button').contains('Register').click();
        cy.url().should('eq', 'http://localhost:8080/');
    });

    it('allows a user to login', () => {
        cy.request('POST', '/api/register', {
            name: 'Test User',
            email: 'test@example.com',
            password: 'password',
            password_confirmation: 'password',
        });
        cy.visit('/login');
        cy.get('input[placeholder="Email"]').type('test@example.com');
        cy.get('input[placeholder="Password"]').type('password');
        cy.get('button').contains('Login').click();
        cy.url().should('eq', 'http://localhost:8080/');
    });
});
