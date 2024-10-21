import * as sweetAlert from 'sweetalert2';
import { Datepicker } from 'vanillajs-datepicker';
import printJS from 'print-js';

(($, $$) => {

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

    const trigger = (element: HTMLElement | Array<HTMLElement>, eventTypes: string) => (((element as HTMLElement).nodeName ? [element] : element) as Array<HTMLElement>).forEach((e) => eventTypes.split(' ').forEach(eventType => e.dispatchEvent(new Event(eventType))));

    document.getElementById('printButton')?.addEventListener('click', () => printJS({
        printable: document.getElementById('printable'),
        type: 'html',
        css: '/build/css/admin.css',
    }));

    const statusVars:HTMLElement[] = [...$$('[data-status-vars]')];
    statusVars.forEach((statusVar:HTMLElement) => statusVar.querySelectorAll('[required]').forEach((v:HTMLFormElement) => v.dataset.required = v.required));

    const statusDropdown:HTMLSelectElement = $('[name="status"]');
    if(statusDropdown) {
        statusDropdown.addEventListener('change', () => {
            statusVars.forEach((e:HTMLElement) => {
                e.classList.add('d-none');
                e.querySelectorAll('[data-required]').forEach((control:HTMLFormElement) => control.required = false);
            });
            statusVars.filter(v => v.dataset.statusVars == statusDropdown.value).forEach((current:HTMLElement) => {
                current.classList.remove('d-none');
                current.querySelectorAll('[data-required]').forEach((control:HTMLFormElement) => control.required = control.dataset.required == 'true');
            });
        });

        trigger(statusDropdown, 'change');
    }

    const form:HTMLFormElement = $('form');
    if(form) {
        form.addEventListener('submit', () => confirm('Are you sure you want to update the application?'));
    }

    initializeDatepickers();
})(document.querySelector.bind(document), document.querySelectorAll.bind(document));