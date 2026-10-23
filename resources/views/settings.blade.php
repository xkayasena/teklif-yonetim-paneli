
@extends('layouts.app')

@section('title', 'Ayarlar | Artline Traffic')
@section('page-title', 'Ayarlar')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}"
              class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900">Hesap Bilgileri</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Adınızı ve e-posta adresinizi buradan güncelleyebilirsiniz.
                </p>

                <div class="mt-6 space-y-5">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                            Ad Soyad
                        </label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name', auth()->user()->name) }}"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700/10">
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                            E-posta Adresi
                        </label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               required
                               autocomplete="email"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700/10">
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900">Şifre Değiştir</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Şifrenizi değiştirmek istemiyorsanız bu alanları boş bırakın.
                </p>

                <div class="mt-6 space-y-5">
                    <div>
                        <label for="current_password" class="mb-2 block text-sm font-medium text-gray-700">
                            Mevcut Şifre
                        </label>
                        <input id="current_password" name="current_password"
                               type="password" autocomplete="current-password"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700/10">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                            Yeni Şifre
                        </label>
                        <input id="password" name="password" type="password"
                               autocomplete="new-password"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700/10">
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">
                            Yeni Şifre Tekrarı
                        </label>
                        <input id="password_confirmation" name="password_confirmation"
                               type="password" autocomplete="new-password"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700/10">
                    </div>
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit"
                        class="rounded-lg bg-[#2a3439] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#3b484e]">
                    Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>
@endsection
