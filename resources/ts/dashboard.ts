(async ($, $$, _, __) => {
    const json = async (url) => (await fetch(url)).json();
    const numberFormatter = new Intl.NumberFormat(`en-IN`, {
        maximumFractionDigits: 0,
    });
    
    const counts = await json('/ajax/count/');

    for(let key of Object.keys(counts)) {
        const element = $(`#${key}Count`);
        if(element) {
            element.innerHTML = element.id == "newPortalReleasedCount" ? counts[key] : numberFormatter.format(counts[key]);
        }
    }
})(document.querySelector.bind(document), document.querySelectorAll.bind(document), console.log.bind(console), console.error.bind(console));