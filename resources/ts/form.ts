import * as sweetAlert from 'sweetalert2';
import * as choicesJs from 'choices.js';
import { Datepicker } from 'vanillajs-datepicker';
import * as axios from 'axios';

(($, $$, _, __) => {

    const Select = choicesJs.default;

    (window as any).axios = axios;
    const APPLICATION = (window as any).APPLICATION;
    const rupees = new Intl.NumberFormat(`en-IN`, {
        currency: `INR`,
        style: 'currency',
        maximumFractionDigits: 0,
    });

    const age = (date: Date) => {
        return Math.abs(new Date(Date.now() - date.getTime()).getUTCFullYear() - 1970);
    };

    const trigger = (element: HTMLElement | Array<HTMLElement>, eventTypes: string | string[]) => (((element as HTMLElement).nodeName ? [element] : element) as Array<HTMLElement>).forEach((e) => (typeof eventTypes == 'string' ? eventTypes.split(' ') : eventTypes).forEach(eventType => e.dispatchEvent(new Event(eventType))));

    const pincodeInput: HTMLInputElement | null = $('input[name="pincode"]');
    const ownContributionInput: HTMLInputElement | null = $('input[name="own_contribution"]');

    const on = (elements: HTMLElement | Array<HTMLElement>, events: string | string[], handler: (...args: any[]) => void, shouldTrigger: boolean = false) => {
        events = typeof events == 'string' ? events.split(' ') : events;
        elements = (elements as HTMLElement).nodeName ? [elements as HTMLElement] : elements;
        (elements as Array<HTMLElement>).forEach((element) => {
            (events as Array<string>).forEach((event) => {
                element.addEventListener(event, handler);
            });
        });
        if (shouldTrigger) {
            trigger(elements, events);
        }
        return elements;
    };

    const initializeSelect = (select: HTMLSelectElement) => {
        if (select.dataset.simple) return;
        (select as any).instance = new Select(select, {
            classNames: {
                containerOuter: 'choices w-100'
            }, placeholder: true,
            allowHTML: false,
            shouldSort: true,
            shouldSortItems: false
        });
    };

    const reloadOptions = async function (element: HTMLSelectElement, value: any) {
        if (!element) {
            return;
        }
        if (element.dataset.reloading == 'true') {
            return;
        }
        element.dataset.reloading = 'true';
        let choices = [];
        (element as any).instance.clearStore();
        if (!value) {
            element.dataset.reloading = 'false';
            trigger(element, 'change');
            return;
        }
        const data = {
            params: {
                options: element.dataset.options.replace('$' + element.dataset.depends, value),
            }, headers: {
                'Content-Type': 'application/json'
            },
        };
        let resp = (await axios.get('/ajax/load/', data)).data;
        let selectedFlag = false;
        for (let id in resp) {
            choices.push({
                value: id,
                label: resp[id],
                selected: element.dataset.value == id
            });
            selectedFlag || (selectedFlag = element.dataset.value == id);
        }
        (element as any).instance.setChoices(choices, 'value', 'label', true);
        trigger(element, 'change');
        if (selectedFlag) {
            (element as any).instance.setChoiceByValue(choices.filter(c => c.selected)[0].value + '');
        }
        element.dataset.reloading = 'false';
        trigger(element, 'change');
    };

    const initializeDatepickers = () => {
        $$('input[type="date"]').forEach((input: HTMLInputElement) => {
            if (typeof (input as any).datepicker != 'undefined') {
                return;
            }
            if (input.dataset.age) {
                on(input, 'changeDate blur', () => {
                    const ageHolder = input.dataset.ageNext ? input.parentElement?.querySelector('span.badge') : $(`#${input.name}_age`);
                    if (ageHolder) {
                        ageHolder.innerHTML = input.value ? `<b>Age: ${age(new Date(input.value))} years</b>` : '';
                    }
                });
            }
            input.type = 'text';
            const options = { format: 'yyyy-mm-dd' };
            for (let key in input.dataset) {
                if (key.startsWith('datepickerX')) {
                    const prop = key.substring(11);
                    if (['maxDate'].indexOf(prop) > -1) {
                        const date = new Date();
                        date.setFullYear(date.getFullYear() + parseInt(input.dataset[key]));
                        options[prop] = Datepicker.formatDate(date, options.format);
                    } else {
                        options[prop] = input.dataset[key];
                    }
                }
            }
            (input as any).datepicker = new Datepicker(input, options);
        });
    };

    const projectCostInput: HTMLInputElement = $('input[name="project_cost"]');
    const bankIfsc: HTMLInputElement = $('input[name="bank_ifsc"]');

    $$('.duplicatePreviousRowButton').forEach(function (button: HTMLButtonElement) {
        const tbody = button.closest('tfoot').previousElementSibling;
        const tr = tbody.querySelector('tr');
        const html = tr.outerHTML.replace('<td></td>', '<td><button class="btn btn-danger btn-sm" title="Delete" type="button"><i class="material-icons fs-5">remove_circle</i></button></td>');
        button.addEventListener('click', function () {
            tbody.insertAdjacentHTML('beforeend', html);
            tbody.querySelector(`tr:nth-child(${tbody.children.length}) button.btn-danger`).addEventListener('click', function () {
                this.closest('tr').remove();
            });
            initializeDatepickers();
        });
        const names = Array.from(tr.querySelectorAll('[name]')).map((e: HTMLFormElement) => e.name.replace('[]', ''));
        if (names.length > 0 && typeof APPLICATION.DATA[APPLICATION.TAB] != 'undefined' && typeof APPLICATION.DATA[APPLICATION.TAB][names[0]] != 'undefined') {
            for (let i = 0; i < APPLICATION.DATA[APPLICATION.TAB][names[0]].length; i++) {
                (i > 0) && trigger(button, 'click');
                const lastRow = tbody.querySelector(`tr:nth-child(${tbody.children.length})`);
                for (let j = 0; j < names.length; j++) {
                    (lastRow.querySelector(`[name="${names[j]}[]"]`) as HTMLFormElement).value = APPLICATION.DATA[APPLICATION.TAB][names[j]][i];
                }
            }
        }
    });

    initializeDatepickers();

    if (projectCostInput) {
        const inputs = $$('input[type="number"]');
        on(inputs, 'change input', function () {
            let total = 0;
            for (let input of inputs) {
                if (!input.readOnly && (input.name != 'land_cost')) {
                    const val = parseFloat(input.value);
                    total += isNaN(val) ? 0 : val;
                }
            }
            projectCostInput.value = total.toFixed(0);
        });
        trigger(inputs[0], 'change');
    }

    if (bankIfsc) {
        const bankInfoPara = document.createElement('p');
        bankInfoPara.classList.add('lead');
        bankIfsc.parentElement.insertAdjacentElement('afterend', bankInfoPara);
        let loadingIfsc = false;
        let shouldReload = false;
        let lastIfsc: string = '';
        on(bankIfsc, 'change input', async () => {
            if (bankIfsc.validity.valid) {
                if (loadingIfsc) {
                    if (lastIfsc != bankIfsc.value) {
                        shouldReload = true;
                    }
                    return;
                }
                loadingIfsc = true;
                bankInfoPara.innerHTML = 'Checking ...';
                bankInfoPara.classList.add('text-info');
                lastIfsc = bankIfsc.value;
                try {
                    const bankInfo = (await axios.get(`https://ifsc.razorpay.com/${bankIfsc.value}`)).data;
                    if (shouldReload) {
                        trigger(bankIfsc, 'change');
                    } else {
                        if (bankInfo == 'Not Found') {
                            bankInfoPara.classList.remove('text-danger', 'text-info', 'text-success');
                            bankInfoPara.classList.add('text-secondary');
                            bankInfoPara.innerHTML = 'We are not able to verify the bank details, please cross check the code!';
                        } else {
                            bankInfoPara.innerHTML = `<b><u>Adderss:</u></b> ${bankInfo.ADDRESS}, <b><u>Bank:</u></b> ${bankInfo.BANK}, <b><u>Branch:</u></b> ${bankInfo.BRANCH}`;
                            bankInfoPara.classList.remove('text-danger', 'text-info', 'text-secondary');
                            bankInfoPara.classList.add('text-success');
                        }
                    }
                } catch (err) {
                    bankInfoPara.classList.add('text-danger');
                    bankInfoPara.classList.remove('text-success', 'text-info', 'text-secondary');
                    bankInfoPara.innerHTML = 'We are unable to fetch the bank information! Please check your internet connection.';
                    setTimeout(() => trigger(bankIfsc, 'change'), 5000);
                }
            } else {
                bankInfoPara.classList.add('text-danger');
                bankInfoPara.classList.remove('text-success', 'text-info', 'text-secondary');
                bankInfoPara.innerHTML = 'Please enter a valid IFS code!';
            }
        });
        if (bankIfsc.value) trigger(bankIfsc, 'change');
    }

    $$('form select[name]').forEach(initializeSelect);

    $$('input.form-control').forEach((e: HTMLInputElement) => e.closest('.input-group') && e.closest('.input-group').classList[e.value ? 'add' : 'remove']('is-filled'));

    $$('[data-condition]').forEach(function (element: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement) {
        const elementParts = element.dataset.condition.split(' & ');
        const isRequired = element.required;
        const form = element.closest('form');
        const changeInputs = elementParts.map(ep => form[ep.split(':')[0]]);
        const changeValues = elementParts.map(ep => ep.split(':')[1].split(','));
        const checkCondition = () => {
            let condition = false;
            for (let changeInputIndex in changeInputs) {
                const changeInput = changeInputs[changeInputIndex];
                condition = changeValues[changeInputIndex].indexOf(changeInput.value) > -1;
                if (!condition) break;
            }
            if (condition) {
                element.disabled = false;
                isRequired && element.setAttribute('required', 'required');
            } else {
                element.disabled = true;
                element.removeAttribute('required');
            }
        };
        checkCondition();
        trigger(on(changeInputs, 'change', checkCondition), 'change');
    });

    $$('[data-changes]').forEach(function (select: HTMLSelectElement) {
        on(select, 'change', function (e) {
            select.dataset.changes.split(',').forEach(function (name) {
                reloadOptions(document.querySelector(`select[name="${name}"]`), select.value);
            });
        });
        trigger(select, 'change');
    });

    const numeric = (val: any) => {
        const result = +val;
        return isNaN(result) ? 0 : result;
    }

    if (ownContributionInput) {
        const capitalExpenditure = numeric(APPLICATION.DATA.cost.land_cost) + numeric(APPLICATION.DATA.cost.machinery_cost) + numeric(APPLICATION.DATA.cost.assets_cost) + numeric(APPLICATION.DATA.cost.building_cost);
        const projectCost = capitalExpenditure + numeric(APPLICATION.DATA.cost.working_capital);

        $('#capitalExpenditure').innerText = rupees.format(capitalExpenditure);
        $('#projectCost').innerText = rupees.format(projectCost);

        const workingCapitalInput = $('input[name="working_capital"]');
        workingCapitalInput.value = APPLICATION.DATA.cost.working_capital;
        workingCapitalInput.focus();
        setTimeout(() => {
            workingCapitalInput.readOnly = true;
        }, 100);

        on(ownContributionInput, 'change', () => {
            const ownContribution = Math.round((projectCost * (parseFloat(ownContributionInput.value) / 100)) / 10) * 10;
            const workingCapital = numeric(APPLICATION.DATA.cost.working_capital) - (Math.round((numeric(APPLICATION.DATA.cost.working_capital) * (parseFloat(ownContributionInput.value) / 100)) / 10) * 10);

            $('input[name="own_contribution_amount"]').value = ownContribution;
            workingCapitalInput.value = workingCapital;

            $('input[name="term_loan"]').value = projectCost - workingCapital - ownContribution;
        });
        if (!ownContributionInput.value) ownContributionInput.value = '10';
        trigger(ownContributionInput, 'change');
    }

    if (pincodeInput) {
        const buildPostOfficeOptions = (pincodes) => {
            const result = {};
            for (let pincode of pincodes) {
                result[pincode.id] = pincode.name;
            }
            return result;
        };
        on(pincodeInput, 'input', async function () {
            if (pincodeInput.validity.valid) {
                const pincodes: Array<any> = (await axios.get(`/ajax/search/postOffice?filter[pincode]=${pincodeInput.value}&columns=id,name,district_id,tehsil_id,block_id`)).data;
                if (pincodes.length > 0) {
                    let pincode = pincodes[0];
                    if (pincodes.length > 1) {
                        const alertResponse = (await sweetAlert.fire({
                            title: 'Select a Post Office',
                            input: 'select',
                            inputOptions: buildPostOfficeOptions(pincodes),
                            inputPlaceholder: 'Select a Post Office',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            inputValidator: (value) => new Promise((resolve: Function) => value ? resolve() : resolve('You need to select a post office!'))
                        })).value;
                        pincode = pincodes.filter(p => p.id == alertResponse)[0];
                    }

                    ['block_id', 'tehsil_id'].forEach(name => pincode[name] && ($(`select[name="${name}"]`).dataset.value = pincode[name]));
                    const districtSelect = $('select[name="district_id"]');
                    districtSelect.dataset.value = pincode.district_id;
                    districtSelect.instance.setChoiceByValue(pincode.district_id + '');
                    trigger(districtSelect, 'change');
                }
            }
        });
    }

    $$('input[data-prefix]').forEach((input: HTMLInputElement) => {
        const parent = input.parentElement?.parentElement;
        const html = `<div class="row">
            <div class="col-3">
                <label>&nbsp;</label>
                <select class="form-select my-3" name="${input.name}_prefix">
                    ${input.dataset.prefix.split(',').map(s => `<option value="${s}">${s}</option>`).join('')}
                </select>
            </div>
            <div class="col-9">
                ${parent?.innerHTML}
            </div>
        </div>`;
        parent && (parent.innerHTML = html);
        if (APPLICATION.DATA.owner && APPLICATION.DATA.owner[`${input.name}_prefix`]) {
            $(`select[name="${input.name}_prefix"]`)!.value = APPLICATION.DATA.owner[`${input.name}_prefix`];
        }
    });

    const manufacturingCheck = $('[data-check-manufacturing]');
    if (manufacturingCheck && APPLICATION.DATA.enterprise.activity_type_id == 201) {
        manufacturingCheck.remove();
    }

    if (APPLICATION.TAB == 'owner') {
        const setMinDate = (dob: HTMLInputElement, gender: string) => {
            let minDate = -45;
            if (gender == 'Female') {
                minDate = -50;
            }
            const date = new Date();
            date.setFullYear(date.getFullYear() + minDate);
            (dob as any).datepicker.setOptions({ minDate: date });
            if (new Date(dob.value) < date) {
                (dob as any).datepicker.setDate(date);
            }
        };

        const partnerGenderChanged = (genderDropdown: HTMLSelectElement) => {
            const dobInput: HTMLInputElement = genderDropdown.parentElement.nextElementSibling.querySelector('input');
            setMinDate(dobInput, genderDropdown.value);
        };

        on($('select[name="gender"]'), 'change', (e) => setMinDate($('input[name="birth_date"]'), e.target.value), true);

        const partnersTable = $('#partnersTable');
        partnersTable && on(partnersTable, 'change', (e) => {
            const target = e.target as HTMLSelectElement;
            if (target.name.startsWith('partner_gender')) {
                partnerGenderChanged(target);
            }
        });
        $$('select[name="partner_gender[]"]').forEach(partnerGenderChanged);

        on($('form'), 'submit', (e: SubmitEvent) => {
            _((e.target as HTMLFormElement));
            return false;
        });
    }
})(document.querySelector.bind(document), document.querySelectorAll.bind(document), console.log.bind(console), console.error.bind(console));