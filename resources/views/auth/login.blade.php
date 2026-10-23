@extends('layouts.auth')

@section('title', 'Giriş | Artline Traffic')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-[#f3f5f6] px-5 py-10">
        <div class="w-full max-w-[440px]">

            {{-- Marka --}}

            {{-- Giriş kartı --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-7 shadow-[0_12px_40px_rgba(42,52,57,0.08)] sm:p-10">

                <div class="mb-8">
                    <div class="text-center">
                        <img src="{{ asset('img/logo.webp') }}" alt="Artline Traffic" class="mx-auto h-auto w-full max-w-[260px] object-contain">
                    </div>

                    <p class="text-sm leading-6 text-gray-500">
                        Yönetim panelinize erişmek için hesabınızla giriş yapın.
                    </p>
                </div>

                <x-errors />

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-[#2a3439]">
                            E-posta adresi
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ornek@artlinetraffic.com"
                            autocomplete="username"
                            required
                            autofocus
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3.5 text-sm text-[#2a3439] outline-none transition placeholder:text-gray-400 focus:border-[#2a3439] focus:ring-2 focus:ring-[#2a3439]/10"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-[#2a3439]">
                            Şifre
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Şifrenizi girin"
                            autocomplete="current-password"
                            required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3.5 text-sm text-[#2a3439] outline-none transition placeholder:text-gray-400 focus:border-[#2a3439] focus:ring-2 focus:ring-[#2a3439]/10"
                        >
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-gray-600">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 accent-[#2a3439]"
                            >
                            Beni hatırla
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#2a3439] px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#3b484e] focus:outline-none focus:ring-2 focus:ring-[#2a3439] focus:ring-offset-2 active:scale-[0.99]"
                    >
                        Giriş Yap
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
