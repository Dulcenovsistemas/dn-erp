<div class="bg-white rounded-xl shadow p-6 mb-6">

    <div class="grid grid-cols-4 gap-6">

        <div>

            <label>Sucursal</label>

           <label>Zona</label>

            <select
                name="zona_id"
                class="w-full rounded-lg">

                @foreach(auth()->user()->zonas as $zona)

                    <option value="{{ $zona->id }}">

                        {{ $zona->nombre }}

                    </option>

                @endforeach

            </select>

        </div>

    @php
    use Carbon\Carbon;

    $hoy = Carbon::today();

    // Encontrar el próximo jueves (o hoy si hoy es jueves)
    $fechaLimite = $hoy->copy();

    if (!$hoy->isThursday()) {
        $fechaLimite = $hoy->next(Carbon::THURSDAY);
    }

    // El pedido corresponde al lunes siguiente
    $inicioSemana = $fechaLimite->copy()->addDays(4);

    // Y termina el sábado
    $finSemana = $fechaLimite->copy()->addDays(9);
@endphp

<div>

    <label>Semana</label>

    <input
        class="w-full rounded-lg bg-gray-100"
        readonly
        value="{{ $inicioSemana->translatedFormat('d F') }} - {{ $finSemana->translatedFormat('d F') }}">

</div>
        <div>

            <label>Fecha captura</label>

            <input
                class="w-full rounded-lg bg-gray-100"
                readonly
                value="{{ now()->format('d/m/Y') }}">

        </div>

        <div>

            <label>Observaciones</label>

            <input
                name="observaciones"
                class="w-full rounded-lg">

        </div>

    </div>

</div>