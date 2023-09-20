import $ from 'jquery';

(function() {
    const $affectedElements = $("p, h1, h2, h3, h4, h5, h6"); // Can be extended, ex. $("div, p, span.someClass")

    // Storing the original size in a data attribute so size can be reset
    $affectedElements.each(function () {
        const $this = $(this);
        $this.data("orig-size", $this.css("font-size"));
    });

    $("#btn-increase").click(function () {
        changeFontSize(1);
    })

    $("#btn-decrease").click(function () {
        changeFontSize(-1);
    })

    $("#btn-orig").on('click', function () {
        $affectedElements.each(function () {
            const $this = $(this);
            $this.css("font-size", $this.data("orig-size"));
        });
    });

    function changeFontSize(direction) {
        $affectedElements.each(function () {
            const $this = $(this);
            $this.css("font-size", parseInt($this.css("font-size")) + direction);
        });
    }

    // Let's make theme changeable
    const toggleSwitch = document.querySelector('.form-switch input[type="checkbox"]');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
        if (currentTheme === 'dark') {
            toggleSwitch.checked = true;
        }
    }

    function switchTheme(e) {
        if (e.target.checked) {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        }
    }
    toggleSwitch.addEventListener('change', switchTheme, false);

    const marquee = document.querySelector('marquee');
    marquee.addEventListener('mouseenter', function() {
        this.stop();
    });
    marquee.addEventListener('mouseleave', function() {
        this.start();
    });
})();