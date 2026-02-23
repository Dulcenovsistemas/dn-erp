

<div class="pos-body"> {{-- 👈 ESTE ES EL ÚNICO ROOT --}}

    {{-- LEFT --}}
    <div class="pos-left">

        {{-- BUSCADOR --}}
        <div style="position: relative">
            <input
                type="text"
                placeholder="Buscar producto..."
                wire:model.live="search"
                autocomplete="off"
            />


            @if(strlen($search) >= 2)
                <div style="
                    position:absolute;
                    top:100%;
                    left:0;
                    right:0;
                    background:#fff;
                    border:1px solid #ddd;
                    z-index:9999;
                    max-height:250px;
                    overflow:auto;
                ">
                    @forelse($this->productosFiltrados as $producto)
                        <div
                            wire:key="producto-sucursal-{{ $producto->id }}"
                            class="pos-product-item"
                            wire:mousedown.prevent="seleccionarProducto({{ $producto->id }})"
                        >
                            <div class="pos-product-name">
                                {{ $producto->variante->producto->nombre }}
                            </div>

                            <div class="pos-product-meta">
                                <span class="badge badge-size">
                                    {{ strtoupper($producto->variante->nombre) }}
                                </span>

                                <span class="pos-product-price">
                                    ${{ number_format($producto->precio, 2) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div style="padding:8px; color:#888;">
                            Sin resultados
                        </div>
                    @endforelse
                </div>
            @endif

        </div>



        {{-- TABLA --}}
        <div class="pos-table">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Desc.</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item['nombre'] }}</td>

                    {{-- Cantidad --}}
                    <td>
                        <div class="qty-control">
                            <button wire:click="decrementar({{ $item['id'] }})">−</button>
                            <span>{{ $item['cantidad'] }}</span>
                            <button wire:click="incrementar({{ $item['id'] }})">+</button>
                        </div>
                    </td>

                    <td>${{ number_format($item['precio'],2) }}</td>
                    <td>${{ number_format($item['precio'] * $item['cantidad'],2) }}</td>
                    <td>${{ number_format($this->getTotalItem($item), 2) }}</td>

                    {{-- Descuento --}}
                    <td>
                        <div class="discount-control">
                            <input type="number"
                                min="0"
                                step="0.01"
                                wire:model.lazy="items.{{ $item['id'] }}.descuento">

                            <select wire:model="items.{{ $item['id'] }}.descuento_tipo">
                                <option value="monto">$</option>
                                <option value="porcentaje">%</option>
                            </select>
                        </div>
                    </td>

                    {{-- Quitar --}}
                    <td>
                        <button class="btn-remove"
                            wire:click="quitarProducto({{ $item['id'] }})"
                            title="Quitar producto">
                            ✕
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-row">
                        Sin productos
                    </td>
                </tr>
                @endforelse
                </tbody>

            </table>
            <button wire:click="guardarOrden">
                Guardar
            </button>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="pos-right">

        <div class="pos-info">
            <p><strong>Sucursal</strong><br>{{ $orden->sucursal->nombre }}</p>
            <p><strong>Estado</strong> En proceso</p>
            <p><strong>Fecha</strong><br>{{ $orden->created_at }}</p>
            <p><strong>Notas</strong><br>{{ $orden->notas }}</p>
        </div>

        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
            <button wire:click="irAGastos">
                ← GASTOS
            </button>

            <button wire:click="irAMermas">
                ← MERMAS
            </button>
        </div>


        <div class="pos-total">

            <div class="row">
                <span>Subtotal</span>
                <span>${{ number_format($this->subtotal, 2) }}</span>
            </div>

            <div class="row">
                <span>Descuentos</span>
                <span>-${{ number_format($this->totalDescuentos, 2) }}</span>
            </div>

            <div class="row">
                <span>Mermas</span>
                <span>-${{ number_format($this->totalMermas, 2) }}</span>
            </div>

            <div class="row">
                <span>Gastos</span>
                <span>-${{ number_format($this->totalGastos, 2) }}</span>
            </div>

            <div class="row total">
                <span>Total</span>
                <span>${{ number_format($this->total, 2) }}</span>
            </div>

        </div>


    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('venta-registrada', () => {
            Swal.fire({
                icon: 'success',
                title: 'Venta guardada',
                text: 'La venta se registro correctamente.',
                confirmButtonColor: '#2563eb'
            })
        })
    })
</script>
