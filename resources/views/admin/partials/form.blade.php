<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ $title }}
        </h2>

        @isset($description)
            <p class="text-sm text-gray-500 mt-1">
                {{ $description }}
            </p>
        @endisset
    </div>

    <form method="POST" action="{{ $action }}">
    @csrf
    {{ $method ?? '' }}

    <div class="grid grid-cols-1 gap-5">
        @stack('form-fields')
    </div>

    <div class="mt-8 flex justify-end gap-3">
        <a href="{{ $cancel ?? url()->previous() }}"
           class="px-4 py-2 text-sm rounded-lg border text-gray-700">
            Cancelar
        </a>

        <button type="submit"
            class="px-4 py-2 text-sm rounded-lg bg-gray-900 text-white">
            Guardar
        </button>
    </div>
</form>

</div>
