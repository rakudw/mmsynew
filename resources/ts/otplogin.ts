import * as sweetAlert from 'sweetalert2';
import '../crypto/cryptojs-aes.min.js';
import '../crypto/cryptojs-aes-format.js';
import Swal from 'sweetalert2';


(($, $$, _, __) => {

    const captchaRefreshButton = $('#captchaRefreshButton');

    const key = document.querySelector('form').dataset.key;

    const encrypt = (str) => CryptoJSAesJson.encrypt(str, key);

    const showOtpButton = $('#showOtpButton'),
        showPasswordButton = $('#showPasswordButton'),
        otpBox = $('#otpBox'),
        passwordBox = $('#passwordBox'),
        passwordInput = $('#password'),
        otpInput = $('#otpCode'),
        identityInput:HTMLInputElement = $('#identity');

    showOtpButton.defaultText = showOtpButton.innerText;
    const isMobileOTPAvailable:boolean = true;

    const show = (e) => e.classList.remove('d-none'),
        hide = (e) => e.classList.add('d-none'),
        isValidEmail = (str) => {
            const emailInput = document.createElement('input');
            emailInput.type = 'email';
            emailInput.value = str;
            emailInput.required = true;
            return emailInput.validity.valid;
        }, isMobile = (str:string) => !isNaN(parseInt(str)) && (parseInt(str) + '').length == 10;

    captchaRefreshButton?.addEventListener('click', () => {
        hide(captchaRefreshButton);
        captchaRefreshButton.previousElementSibling.src = `${captchaRefreshButton.previousElementSibling.src.split('?')[0]}?_t=${Date.now()}`;
    });

    captchaRefreshButton.previousElementSibling.addEventListener('load', () => {
        show(captchaRefreshButton);
    });

    showOtpButton?.addEventListener('click', async () => {
        if(showOtpButton.innerText != showOtpButton.defaultText) {
            return;
        }
        // console.log('dssad',isMobileOTPAvailable)
        if(!(isMobile(identityInput.value) || isValidEmail(identityInput.value))) {
            Swal.fire('Incorrect Email ID or Mobile Number', 'Please enter a correct email id or mobile number to send an OTP!', 'warning').then(() => identityInput.focus());
            return;
        }
        if(!isMobileOTPAvailable && isMobile(identityInput.value)) {
            Swal.fire('Mobile OTP Not Available', 'Mobile OTP service is not available at this time!<br />Our team is looking for a solution, meanwhile, use your email id for OTP.', 'warning').then(() => identityInput.focus());
            return;
        }
        identityInput.readOnly = true;
        showOtpButton.innerText = 'Sending OTP ...';
        const data = {_token: $('meta[name="csrf-token"]').getAttribute('content'), identity: encrypt(identityInput.value)};
        try {
            const response = await (await fetch(showOtpButton.dataset.url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })).json();
            console.log(response.status)
            // if(response.resendAfter) {
            //     console.log('showPasswordButton:', showPasswordButton);
            //     setTimeout(showPasswordButton.click.bind(showPasswordButton), response.resendAfter);
            // }
            if(response.status == 202){

                Swal.fire({
                    text: 'The OTP has been sent.',
                    toast: true,
                    icon: 'success',
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 5000,
                });
    
                document.querySelectorAll('.d-none').forEach((e) => e.classList.remove('d-none'));
                document.getElementById('optionButtonBox').classList.add('d-none');
                passwordBox.classList.add('d-none');
                passwordInput.value = '';
                passwordInput.removeAttribute('required');
                otpInput.setAttribute('required', 'required');
                identityInput.readOnly = true;
                otpInput.focus();
            }
            if(response.status == 404){
                alert("An error occurred: " + response.error);
            }
        } catch(err) {
            console.error(err);
            Swal.fire('Error!', err.message, 'error');
        }
        showOtpButton.innerText = showOtpButton.defaultText;
    });
    showPasswordButton?.addEventListener('click', () => {
        if(!(isMobile(identityInput.value) || isValidEmail(identityInput.value))) {
            sweetAlert.fire('Incorrect Email ID or Mobile Number', 'Please enter a correct email id or mobile number to send an OTP!', 'warning').then(() => identityInput.focus());
            return;
        }
        document.querySelectorAll('.d-none').forEach((e) => e.classList.remove('d-none'));
        document.getElementById('optionButtonBox').classList.add('d-none');
        otpInput.value = '';
        otpInput.removeAttribute('required');
        passwordInput.setAttribute('required', 'required');
        otpBox.classList.add('d-none');
        identityInput.readOnly = true;
        passwordInput.focus();
    });

    $('form').addEventListener('submit', function(event:Event) {
        if(!(isMobile(identityInput.value) || isValidEmail(identityInput.value))) {
            sweetAlert.fire('Incorrect Email ID or Mobile Number', 'Please enter a correct email id or mobile number to send an OTP!', 'warning').then(() => identityInput.focus());
            return false;
        }
        this.querySelectorAll('input[type="text"],input[type="number"],input[type="password"]').forEach((i:HTMLInputElement) => i.value && (i.type = 'password') && (i.value = encrypt(i.value)));
    });

    $('#showPassword').addEventListener('change', (e:Event) => {
        $('#password').type = (e.target as HTMLInputElement).checked ? 'text' : 'password';
    });
})(document.querySelector.bind(document), document.querySelectorAll.bind(document), console.log.bind(console), console.error.bind(console));