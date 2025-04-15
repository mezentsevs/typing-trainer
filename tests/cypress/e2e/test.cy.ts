describe('Final Test', () => {
    beforeEach(() => {
        cy.request('POST', '/api/register', {
            name: 'Test User',
            email: 'test@example.com',
            password: 'password',
            password_confirmation: 'password',
        });
        cy.request('POST', '/api/login', {
            email: 'test@example.com',
            password: 'password',
        }).then((response) => {
            localStorage.setItem('token', response.body.token);
        });
    });

    it('allows a user to take the final test', () => {
        cy.visit('/test');
        cy.get('select').first().select('English');
        cy.get('button').contains('Start Test').click();
        cy.get('input').type('The quick brown fox');
        cy.get('.error-char').should('not.exist');
    });
});
