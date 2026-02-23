

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
            <button wire:click="guardarRemision">
                Guardar
            </button>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="pos-right">

        <div class="pos-info">
            <p><strong>Sucursal</strong><br>{{ $remision->sucursal->nombre }}</p>
            <p><strong>Estado</strong> En proceso</p>
            <p><strong>Fecha</strong><br>{{ $remision->created_at }}</p>
            <p><strong>Notas</strong><br>{{ $remision->notas }}</p>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('remision-registrada', () => {
            Swal.fire({
                icon: 'success',
                title: 'Remision registrada',
                text: 'La remision se registro correctamente.',
                confirmButtonColor: '#2563eb'
            })
        })
    })
</script>
