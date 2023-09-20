import 'bootstrap';

((_) => {

    document.querySelectorAll('input').forEach((i) => i.autocomplete = 'off');
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', (e) => {
            if (confirm(element.dataset.confirm)) {
                e.preventDefault();
                return false;
            }
        });
    });
})(window);