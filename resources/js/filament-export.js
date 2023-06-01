function onElementRemoved(element, callback) {
    new MutationObserver(function (mutations) {
        if (!document.body.contains(element)) {
            callback();
            this.disconnect();
        }
    }).observe(element.parentElement, { childList: true });
}

function triggerInputEvent(statePath, value) {
    let input = document.getElementById(statePath);
    input.value = value;
    input.dispatchEvent(new Event('input', { bubbles: true }));
}

function printHTML(html, statePath, uniqueActionId) {
    let iframe = document.createElement("iframe");

    let random = Math.floor(Math.random() * 99999);

    iframe.id = `print-${random}`;

    iframe.srcdoc = html;

    document.body.append(iframe);

    onElementRemoved(iframe, () => triggerInputEvent(statePath, `afterprint-${uniqueActionId}`));

    iframe.contentWindow.onafterprint = () => document.getElementById(iframe.id).remove();

    iframe.contentWindow.onload = () => iframe.contentWindow.print();
}

window.triggerInputEvent = triggerInputEvent;

window.printHTML = printHTML;