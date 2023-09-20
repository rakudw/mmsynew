describe('OTP Login Test', () => {
    it('Visits the home page of website', () => {

        cy.visit('https://mmsy-laravel9.test/');
        cy.contains('Login')
            .click();

        cy.url()
            .should('include', '/login');

        cy.get('#identity')
            .type('applicant@gmail.com')
            .should('have.value', 'applicant@gmail.com');

        cy.get('#showOtpButton')
            .click();

        cy.get('#otpCode')
            .type('123456')
            .should('have.value', '123456');

        const md = (new Date().getMonth() + 1).toFixed(0).padStart(2, '0') + new Date().getDate().toFixed(0).padStart(2, '0');
        cy.get('#captcha')
            .type(md)
            .should('have.value', md);

        cy.get('form[data-key]')
            .submit();

        cy.url()
            .should('include', '/applications');
    });
});