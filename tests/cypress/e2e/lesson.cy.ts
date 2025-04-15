describe('Lessons', () => {
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

    it('allows a user to generate and complete a lesson', () => {
        cy.visit('/setup');
        cy.get('select').select('English');
        cy.get('input[type="number"]').type('2');
        cy.get('button').contains('Generate Lessons').click();
        cy.url().should('include', '/lesson/en/1');
        cy.get('input').type('abc');
        cy.get('.error-char').should('not.exist');
        cy.get('a').contains('Next Lesson').click();
    });
});
