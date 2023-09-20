jQuery(document).ready(function () {
    const $slider = jQuery('.gallery-slider');
    const $thumbnails = jQuery('.thumbnail');
    const $prevButton = jQuery('#prevButton');
    const $nextButton = jQuery('#nextButton');

    const numThumbnails = $thumbnails.length;
    let currentIndex = 0;
    let numColumns = 5; // Initial number of columns

    // Function to update the number of columns based on screen width
    function updateColumns() {
        if (window.innerWidth <= 768) {
            numColumns = 2; // 2 columns on smaller screens
        } else {
            numColumns = 5; // 5 columns on larger screens
        }
    }

    // Initial update
    updateColumns();

    $thumbnails.on('click', function () {
        currentIndex = $thumbnails.index(this);
        updateSlider();
    });

    $prevButton.on('click', function () {
        currentIndex = (currentIndex - 1 + numThumbnails) % numThumbnails;
        updateSlider();
    });

    $nextButton.on('click', function () {
        currentIndex = (currentIndex + 1) % numThumbnails;
        updateSlider();
    });

    function updateSlider() {
        const translateX = -currentIndex * (35 / numThumbnails / numColumns);
        $slider.css('transform', `translateX(${translateX}%)`);
    }

    // Listen for window resize events and update columns accordingly
    jQuery(window).on('resize', function () {
        updateColumns();
        updateSlider();
    });
});



// font size increase

const darkModeButton = document.getElementById("toggle-dark-mode");
const lightModeButton = document.getElementById("toggle-light-mode");
const textElements = document.querySelectorAll('p, h2, h5, h6, li,a,button');
const changeTheColor=document.querySelectorAll('.text-element');

const increaseFontSizeButton = document.getElementById('increase-font-size');
const decreaseFontSizeButton = document.getElementById('decrease-font-size');
const toggleItalicButton = document.getElementById('toggle-italic');
let fontSize = 16;
let isItalic = false;
 

lightModeButton.addEventListener("click", () => {
    changeTheColor.forEach(element => {
        element.classList.remove("dark-theme");
        element.classList.add("light-theme");
    });
});

darkModeButton.addEventListener("click", () => {
    changeTheColor.forEach(element => {
        element.classList.remove("light-theme");
        element.classList.add("dark-theme");
    });
});

function updateTextStyles() {
    textElements.forEach((element) => {
        element.style.fontSize = fontSize + 'px';
        element.style.fontStyle = isItalic ? 'italic' : 'normal';
    });
}

increaseFontSizeButton.addEventListener('click', () => {
    if (fontSize < 20) {
        fontSize += 1; // Increase font size by 1 if it's less than 20
    }
    updateTextStyles();
});

 decreaseFontSizeButton.addEventListener('click', () => {
    fontSize -= 1;  
    if (fontSize < 12) {
        fontSize = 12;  
    }
    updateTextStyles();
});

 toggleItalicButton.addEventListener('click', () => {
    fontSize = 16;
    isItalic = !isItalic;
    updateTextStyles();
});

 updateTextStyles();



 $(document).ready(function () {
    $(".read_more").click(function () {
        $(".paragraph_detailed_toggle").toggleClass("toggle_class_name");
    });
});
