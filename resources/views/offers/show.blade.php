
@extends('layouts.app')

@section('title', 'Teklif Detayı | İş Yönetim Sistemi')
@section('page-title', 'Teklif Detayı')

@section('content')
    <script>
        window.offerPdfData = {{ Illuminate\Support\Js::from([
        'customerName' => $offer->customer?->full_name ?? 'Müşteri silinmiş',
        'offerNumber' => $offer->offer_number,
        'subtotal' => number_format((float) $offer->subtotal, 2, ',', '.'),
        'vatAmount' => number_format((float) $offer->vat_amount, 2, ',', '.'),
        'grandTotal' => number_format((float) $offer->grand_total, 2, ',', '.')
        ]) }};
    </script>

    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3 print:hidden">
            <a href="{{ route('offers.index') }}"
               class="text-sm font-medium text-gray-600 hover:text-gray-900">
                ← Teklif Arşivine Dön
            </a>

            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="window.print()"
                        style="background:#111827;color:white;"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium hover:opacity-90">
                    Yazdır
                </button>

                <a href="{{ route('offers.pdf', $offer) }}"
                   style="background:#dc2626;color:white;"
                   class="inline-block rounded-lg px-4 py-2.5 text-sm font-medium hover:opacity-90">
                    PDF İndir
                </a>

                <button type="button" onclick="exportOfferToExcel()"
                        style="background:#15803d;color:white;"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium hover:opacity-90">
                    Excel
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 print:hidden">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-10 print:border-0 print:p-0 print:shadow-none">
            <div class="flex flex-col justify-between gap-6 border-b border-gray-200 pb-6 sm:flex-row">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">ARTLINE TRAFFIC</h1>
                </div>
                <div class="sm:text-right">
                    <p class="text-sm text-gray-500">Teklif Tarihi</p>
                    <p class="mt-1 font-medium text-gray-900">{{ $offer->offer_date->format('d.m.Y') }}</p>
                </div>
            </div>

            <div class="py-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Müşteri</p>
                <h2 class="mt-2 text-lg font-semibold text-gray-900">
                    {{ $offer->customer?->full_name ?? 'Müşteri silinmiş' }}
                </h2>
                @if ($offer->customer?->company_name)
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $offer->customer->company_name }}
                    </p>
                @endif

                @if ($offer->customer?->phone)
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $offer->customer->phone }}
                    </p>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-left text-sm">
                    <thead class="border-y border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 font-semibold text-gray-600">Kalem</th>
                        <th class="px-3 py-3 font-semibold text-gray-600">Birim</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">Miktar</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">Birim Fiyat</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">Tutar</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach ($offer->items as $item)
                        <tr>
                            <td class="px-3 py-4 text-gray-900">{{ $item->description }}</td>
                            <td class="px-3 py-4 text-gray-600">{{ $item->unit }}</td>
                            <td class="px-3 py-4 text-right text-gray-600">{{ number_format((float) $item->quantity, 3, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-right text-gray-600">{{ number_format((float) $item->unit_price, 2, ',', '.') }} ₺</td>
                            <td class="whitespace-nowrap px-3 py-4 text-right font-medium text-gray-900">{{ number_format((float) $item->line_total, 2, ',', '.') }} ₺</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="ml-auto mt-6 w-full space-y-3 sm:max-w-sm">
                <div class="flex justify-between gap-4 text-sm text-gray-600">
                    <span>Ara toplam</span>
                    <span>{{ number_format((float) $offer->subtotal, 2, ',', '.') }} ₺</span>
                </div>
                <div class="flex justify-between gap-4 text-sm text-gray-600">
                    <span>KDV (%{{ number_format((float) $offer->vat_rate, 2, ',', '.') }})</span>
                    <span>{{ number_format((float) $offer->vat_amount, 2, ',', '.') }} ₺</span>
                </div>
                <div class="flex justify-between gap-4 border-t border-gray-200 pt-4">
                    <span class="font-semibold text-gray-900">Genel Toplam</span>
                    <span class="text-xl font-bold text-gray-900">{{ number_format((float) $offer->grand_total, 2, ',', '.') }} ₺</span>
                </div>
            </div>

            <div class="mt-10 border-t border-gray-200 pt-4 text-xs text-gray-400">
                Bu teklif, belirtilen kalem ve fiyat bilgilerine göre hazırlanmıştır.
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 15mm 12mm;
            }

            body {
                background: #ffffff !important;
                color: #263238 !important;
                font-family: Arial, sans-serif !important;
                font-size: 10px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body * {
                visibility: hidden;
            }

            main,
            main * {
                visibility: visible;
            }

            main {
                position: absolute !important;
                inset: 0 !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .print\:hidden,
            button,
            a[href*="/offers"],
            nav,
            aside {
                display: none !important;
            }

            main > div {
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            main > div > div {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }

            h1 {
                color: #18212b !important;
                font-size: 24px !important;
                font-weight: 700 !important;
            }

            h2 {
                color: #18212b !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            thead {
                background: #eef0f3 !important;
            }

            thead th {
                background: #eef0f3 !important;
                color: #263238 !important;
                border-top: 1px solid #d8dde3 !important;
                border-bottom: 1px solid #d8dde3 !important;
                padding: 10px 8px !important;
            }

            tbody td {
                border-bottom: 1px solid #e5e7eb !important;
                padding: 10px 8px !important;
            }

            tr {
                break-inside: avoid;
            }

            /* Genel toplamı Artline kırmızısıyla göster */
            .print-grand-total {
                background: #c8102e !important;
                color: #ffffff !important;
                padding: 10px !important;
                font-weight: 700 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

    @push('scripts')
        @vite(['resources/js/offer.js'])
    @endpush
@endsection
