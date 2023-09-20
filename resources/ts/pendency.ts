import { Datepicker } from 'vanillajs-datepicker';
import { Multicheck } from './multicheck';

(($, $$, _, __) => {

    const initializeDatepickers = () => {
        $$('input[type="date"]').forEach(input => {
            if (typeof input.datepicker != 'undefined') {
                return;
            }
            input.type = 'text';
            const options = { format: 'yyyy-mm-dd' };
            for (let key in input.dataset) {
                if (key.startsWith('datepickerX')) {
                    const prop = key.substring(11);
                    if (['minDate', 'maxDate'].indexOf(prop) > -1) {
                        const date = new Date();
                        date.setFullYear(date.getFullYear() + parseInt(input.dataset[key]));
                        options[prop] = Datepicker.formatDate(date, options.format);
                    } else {
                        options[prop] = input.dataset[key];
                    }
                }
            }
            input.datepicker = new Datepicker(input, options);
        });
    };
    initializeDatepickers();

    const multicheck = $('#customCheckMulti');
    if (multicheck) {
        new Multicheck(multicheck, [...$$('[name="applications[]"')]);
    }
})(document.querySelector.bind(document), document.querySelectorAll.bind(document), console.log.bind(console), console.error.bind(console));