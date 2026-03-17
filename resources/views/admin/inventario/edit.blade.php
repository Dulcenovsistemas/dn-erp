@php
    $soloLectura = !auth()->user()->hasRole('admin');
@endphp

@extends('layouts.admin.app')
@section('title', 'Inventario')
@section('content')

<div class="mb-6">
    <h1 class="text-xl font-semibold">
        Inventario – {{ $sucursal->nombre }}
    </h1>
    <p class="text-sm text-gray-500">
        Precios y stock por variante
    </p>
</div>

@php
    use Illuminate\Support\Str;

    $variantesPorCategoria = $variantes->groupBy(function ($variante) {
        return $variante->producto->categoria->nombre ?? 'Sin categoría';
    });
@endphp

<form method="POST"
      action="{{ route('admin.sucursales.inventario.update', $sucursal) }}">
    @csrf

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Producto</th>
                    <th class="px-6 py-4 text-left">Variante</th>
                    <th class="px-6 py-4 text-center">Precio</th>
                    <th class="px-6 py-4 text-center">Stock</th>
                    <th class="px-6 py-4 text-center">Activo</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            @foreach ($variantesPorCategoria as $categoria => $listaVariantes)

                {{-- Header de categoría --}}
                <tr class="bg-gray-100 cursor-pointer"
                    onclick="toggleCategoria('{{ Str::slug($categoria) }}')">
                    <td colspan="5" class="px-6 py-3 font-semibold text-gray-800 flex items-center justify-between">
                        <span>{{ $categoria }}</span>
                        <span id="icon-{{ Str::slug($categoria) }}" class="transition">
                            ▼
                        </span>
                    </td>
                </tr>

                {{-- Variantes --}}
                @foreach ($listaVariantes as $variante)
                    @php
                        $pivot = $inventario[$variante->id]->pivot ?? null;
                    @endphp

                    <tr class="categoria-{{ Str::slug($categoria) }} hover:bg-gray-50 hidden">
                        <td class="px-6 py-3">
                            {{ $variante->producto->nombre }}
                        </td>

                        <td class="px-6 py-3 text-gray-600">
                            {{ $variante->nombre }}
                        </td>

                        <td class="px-6 py-3 text-center">
                            <input type="number"
                                step="0.01"
                                min="0"
                                name="variantes[{{ $variante->id }}][precio]"
                                value="{{ $pivot->precio ?? 0 }}"
                                class="w-24 rounded border-gray-300 text-center"
                                 {{ $soloLectura ? 'disabled' : '' }}>
                        </td>

                        <td class="px-6 py-3 text-center">
                            <input type="number"
                                min="0"
                                name="variantes[{{ $variante->id }}][stock]"
                                value="{{ $pivot->stock ?? 0 }}"
                                class="w-20 rounded border-gray-300 text-center"
                                 {{ $soloLectura ? 'disabled' : '' }}>
                        </td>

                        <td class="px-6 py-3 text-center">
                            <input type="checkbox"
                                name="variantes[{{ $variante->id }}][activo]"
                                {{ ($pivot->activo ?? false) ? 'checked' : '' }}
                                {{ $soloLectura ? 'disabled' : '' }}>
                        </td>
                    </tr>
                @endforeach

            @endforeach

            </tbody>

        </table>
    </div>

    @role('admin')
    <div class="flex justify-end mt-6">
        <button type="submit"
                class="px-5 py-2 bg-gray-900 text-white rounded-lg text-sm">
            Guardar inventario
        </button>
    </div>
    @endrole
</form>
<script>
    function toggleCategoria(slug) {
        const rows = document.querySelectorAll('.categoria-' + slug);
        const icon = document.getElementById('icon-' + slug);

        rows.forEach(row => {
            row.classList.toggle('hidden');
        });

        icon.classList.toggle('rotate-180');
    }
</script>

@endsection
