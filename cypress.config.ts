import { defineConfig } from 'cypress';

export default defineConfig({
    e2e: {
        baseUrl: 'http://localhost:8080',
        specPattern: 'tests/cypress/e2e/**/*.cy.{js,jsx,ts,tsx}',
    },
});
