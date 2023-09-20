export class Multicheck {
    multicheck:HTMLInputElement;
    checkboxes:HTMLInputElement[];
    constructor(multicheck:HTMLInputElement, checkboxes:HTMLInputElement[]) {
        this.multicheck = multicheck;
        this.checkboxes = checkboxes;
        this.setMultiClick();
        this.setSingleClick();
    }

    private setMultiClick() {
        this.multicheck.addEventListener('click', () => {
            this.checkboxes.forEach(c => c.checked = this.multicheck.checked);
        });
    }

    private setSingleClick() {
        const eventHandler = () => {
            let checkedItems = this.checkboxes.filter(c => c.checked).length;
            if(checkedItems == 0) {
                this.multicheck.indeterminate = false;
                this.multicheck.checked = false;
            } else if(this.checkboxes.length == checkedItems) {
                this.multicheck.indeterminate = false;
                this.multicheck.checked = true;
            } else {
                this.multicheck.checked = false;
                this.multicheck.indeterminate = true;
            }
        };
        this.checkboxes.forEach(c => {
            c.addEventListener('click', eventHandler);
            c.addEventListener('change', eventHandler);
        });
        eventHandler();
    }
}