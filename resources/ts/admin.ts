import '../material/js/plugins/perfect-scrollbar.min.js';
import 'smooth-scrollbar';
import '../material/js/material-dashboard';
import '../js/admin-custom';

((_) => {

    const trigger = (element: HTMLElement | Array<HTMLElement>, eventTypes: string) => (((element as HTMLElement).nodeName ? [element] : element) as Array<HTMLElement>).forEach((e) => eventTypes.split(' ').forEach(eventType => e.dispatchEvent(new Event(eventType))));

    const ready = (fn:any) => {
        if (document.readyState == 'complete') {
            fn();
        } else {
            document.addEventListener('readystatechange', () => {
                if(document.readyState == 'complete') {
                    fn();
                }
            });
        }
    };
    ready(() => document.querySelectorAll('input.form-control').forEach(async (i:HTMLInputElement) => {
        i.autocomplete = 'off';
        if(i.value) {
            setTimeout(() => trigger(i, 'focus'), 100);
        }
    }));
})(window as any);