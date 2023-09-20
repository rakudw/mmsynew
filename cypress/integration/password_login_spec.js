describe('Password Login Test', () => {
    it('Visits the home page of website', () => {

        cy.visit('https://mmsy-laravel9.test/');
        cy.contains('Login').click();

        cy.url()
            .should('include', '/login');

        cy.get('#identity')
            .type('rashid.mohamad@hp.nic.in')
            .should('have.value', 'rashid.mohamad@hp.nic.in');

        cy.get('#password')
            .type('P@55w0rd')
            .should('have.value', 'P@55w0rd');

        const md = (new Date().getMonth() + 1).toFixed(0).padStart(2, '0') + new Date().getDate().toFixed(0).padStart(2, '0');
        cy.get('#captcha')
            .type(md)
            .should('have.value', md);

        cy.get('form[data-key]')
            .submit();

        cy.url()
            .should('include', '/dashboard');
    });
});