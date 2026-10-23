
@extends('layouts.app')

@section('title', 'Teklif Arşivi | İş Yönetim Sistemi')
@section('page-title', 'Teklif Arşivi')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">Teklif Arşivi</h2>
                <p class="mt-1 text-sm text-gray-500">Hazırladığınız teklifleri görüntüleyin.</p>
            </div>
            <a href="{{ route('offers.create') }}"
               class="rounded-lg bg-gray-900 px-4 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-800">
                + Teklif Oluştur
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">
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
                    @forelse ($offers as $offer)
                        <tr class="hover:bg-gray-50">
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
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('offers.show', $offer) }}"
                                       class="font-medium text-blue-600 hover:text-blue-800">
                                        Görüntüle
                                    </a>

                                    <button
                                        type="button"
                                        data-delete-url="{{ route('offers.destroy', $offer) }}"
                                        data-delete-name="{{ $offer->offer_number }}"
                                        class="font-medium text-red-600 hover:text-red-800">
                                        Sil
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <p class="font-medium text-gray-900">Henüz teklif bulunmuyor.</p>
                                <p class="mt-1 text-sm text-gray-500">İlk teklifinizi oluşturmak için Teklif Oluştur butonunu kullanın.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if ($offers->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $offers->links() }}
                </div>
            @endif
        </div>
    </div>

    <x-delete-modal />
@endsection
