<div class="pos">

    {{-- HEADER (opcional, si ya existe globalmente lo puedes quitar) --}}
    <div class="pos-header">
        <h1>Gastos</h1>
        <span>Orden {{ $orden->folio }}</span>
    </div>

    <div class="pos-body">

        {{-- =======================
            COLUMNA IZQUIERDA
        ======================== --}}
        <div class="pos-left">

            <div class="card">
                <div class="card-title">
                    Gastos – Orden {{ $orden->folio }}
                </div>

                <table class="pos-table">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Comprobante</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        {{-- FILA NUEVO GASTO --}}
                        <tr>
                            <td>
                                <input
                                    type="text"
                                    wire:model.defer="concepto"
                                    placeholder="Concepto del gasto">
                                @error('concepto')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </td>

                            <td>
                                <input
                                    type="number"
                                    step="0.01"
                                    wire:model.defer="monto"
                                    placeholder="Monto">
                                @error('monto')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </td>

                            <td>
                                <input
                                    type="file"
                                    wire:model="comprobante">
                                @error('comprobante')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </td>

                            <td class="text-muted">
                                Nuevo
                            </td>
                        </tr>

                        {{-- LISTADO --}}
                        @forelse($gastos as $gasto)
                            <tr>
                                <td>{{ $gasto->concepto }}</td>
                                <td>${{ number_format($gasto->monto,2) }}</td>
                                <td>
                                    @if($gasto->comprobante_path)
                                        <a href="{{ Storage::url($gasto->comprobante_path) }}" target="_blank">
                                            Ver
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        wire:click="eliminarGasto({{ $gasto->id }})"
                                        class="danger">
                                        ✕
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-row">
                                    Sin gastos registrados
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                
                <div style="display:flex; justify-content:flex-end; margin-top:16px;">
                    <button
                        wire:click="guardarGasto"
                        class="btn-gasto"
                    >
                        Guardar Gastos
                    </button>
                </div>
            </div>

        </div>

        {{-- =======================
            COLUMNA DERECHA
        ======================== --}}
        <div class="pos-right">

            <div class="pos-info">
                <div class="info-row">
                    <span>Folio</span>
                    <strong>{{ $orden->folio }}</strong>
                </div>
                <div class="info-row">
                <span>Sucursal</span>
                <strong>{{ $orden->sucursal->nombre }}</strong>

            </div>
                <div class="info-row">
                    <span>Estado</span>
                    <strong>{{ $orden->estado }}</strong>
                </div>
            </div>

            <div class="pos-total">
                <div class="total-row">
                    <span>Total gastos</span>
                    <span>${{ number_format($gastos->sum('monto'),2) }}</span>
                </div>

               
            </div>

        </div>

    </div>
</div>
