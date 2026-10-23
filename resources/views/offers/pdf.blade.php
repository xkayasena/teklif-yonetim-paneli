
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 28px 32px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #202833;
            line-height: 1.5;
        }

        table {
            border-collapse: collapse;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #c8102e;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }

        .header td {
            vertical-align: middle;
        }

        .logo {
            width: 185px;
            max-height: 65px;
        }

        .title {
            font-size: 23px;
            font-weight: bold;
            text-align: right;
            color: #111827;
        }

        .meta {
            text-align: right;
            color: #536174;
            font-size: 9px;
            line-height: 1.8;
        }

        .section-title {
            color: #c8102e;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 12px 0 0;
        }

        .info-box {
            background: #f5f6f8;
            border: 1px solid #e1e5ea;
            padding: 11px;
        }

        .customer-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .muted {
            color: #586579;
        }

        .items-title {
            margin-bottom: 7px;
        }

        .items {
            width: 100%;
            margin-bottom: 16px;
        }

        .items th {
            background: #e9edf1;
            color: #202833;
            text-align: left;
            font-size: 8px;
            padding: 9px 7px;
            border-top: 1px solid #d4dbe3;
            border-bottom: 1px solid #d4dbe3;
        }

        .items td {
            padding: 10px 7px;
            border-bottom: 1px solid #e3e7ec;
            vertical-align: top;
        }

        .right {
            text-align: right !important;
        }

        .center {
            text-align: center !important;
        }

        .totals {
            width: 56%;
            margin-left: auto;
            margin-bottom: 20px;
        }

        .totals td {
            padding: 6px 8px;
        }

        .total-label {
            color: #536174;
        }

        .grand-total td {
            background: #c8102e;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            padding: 10px 9px;
        }

        .footer {
            width: 100%;
            background-color: #202833;
            color: #ffffff;
            border-collapse: collapse;
            margin-top: 22px;
        }

        .footer td {
            padding: 0;
            vertical-align: middle;
        }

        .footer-logo-cell {
            width: 42%;
            padding: 12px 16px !important;
        }

        .footer-logo {
            width: 135px;
            height: auto;
        }

        .footer-road-cell {
            width: 58%;
            height: 75px;
            padding: 0 !important;
            overflow: hidden;
            background-color: #202833;
        }

        .road-background {
            position: relative;
            width: 100%;
            height: 75px;
            overflow: hidden;
            background: #202833;
        }

        .road-background::before {
            content: "";
            position: absolute;
            top: -65px;
            right: -15px;
            width: 230px;
            height: 190px;
            background: #344253;
            transform: rotate(-42deg);
        }

        .road-background::after {
            content: "";
            position: absolute;
            top: -30px;
            right: 72px;
            width: 5px;
            height: 140px;
            background: #dfe5eb;
            transform: rotate(42deg);
        }

        .road-dash {
            position: absolute;
            z-index: 2;
            top: -20px;
            right: 43px;
            width: 4px;
            height: 125px;
            background: repeating-linear-gradient(
                to bottom,
                #ffffff 0 10px,
                transparent 10px 20px
            );
            transform: rotate(42deg);
        }

        .road-red {
            position: absolute;
            z-index: 3;
            top: -20px;
            right: 12px;
            width: 12px;
            height: 125px;
            background: #c8102e;
            transform: rotate(42deg);
        }

        .footer-note {
            color: #e1e5ea;
            font-size: 8px;
            text-align: right;
            padding: 6px 12px;
        }

        .footer-sub {
            color: #d2d8e0;
            font-size: 8px;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        .small-note {
            color: #657286;
            font-size: 8px;
            margin-top: 12px;
        }
    </style>
</head>
<body>

<table class="header">
    <tr>
        <td style="width: 55%;">
            <img
                class="logo"
                src="{{ public_path('img/logo.webp') }}"
                alt="Artline Traffic"
            >
        </td>
        <td style="width: 45%;">
            <div class="title">TEKLİF FORMU</div>
            <div class="meta">
                Teklif No: <strong>{{ $offer->offer_number }}</strong><br>
                Tarih: <strong>{{ $offer->offer_date->format('d.m.Y') }}</strong>
            </div>
        </td>
    </tr>
</table>

<table class="info-table">
    <tr>
        <td>
            <div class="info-box">
                <div class="section-title">Müşteri Bilgileri</div>
                <div class="customer-name">
                    {{ $offer->customer->full_name }}
                </div>

                @if ($offer->customer->company_name)
                    <div>{{ $offer->customer->company_name }}</div>
                @endif

                @if ($offer->customer->phone)
                    <div class="muted">
                        Telefon: {{ $offer->customer->phone }}
                    </div>
                @endif
            </div>
        </td>
        <td>
            <div class="info-box">
                <div class="section-title">Teklif Bilgileri</div>
                <div>
                    <strong>Teklif No:</strong> {{ $offer->offer_number }}
                </div>
                <div>
                    <strong>Teklif Tarihi:</strong>
                    {{ $offer->offer_date->format('d.m.Y') }}
                </div>
                <div class="muted">
                    Belirtilen kalem ve fiyatları kapsar.
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="section-title items-title">Hizmet ve Fiyat Detayları</div>

<table class="items">
    <thead>
    <tr>
        <th style="width: 6%;" class="center">No</th>
        <th style="width: 34%;">İş Kalemi</th>
        <th style="width: 12%;" class="center">Miktar</th>
        <th style="width: 12%;" class="center">Birim</th>
        <th style="width: 18%;" class="right">Birim Fiyat (₺)</th>
        <th style="width: 18%;" class="right">Toplam (₺)</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($offer->items as $index => $item)
        <tr>
            <td class="center">{{ $index + 1 }}</td>
            <td>{{ $item->description }}</td>
            <td class="center">
                {{ number_format((float) $item->quantity, 3, ',', '.') }}
            </td>
            <td class="center">{{ $item->unit }}</td>
            <td class="right">
                {{ number_format((float) $item->unit_price, 2, ',', '.') }}
            </td>
            <td class="right">
                {{ number_format((float) $item->line_total, 2, ',', '.') }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="totals">
    <tr>
        <td class="total-label">Ara Toplam</td>
        <td class="right">
            {{ number_format((float) $offer->subtotal, 2, ',', '.') }} ₺
        </td>
    </tr>
    <tr>
        <td class="total-label">
            KDV (%{{ number_format((float) $offer->vat_rate, 2, ',', '.') }})
        </td>
        <td class="right">
            {{ number_format((float) $offer->vat_amount, 2, ',', '.') }} ₺
        </td>
    </tr>
    <tr class="grand-total">
        <td>GENEL TOPLAM</td>
        <td class="right">
            {{ number_format((float) $offer->grand_total, 2, ',', '.') }} ₺
        </td>
    </tr>
</table>

<table style="width:100%; border-collapse:collapse; margin-top:22px;">
    <tr>
        <td style="padding:0;">
            <img
                src="{{ public_path('img/footer.png') }}"
                style="width:100%; height:auto; display:block;"
                alt="Artline Traffic"
            >
        </td>
    </tr>
</table>

<div class="small-note">
    Bu belge teklif bilgilendirme amacıyla hazırlanmıştır.
</div>

</body>
</html>
