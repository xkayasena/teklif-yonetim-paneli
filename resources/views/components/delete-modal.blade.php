@props([
    'action' => 'Sil',
    'title' => 'Silme İşlemi',
    'message' => 'adlı kaydı silmek istediğinize emin misiniz?',
    'warning' => 'Bu işlem geri alınamaz.',
    'method' => 'DELETE',
    'buttonClass' => 'bg-red-600 hover:bg-red-700',
    'warningClass' => 'text-red-600',
])

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-xl bg-white shadow-xl">

        <div class="border-b border-gray-200 px-6 py-5">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        </div>

        <div class="px-6 py-5">
            <p class="text-sm leading-6 text-gray-600">
                <span id="deleteItemName" class="font-semibold text-gray-900"></span>
                {{ $message }}
            </p>

            <p class="mt-2 text-sm {{ $warningClass }}">
                {{ $warning }}
            </p>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4">
            <button type="button" id="cancelDelete" class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                Vazgeç
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method($method)

                <button type="submit" class="cursor-pointer rounded-lg px-4 py-2.5 text-sm font-medium text-white transition {{ $buttonClass }}">
                    {{ $action }}
                </button>
            </form>
        </div>
    </div>
</div>
