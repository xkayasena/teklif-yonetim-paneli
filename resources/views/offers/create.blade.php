@extends('layouts.app')

@section('title', 'Teklif Oluştur | İş Yönetim Sistemi')
@section('page-title', 'Teklif Oluştur')

@section('content')
    <div class="mx-auto max-w-7xl">

        <div class="mb-5">
            <h2 class="text-2xl font-semibold text-gray-900">Teklif Oluştur</h2>
            <p class="mt-1 text-sm text-gray-500">Müşteri ve teklif kalemlerini girerek yeni teklif hazırlayın.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Formda kontrol edilmesi gereken alanlar var:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('offers.store') }}" id="offer-form" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            @csrf

            <section class="border-b border-gray-200 px-5 py-5 sm:px-7 sm:py-6">
                <h3 class="text-base font-semibold text-gray-900">Teklif Bilgileri</h3>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="customer_id" class="mb-2 block text-sm font-medium text-gray-700">Müşteri *</label>
                        <select id="customer_id" name="customer_id" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="">Müşteri seçin</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->full_name }}{{ $customer->company_name ? ' — '.$customer->company_name : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($customers->isEmpty())
                            <p class="mt-2 text-sm text-red-600">Teklif oluşturmak için önce müşteri kaydetmelisiniz.</p>
                        @endif
                    </div>

                    <div>
                        <label for="offer_date" class="mb-2 block text-sm font-medium text-gray-700">Teklif Tarihi *</label>
                        <input type="date" id="offer_date" name="offer_date"
                               value="{{ old('offer_date', now()->format('Y-m-d')) }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>
            </section>

            <section class="border-b border-gray-200">
                <div class="flex flex-col gap-3 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Teklif Kalemleri</h3>
                        <p class="mt-1 text-sm text-gray-500">En fazla 25 kalem ekleyebilirsiniz. Tutarlar otomatik hesaplanır.</p>
                    </div>
                    <span id="item-count" class="text-sm text-gray-500">1 / 25 kalem</span>
                </div>

                <div id="items-container" class="px-5 sm:px-7"></div>

                <div class="border-t border-gray-100 px-5 py-4 sm:px-7">
                    <button type="button" id="add-item"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-blue-300 disabled:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Kalem Ekle
                    </button>
                </div>
            </section>

            <section class="border-b border-gray-200 px-5 py-5 sm:px-7 sm:py-6">
                <h3 class="text-base font-semibold text-gray-900">Teklif Özeti</h3>

                <div class="mt-4 grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div>
                        <label for="vat_rate" class="mb-2 block text-sm font-medium text-gray-700">KDV Oranı</label>
                        <select id="vat_rate" name="vat_rate"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="0" @selected(old('vat_rate', '20') == '0')>%0</option>
                            <option value="10" @selected(old('vat_rate', '20') == '10')>%10</option>
                            <option value="20" @selected(old('vat_rate', '20') == '20')>%20</option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500">Varsayılan oran %20'dir. Oran tüm kalemlere uygulanır.</p>
                    </div>

                    <div class="space-y-3 rounded-lg bg-gray-50 p-4">
                        <div class="flex justify-between gap-4 text-sm text-gray-600">
                            <span>Ara toplam</span>
                            <span id="subtotal-display" class="font-medium text-gray-900">0,00 ₺</span>
                        </div>
                        <div class="flex justify-between gap-4 text-sm text-gray-600">
                            <span>KDV tutarı</span>
                            <span id="vat-display" class="font-medium text-gray-900">0,00 ₺</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="font-semibold text-gray-900">Genel Toplam</span>
                                <span id="grand-total-display" class="text-xl font-bold text-gray-900">0,00 ₺</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="flex flex-col-reverse justify-end gap-3 bg-gray-50 px-5 py-4 sm:flex-row sm:px-7">
                <a href="{{ route('offers.index') }}"
                   class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Vazgeç
                </a>
                <button type="submit" @disabled($customers->isEmpty())
                class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50">
                    Teklifi Kaydet
                </button>
            </div>
        </form>
    </div>

    <template id="item-template">
        <div class="offer-item border-b border-gray-200 py-5 last:border-b-0">
            <div class="mb-3 flex items-center justify-between">
                <h4 class="item-heading text-sm font-semibold text-gray-900">Kalem</h4>
                <button type="button" class="remove-item inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:border-red-300 hover:bg-red-100 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 6h18M8 6V4h8v2m-9 0 1 14h8l1-14M10 11v5m4-5v5"/>
                    </svg>
                    Kalemi Sil
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-12">
                <div class="lg:col-span-3">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Kalem Açıklaması *</label>
                    <input data-field="description" type="text" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Birim *</label>
                    <select data-field="unit" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="m²">m²</option>
                        <option value="adet">Adet</option>
                        <option value="metre">Metre</option>
                        <option value="kg">Kg</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Metraj / Adet *</label>
                    <input data-field="quantity" type="number" min="0.001" max="999999999" step="0.001" value="1" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Birim Fiyat (₺) *</label>
                    <input data-field="unit_price" type="number" min="0" max="999999999999" step="0.01" value="0" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div class="lg:col-span-3">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Kalem Toplamı</label>
                    <div data-field="line_total" class="rounded-lg bg-gray-50 px-3 py-2.5 text-sm font-semibold text-gray-900">0,00 ₺</div>
                </div>
            </div>
        </div>
    </template>

    @push('scripts')
        @vite(['resources/js/offer.js'])
    @endpush
@endsection

