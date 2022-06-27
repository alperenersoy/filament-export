function printTable(el) {
    var domClone = el.cloneNode(true);

    var printArea = document.createElement("div");

    printArea.id = "printArea";

    document.body.classList.add("printing");

    document.body.appendChild(printArea);

    printArea.appendChild(domClone);

    window.print();

    printArea.remove();

    document.body.classList.remove("printing");
}
