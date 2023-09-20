// Enable check and uncheck all functionality
(($, $$) => {
    $('.checkbox-toggle') && $('.checkbox-toggle').addEventListener('click', function () {
        const icon = this.querySelector('i');
        if (this.dataset.clicks) {
            $$('.table input[type="checkbox"]').forEach((e) => e.checked = false);
            icon.classList.add('fa-square');
            icon.classList.remove('fa-check-square');
            this.dataset.clicks = '';
        } else {
            $$('.table input[type="checkbox"]').forEach((e) => e.checked = true);
            icon.classList.remove('fa-square');
            icon.classList.add('fa-check-square');
            this.dataset.clicks = '1';
        }
    });

    const win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        const options = {
            damping: '0.5',
        };
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
})(document.querySelector.bind(document), document.querySelectorAll.bind(document));
