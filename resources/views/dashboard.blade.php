@extends('layouts.app')

@section('title', 'Anasayfa | İş Yönetim Sistemi')
@section('page-title', 'Anasayfa')

@section('content')
    <div class="space-y-6">

        {{-- İstatistikler --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div class="flex min-h-36 flex-col justify-between rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-gray-500">Toplam Müşteri</p>
                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $customerCount }}
                    </p>
                </div>
                <p class="mt-3 text-sm text-gray-400">Kayıtlı müşteri</p>
            </div>

            <div class="flex min-h-36 flex-col justify-between rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-gray-500">Toplam Teklif</p>
                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $offerCount }}
                    </p>
                </div>
                <p class="mt-3 text-sm text-gray-400">Oluşturulan teklifler</p>
            </div>

        </div>

        {{-- Son Teklifler --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Son Teklifler</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        En son oluşturulan teklifleriniz.
                    </p>
                </div>

                <a href="{{ route('offers.index') }}"
                   class="text-sm font-medium text-gray-700 transition hover:text-red-600">
                    Tüm teklifleri görüntüle →
                </a>
            </div>

            @if ($recentOffers->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[650px] text-left text-sm">
                        <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-medium">Teklif No</th>
                            <th class="px-6 py-4 font-medium">Müşteri</th>
                            <th class="px-6 py-4 font-medium">Tarih</th>
                            <th class="px-6 py-4 text-right font-medium">Genel Toplam</th>
                            <th class="px-6 py-4 text-center font-medium">İşlem</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach ($recentOffers as $offer)
                            <tr class="transition hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                    {{ $offer->offer_number }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $offer->customer?->full_name ?? 'Müşteri silinmiş' }}
                                    @if ($offer->customer?->company_name)
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $offer->customer->company_name }}
                                        </p>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                    {{ $offer->offer_date->format('d.m.Y') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-gray-900">
                                    {{ number_format((float) $offer->grand_total, 2, ',', '.') }} ₺
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('offers.show', $offer) }}"
                                       class="font-medium text-blue-600 hover:text-blue-800">
                                        Görüntüle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <p class="font-medium text-gray-700">Henüz bir teklif bulunmuyor.</p>
                    <p class="mt-1 text-sm text-gray-500">
                        İlk teklifinizi oluşturarak burada görüntüleyebilirsiniz.
                    </p>
                    <a href="{{ route('offers.create') }}"
                       class="mt-4 inline-flex rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                        + Teklif Oluştur
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
