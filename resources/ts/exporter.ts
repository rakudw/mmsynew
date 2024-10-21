import jQuery from 'jquery';
import { utils, write } from 'xlsx';
import { saveAs } from 'file-saver';
import 'print-this';

(async () => {

    const stringToArrayBuffer = function (s: string) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    };

    document.querySelectorAll('button[data-print]').forEach((printButton:HTMLButtonElement) => printButton.addEventListener('click', () => jQuery(printButton.dataset.print).printThis()));

    document.querySelectorAll('button[data-export]').forEach((downloadButton: HTMLButtonElement) => {
        downloadButton.addEventListener('click', () => {
            const wb = utils.table_to_book(document.getElementById(downloadButton.dataset.export), { sheet: "Sheet JS" });
            const wbout = write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });
            saveAs(new Blob([stringToArrayBuffer(wbout)], { type: "application/octet-stream" }), (downloadButton.dataset.exportName ?? 'Report') + '.xlsx');
        });
    });
})();