(()=>{const s=document.getElementById("items-container");if(!s)return;const d=document.getElementById("item-template"),c=document.getElementById("add-item"),i=document.getElementById("item-count"),y=document.getElementById("vat_rate"),g=document.getElementById("offer-form"),f=t=>new Intl.NumberFormat("tr-TR",{style:"currency",currency:"TRY"}).format(t),o=()=>[...s.querySelectorAll(".offer-item")];function m(){o().forEach((t,r)=>{t.querySelector(".item-heading").textContent=`Kalem ${r+1}`,t.querySelectorAll("[data-field]").forEach(e=>{const u=e.dataset.field;u!=="line_total"&&(e.name=`items[${r}][${u}]`)})}),i.textContent=`${o().length} / 25 kalem`,c.disabled=o().length>=25,c.classList.toggle("opacity-50",c.disabled),c.classList.toggle("cursor-not-allowed",c.disabled)}function l(){let t=0;o().forEach(b=>{const p=Number(b.querySelector('[data-field="quantity"]').value)||0,E=Number(b.querySelector('[data-field="unit_price"]').value)||0,h=Math.round((p*E+Number.EPSILON)*100)/100;t+=h,b.querySelector('[data-field="line_total"]').textContent=f(h)}),t=Math.round((t+Number.EPSILON)*100)/100;const r=Number(y.value)||0,e=Math.round((t*r/100+Number.EPSILON)*100)/100,u=Math.round((t+e+Number.EPSILON)*100)/100;document.getElementById("subtotal-display").textContent=f(t),document.getElementById("vat-display").textContent=f(e),document.getElementById("grand-total-display").textContent=f(u)}function n(t={}){if(o().length>=25)return;const r=d.content.cloneNode(!0),e=r.querySelector(".offer-item");Object.entries(t).forEach(([u,b])=>{const p=e.querySelector(`[data-field="${u}"]`);p&&(p.value=b)}),e.querySelector(".remove-item").addEventListener("click",()=>{o().length<=1?(e.querySelector('[data-field="description"]').value="",e.querySelector('[data-field="quantity"]').value="1",e.querySelector('[data-field="unit_price"]').value="0"):e.remove(),m(),l()}),e.addEventListener("input",l),e.addEventListener("change",l),s.appendChild(r),m(),l()}c.addEventListener("click",()=>n()),y.addEventListener("change",l),g.addEventListener("submit",t=>{(o().length<1||o().length>25)&&(t.preventDefault(),alert("En az 1, en fazla 25 teklif kalemi ekleyebilirsiniz."))});const a=window.oldOfferItems||[];Array.isArray(a)&&a.length?a.slice(0,25).forEach(t=>n(t)):n()})();window.exportOfferToExcel=function(){const s=document.querySelector("table");if(!s||!window.offerPdfData){alert("Teklif bilgileri bulunamadı.");return}const d=window.offerPdfData,c=[...s.querySelectorAll("tr")],i=n=>String(n??"").replace(/[&<>"']/g,a=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"})[a]),y=n=>i(n.innerText.trim()),g=c.map((n,a)=>`<tr>${[...n.querySelectorAll("th, td")].map((r,e)=>`
            <${a===0?"th":"td"}
                style="border:1px solid #d1d5db;
                padding:10px;
                font-size:11pt;
                ${a===0?"background:#263746;color:#ffffff;font-weight:bold;":"background:#ffffff;color:#222222;"}
                ${e>=2?"text-align:right;":"text-align:left;"}">
                ${y(r)}
            </${a===0?"th":"td"}>
        `).join("")}</tr>`).join(""),f=`
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
                <td colspan="4">${i(d.offerNumber)}</td>
            </tr>
            <tr>
                <td class="label">Müşteri</td>
                <td colspan="4">${i(d.customerName)}</td>
            </tr>
            <tr><td colspan="5"></td></tr>
        </table>

        <table>
            ${g}
        </table>

        <br>

        <table>
            <tr>
                <td colspan="3"></td>
                <td class="label">Ara Toplam</td>
                <td>${i(d.subtotal)} ₺</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="label">KDV</td>
                <td>${i(d.vatAmount)} ₺</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="total">GENEL TOPLAM</td>
                <td class="total">${i(d.grandTotal)} ₺</td>
            </tr>
        </table>
    </body>
    </html>`,o=new Blob(["\uFEFF",f],{type:"application/vnd.ms-excel;charset=utf-8;"}),m=URL.createObjectURL(o),l=document.createElement("a");l.href=m,l.download=d.offerNumber+".xls",document.body.appendChild(l),l.click(),l.remove(),setTimeout(()=>URL.revokeObjectURL(m),1e3)};window.exportOfferToExcel=exportOfferToExcel;
