<div class="card">
    <div class="card-title">
        Mermas – Orden {{ $orden->folio }}
    </div>

    <form wire:submit.prevent>
        <table class="pos-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant. vendida</th>
                    <th>Merma</th>
                    <th>Tipo</th>
                    <th>Detalle</th>
                    <th>Observaciones</th>
                    <th>Evidencia</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($orden->detalles as $detalle)

                    {{-- ===============================
                        ENCABEZADO DEL PRODUCTO
                    ================================ --}}
                   <tr class="producto-row separador">
                        <td colspan="8">
                            <strong>
                                {{ $detalle->productoVariante->producto->nombre }}
                            </strong>

                            <span class="badge-variant">
                                {{ strtoupper($detalle->productoVariante->nombre) }}
                            </span>

                            <small class="producto-meta">
                                Cant. vendida: {{ $detalle->cantidad }}
                            </small>
                        </td>
                    </tr>



                    {{-- ===============================
                        MERMAS GUARDADAS (BD)
                    ================================ --}}
                    @if(!empty($mermasGuardadas[$detalle->producto_variante_id]))
                        @foreach($mermasGuardadas[$detalle->producto_variante_id] as $index => $merma)
                            <tr wire:key="merma-guardada-{{ $merma['id'] }}">

                                <td></td>

                                {{-- Cantidad --}}
                                <td>
                                    <input
                                        type="number"
                                        min="1"
                                        max="{{ $detalle->cantidad }}"
                                        wire:model.defer="mermasGuardadas.{{ $detalle->producto_variante_id }}.{{ $index }}.cantidad"
                                    >
                                </td>

                                {{-- Tipo --}}
                                <td>
                                    <select
                                        wire:model.live="mermasGuardadas.{{ $detalle->producto_variante_id }}.{{ $index }}.tipo_merma"
                                    >
                                        <option value="transporte">Transporte</option>
                                        <option value="sucursal">Punto de venta</option>
                                    </select>
                                </td>

                                {{-- Detalle --}}
                                <td class="td-detalle">
                                    @if(($merma['tipo_merma'] ?? null) === 'sucursal')

                                        <select
                                            wire:model.defer="mermasGuardadas.{{ $detalle->producto_variante_id }}.{{ $index }}.origen_sucursal"
                                        >
                                            <option value="">Responsabilidad</option>
                                            <option value="fabrica">Fábrica</option>
                                            <option value="sucursal">Sucursal</option>
                                        </select>

                                        <input
                                            type="text"
                                            placeholder="Lote"
                                            wire:model.defer="mermasGuardadas.{{ $detalle->producto_variante_id }}.{{ $index }}.lote"
                                        >
                                    @endif
                                </td>
                                {{-- Observaciones --}}
                                <td>
                                    <textarea
                                        rows="2"
                                        wire:model.defer="mermasGuardadas.{{ $detalle->producto_variante_id }}.{{ $index }}.observaciones"
                                        placeholder="Observaciones"
                                    ></textarea>
                                </td>


                                {{-- Evidencia --}}
                                <td>
                                    @if($merma['imagen_path'])
                                        <a
                                            href="{{ asset('storage/'.$merma['imagen_path']) }}"
                                            target="_blank"
                                        >
                                            Ver imagen
                                        </a>
                                    @endif
                                </td>
                                {{-- Eliminar --}}
                                <td>
                                    <button
                                        type="button"
                                        wire:click="eliminarMerma({{ $detalle->producto_variante_id }}, {{ $index }})"
                                    >
                                        ❌
                                    </button>
                                </td>

                                <td></td>
                            </tr>
                        @endforeach
                    @endif

                    {{-- ===============================
                        MERMAS NUEVAS (SIN GUARDAR)
                    ================================ --}}
                    @if(!empty($mermas[$detalle->producto_variante_id]))
                        @foreach($mermas[$detalle->producto_variante_id] as $index => $merma)
                            <tr wire:key="merma-nueva-{{ $detalle->producto_variante_id }}-{{ $index }}">

                                <td></td>

                                {{-- Cantidad --}}
                                <td>
                                    <input
                                        type="number"
                                        min="1"
                                        max="{{ $detalle->cantidad }}"
                                        wire:model.defer="mermas.{{ $detalle->producto_variante_id }}.{{ $index }}.cantidad"
                                    >
                                </td>

                                {{-- Tipo --}}
                                <td>
                                    <select
                                        wire:model.live="mermas.{{ $detalle->producto_variante_id }}.{{ $index }}.tipo_merma"
                                    >
                                        <option value="">Tipo de merma</option>
                                        <option value="transporte">Transporte</option>
                                        <option value="sucursal">Punto de venta</option>
                                    </select>
                                </td>

                                {{-- Detalle --}}
                                <td class="td-detalle">
                                    @if(($merma['tipo_merma'] ?? null) === 'sucursal')

                                        <select
                                            wire:model.defer="mermas.{{ $detalle->producto_variante_id }}.{{ $index }}.origen_sucursal"
                                        >
                                            <option value="">Responsabilidad</option>
                                            <option value="fabrica">Fábrica</option>
                                            <option value="sucursal">Sucursal</option>
                                        </select>

                                        <input
                                            type="text"
                                            placeholder="Lote"
                                            wire:model.defer="mermas.{{ $detalle->producto_variante_id }}.{{ $index }}.lote"
                                        >
                                    @endif
                                </td>

                                {{-- Observaciones --}}
                                <td>
                                    <textarea
                                        rows="2"
                                        wire:model.defer="mermas.{{ $detalle->producto_variante_id }}.{{ $index }}.observaciones"
                                        placeholder="Observaciones"
                                    ></textarea>
                                </td>


                                {{-- Evidencia --}}
                                <td>
                                    <input
                                        type="file"
                                        wire:model="mermas.{{ $detalle->producto_variante_id }}.{{ $index }}.imagen"
                                    >
                                </td>

                                {{-- Eliminar --}}
                                <td>
                                    <button
                                        type="button"
                                        wire:click="eliminarMerma({{ $detalle->producto_variante_id }}, {{ $index }})"
                                    >
                                        ❌
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    @endif

                    {{-- ===============================
                        BOTÓN AGREGAR MERMA
                    ================================ --}}
                    <tr>
                        <td colspan="8">
                            <button
                                type="button"
                                wire:click="agregarMerma({{ $detalle->producto_variante_id }})"
                                class="merma-link"
                            >
                                + Agregar merma
                            </button>


                            @error("mermas.$detalle->producto_variante_id")
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>

        {{-- ===============================
            TOTAL
        ================================ --}}
        <div class="pos-total">
            <div class="total-row total">
                <span>Total mermas</span>
                <strong>
                    ${{ number_format($this->totalMermas, 2) }}
                </strong>
            </div>
        </div>

        {{-- ===============================
            GUARDAR
        ================================ --}}
        <div style="display:flex; justify-content:flex-end; margin-top:16px;">
            <button
                wire:click="guardarTodasLasMermas"
                class="btn-merma"
            >
                Guardar mermas
            </button>
        </div>

    </form>
</div>
