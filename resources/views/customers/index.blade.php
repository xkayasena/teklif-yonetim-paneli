@extends('layouts.app')

@section('title', 'Müşteriler | İş Yönetim Sistemi')

@section('page-title', 'Müşteriler')

@section('content')

    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div class="mb-3">
                <h2 class="text-2xl font-semibold text-gray-900">Müşteriler</h2>
                <p class="mt-1 text-sm text-gray-500">Sistemde kayıtlı müşterileri yönetin.</p>
            </div>

            <a href="{{ route('customers.create') }}" class="cursor-pointer rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                Yeni Müşteri
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-center font-medium">Müşteri</th>
                        <th class="px-6 py-4 text-center font-medium">Firma Ünvanı</th>
                        <th class="px-6 py-4 text-center font-medium">Telefon</th>
                        <th class="px-6 py-4 text-center font-medium">İşlemler</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                    @forelse ($customers as $customer)
                        <tr class="transition hover:bg-gray-50">

                            <td class="px-6 py-4">
                                <div class="font-medium text-center text-gray-900">
                                    {{ $customer->full_name }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $customer->company_name ?: '-' }}
                            </td>

                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $customer->phone ?: '-' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('customers.edit', $customer) }}" class="cursor-pointer text-sm font-medium text-blue-600 hover:text-blue-800">
                                        Düzenle
                                    </a>

                                    <button type="button" data-delete-url="{{ route('customers.destroy', $customer) }}" data-delete-name="{{ $customer->full_name }}" class="cursor-pointer text-sm font-medium text-red-600 hover:text-red-800">
                                        Sil
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-sm font-medium text-gray-700">Henüz müşteri bulunmuyor.</p>
                                <p class="mt-1 text-sm text-gray-500">İlk müşteriyi eklemek için yukarıdaki butonu kullanabilirsiniz.</p>
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>
            </div>

            @if ($customers->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $customers->links() }}
                </div>
            @endif

        </div>

    </div>

    <x-delete-modal />
@endsection
