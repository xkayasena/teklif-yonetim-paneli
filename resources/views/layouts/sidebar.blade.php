
<aside id="sidebar" class="sticky top-0 flex min-h-screen w-64 shrink-0 self-start flex-col overflow-hidden bg-gray-900 text-white transition-[width] duration-300">

    {{-- Logo ve daraltma düğmesi --}}
    <div class="flex min-h-[81px] shrink-0 items-center gap-2 border-b border-gray-800 px-3 py-4">
        <img src="{{ asset('img/logo_white.webp') }}" alt="Artline Traffic" class="h-auto min-w-0 flex-1 object-contain">
        <button id="sidebarToggle" type="button" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-300 transition hover:bg-gray-800 hover:text-white" aria-label="Menüyü daralt veya genişlet" title="Menüyü daralt veya genişlet" aria-expanded="true">
            <svg id="sidebarToggleIcon" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
    </div>

    {{-- Navigasyon --}}
    <nav class="flex-1 space-y-1 overflow-x-hidden overflow-y-auto px-3 py-4">
        <a href="{{ route('dashboard') }}" title="Anasayfa" class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg>
            <span class="sidebar-label whitespace-nowrap">Anasayfa</span>
        </a>
        <a href="{{ route('customers.index') }}" title="Müşteriler" class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition {{ request()->routeIs('customers.*') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-7.5a4 4 0 0 1 0 7.75M20 21v-2a4 4 0 0 0-3-3.87"/></svg>
            <span class="sidebar-label whitespace-nowrap">Müşteriler</span>
        </a>
        <a href="{{ route('offers.create') }}" title="Teklif Oluştur" class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition {{ request()->routeIs('offers.create') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
            <span class="sidebar-label whitespace-nowrap">Teklif Oluştur</span>
        </a>
        <a href="{{ route('offers.index') }}" title="Teklif Arşivi" class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition {{ request()->routeIs('offers.index') || request()->routeIs('offers.show') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="1"/><path stroke-linecap="round" d="M8 8h8v8H8z"/></svg>
            <span class="sidebar-label whitespace-nowrap">Teklif Arşivi</span>
        </a>
        <a href="{{ route('settings.edit') }}" title="Ayarlar" class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition {{ request()->routeIs('settings.*') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="m19.4 15 .1.1 1.4 1.1-1.4 2.4-1.7-.7a8 8 0 0 1-1.7 1l-.3 1.8h-2.8l-.3-1.8a8 8 0 0 1-1.7-1l-1.7.7-1.4-2.4 1.4-1.1a7 7 0 0 1 0-2l-1.4-1.1 1.4-2.4 1.7.7a8 8 0 0 1 1.7-1l.3-1.8h2.8l.3 1.8a8 8 0 0 1 1.7 1l1.7-.7 1.4 2.4-1.4 1.1a7 7 0 0 1 0 2Z"/></svg>
            <span class="sidebar-label whitespace-nowrap">Ayarlar</span>
        </a>
    </nav>

    {{-- Kullanıcı ve çıkış --}}
    <div class="shrink-0 border-t border-gray-800 p-3">
        <div class="sidebar-label mb-3 min-w-0 overflow-hidden px-2">
            <p class="whitespace-nowrap text-sm font-medium">{{ auth()->user()->name }}</p>
            <p class="truncate text-xs text-gray-400">{{ auth()->user()->email }}</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Çıkış Yap"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-800 px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-red-600 hover:text-white">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5m5 5H3m9-9h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>
                <span class="sidebar-label whitespace-nowrap">Çıkış Yap</span>
            </button>
        </form>
    </div>
</aside>
