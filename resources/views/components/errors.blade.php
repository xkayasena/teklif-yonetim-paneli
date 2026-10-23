
@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>
                    @switch($error)
                        @case('auth.failed')
                            E-posta adresi veya şifre hatalı. Bilgilerinizi kontrol edip tekrar deneyin.
                            @break

                        @case('validation.required')
                            Bu alan zorunludur.
                            @break

                        @default
                            {{ $error }}
                    @endswitch
                </li>
            @endforeach
        </ul>
    </div>
@endif
