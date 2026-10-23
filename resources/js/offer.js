(() => {
    const container = document.getElementById('items-container');

    // Teklif oluşturma formu yoksa bu bölümü çalıştırma.
    if (!container) return;

    const template = document.getElementById('item-template');
    const addButton = document.getElementById('add-item');
    const countDisplay = document.getElementById('item-count');
    const vatSelect = document.getElementById('vat_rate');
    const form = document.getElementById('offer-form');

    const money = value => new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: 'TRY'
    }).format(value);

    const items = () => [...container.querySelectorAll('.offer-item')];

    function renumber() {
        items().forEach((item, index) => {
            item.querySelector('.item-heading').textContent = `Kalem ${index + 1}`;

            item.querySelectorAll('[data-field]').forEach(input => {
                const field = input.dataset.field;

                if (field === 'line_total') return;

                input.name = `items[${index}][${field}]`;
            });
        });

        countDisplay.textContent = `${items().length} / 25 kalem`;
        addButton.disabled = items().length >= 25;
        addButton.classList.toggle('opacity-50', addButton.disabled);
        addButton.classList.toggle('cursor-not-allowed', addButton.disabled);
    }

    function calculate() {
        let subtotal = 0;

        items().forEach(item => {
            const quantity = Number(item.querySelector('[data-field="quantity"]').value) || 0;
            const price = Number(item.querySelector('[data-field="unit_price"]').value) || 0;
            const lineTotal = Math.round((quantity * price + Number.EPSILON) * 100) / 100;

            subtotal += lineTotal;
            item.querySelector('[data-field="line_total"]').textContent = money(lineTotal);
        });

        subtotal = Math.round((subtotal + Number.EPSILON) * 100) / 100;

        const vatRate = Number(vatSelect.value) || 0;
        const vat = Math.round((subtotal * vatRate / 100 + Number.EPSILON) * 100) / 100;
        const total = Math.round((subtotal + vat + Number.EPSILON) * 100) / 100;

        document.getElementById('subtotal-display').textContent = money(subtotal);
        document.getElementById('vat-display').textContent = money(vat);
        document.getElementById('grand-total-display').textContent = money(total);
    }

    function addItem(values = {}) {
        if (items().length >= 25) return;

        const fragment = template.content.cloneNode(true);
        const item = fragment.querySelector('.offer-item');

        Object.entries(values).forEach(([field, value]) => {
            const input = item.querySelector(`[data-field="${field}"]`);
            if (input) input.value = value;
        });

        item.querySelector('.remove-item').addEventListener('click', () => {
            if (items().length <= 1) {
                item.querySelector('[data-field="description"]').value = '';
                item.querySelector('[data-field="quantity"]').value = '1';
                item.querySelector('[data-field="unit_price"]').value = '0';
            } else {
                item.remove();
            }

            renumber();
            calculate();
        });

        item.addEventListener('input', calculate);
        item.addEventListener('change', calculate);

        container.appendChild(fragment);
        renumber();
        calculate();
    }

    addButton.addEventListener('click', () => addItem());
    vatSelect.addEventListener('change', calculate);

    form.addEventListener('submit', event => {
        if (items().length < 1 || items().length > 25) {
            event.preventDefault();
            alert('En az 1, en fazla 25 teklif kalemi ekleyebilirsiniz.');
        }
    });

    const oldItems = window.oldOfferItems || [];
    if (Array.isArray(oldItems) && oldItems.length) {
        oldItems.slice(0, 25).forEach(item => addItem(item));
    } else {
        addItem();
    }
})();


window.exportOfferToExcel = function () {
    const table = document.querySelector('table');

    if (!table || !window.offerPdfData) {
        alert('Teklif bilgileri bulunamadı.');
        return;
    }

    const data = window.offerPdfData;
    const rows = [...table.querySelectorAll('tr')];

    const escapeHtml = value =>
        String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[char]));

    const cellText = cell =>
        escapeHtml(cell.innerText.trim());

    const tableRows = rows.map((row, index) => {
        const cells = [...row.querySelectorAll('th, td')];

        return `<tr>${cells.map((cell, i) => `
            <${index === 0 ? 'th' : 'td'}
                style="border:1px solid #d1d5db;
                padding:10px;
                font-size:11pt;
                ${index === 0
            ? 'background:#263746;color:#ffffff;font-weight:bold;'
            : 'background:#ffffff;color:#222222;'}
                ${i >= 2 ? 'text-align:right;' : 'text-align:left;'}">
                ${cellText(cell)}
            </${index === 0 ? 'th' : 'td'}>
        `).join('')}</tr>`;
    }).join('');

    const html = `
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #263746;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                table-layout: auto;
            }
            td, th {
                border: 1px solid #d1d5db;
                padding: 10px;
                font-size: 11pt;
            }
            .title {
                font-size: 22pt;
                font-weight: bold;
                color: #263746;
            }
            .label {
                font-weight: bold;
                background: #f3f4f6;
            }
            .total {
                font-weight: bold;
                background: #fce8e8;
                color: #b91c1c;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td colspan="5" class="title">Artline Traffic | Teklif Formu</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td class="label">Teklif No</td>
                <td colspan="4">${escapeHtml(data.offerNumber)}</td>
            </tr>
            <tr>
                <td class="label">Müşteri</td>
                <td colspan="4">${escapeHtml(data.customerName)}</td>
            </tr>
            <tr><td colspan="5"></td></tr>
        </table>

        <table>
            ${tableRows}
        </table>

        <br>

        <table>
            <tr>
                <td colspan="3"></td>
                <td class="label">Ara Toplam</td>
                <td>${escapeHtml(data.subtotal)} ₺</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="label">KDV</td>
                <td>${escapeHtml(data.vatAmount)} ₺</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="total">GENEL TOPLAM</td>
                <td class="total">${escapeHtml(data.grandTotal)} ₺</td>
            </tr>
        </table>
    </body>
    </html>`;

    const blob = new Blob(
        ['\ufeff', html],
        { type: 'application/vnd.ms-excel;charset=utf-8;' }
    );

    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');

    link.href = url;
    link.download = data.offerNumber + '.xls';
    document.body.appendChild(link);
    link.click();
    link.remove();

    setTimeout(() => URL.revokeObjectURL(url), 1000);
};

window.exportOfferToExcel = exportOfferToExcel;
