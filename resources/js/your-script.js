import DOMPurify from 'dompurify';

// ...existing code...

async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    var table = document.getElementById('myTable').cloneNode(true);
    var aksiIndex = Array.from(table.rows[0].cells).findIndex(cell => cell.innerText === 'Aksi');

    for (var i = 0; i < table.rows.length; i++) {
        table.rows[i].deleteCell(aksiIndex);
    }

    var html = table.outerHTML;
    var cleanHtml = DOMPurify.sanitize(html); // Use DOMPurify to sanitize the HTML

    doc.html(cleanHtml, {
        callback: function (doc) {
            doc.save('gaji.pdf');
        },
        x: 10,
        y: 10
    });
}
