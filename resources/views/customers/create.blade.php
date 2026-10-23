@extends('layouts.app')

@section('title', 'Yeni Müşteri | İş Yönetim Sistemi')

@section('page-title', 'Yeni Müşteri')

@section('content')

    <div class="max-w-4xl">

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Yeni Müşteri</h2>
            <p class="mt-1 text-sm text-gray-500">Yeni bir müşteri kaydı oluşturun.</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <form method="POST" action="{{ route('customers.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    <div class="mb-3">
                        <label for="full_name" class="mb-2 block text-sm font-medium text-gray-700">Ad Soyad</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Müşterinin adı soyadı">
                        @error('full_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="company_name" class="mb-2 block text-sm font-medium text-gray-700">
                            Firma Ünvanı <span class="text-gray-400">(İsteğe bağlı)</span>
                        </label>
                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            value="{{ old('company_name') }}"
                            maxlength="255"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            placeholder="Firma veya şirket ünvanı"
                        >
                        @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                            Telefon <span class="text-gray-400">(İsteğe bağlı)</span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" inputmode="numeric" maxlength="11" pattern="05[0-9]{9}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="05XXXXXXXXX">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-200 pt-6">
                    <a href="{{ route('customers.index') }}" class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Vazgeç
                    </a>

                    <button type="submit" class="cursor-pointer rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                        Müşteri Kaydet
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection
