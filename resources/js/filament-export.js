function onElementRemoved(element, callback) {
    new MutationObserver(function (mutations) {
        if (!document.body.contains(element)) {
            callback();
            this.disconnect();
        }
    }).observe(element.parentElement, { childList: true });
}

function printHTML(html, statePath, uniqueActionId, $set) {
    let iframe = document.createElement("iframe");

    let random = Math.floor(Math.random() * 99999);

    iframe.id = `print-${random}`;

    iframe.srcdoc = html;

    document.body.append(iframe);

    iframe.contentWindow.onafterprint = () => document.getElementById(iframe.id).remove();

    iframe.contentWindow.onload = () => iframe.contentWindow.print();
}

window.printHTML = printHTML;