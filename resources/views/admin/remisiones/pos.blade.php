<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Venta {{ $remision->folio }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <style>
        html, body {
            margin: 0;
            height: 100%;
            overflow: hidden;
            font-family: system-ui, -apple-system, BlinkMacSystemFont;
            background: #f3f4f6;
        }

        /* ===== Layout base ===== */
        .pos {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .pos-header {
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }

        .pos-body {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        /* ===== Left ===== */
       .pos-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 16px;
            gap: 12px;
            overflow: visible; ✅

        }


        .pos-table {
            flex: 1;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
            position: sticky;
            top: 0;
        }

        /* ===== Right ===== */
        .pos-right {
            width: 360px;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .pos-info {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            font-size: 14px;
        }

        .pos-total {
            background: #0f172a;
            color: #fff;
            padding: 16px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            border-top: 1px solid #334155;
            padding-top: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 6px 8px;
            margin-top: 4px;
        }

        /* ===== Cantidad ===== */
.qty-control {
    display: flex;
    align-items: center;
    gap: 6px;
}

.qty-control button {
    width: 26px;
    height: 26px;
    border: 1px solid #d1d5db;
    background: #fff;
    border-radius: 4px;
    cursor: pointer;
}

.qty-control span {
    min-width: 22px;
    text-align: center;
    font-weight: 600;
}

/* ===== Descuento ===== */
.discount-control {
    display: flex;
    align-items: center;
    gap: 6px;
}

.discount-control input {
    width: 70px;
    padding: 6px;
    text-align: right;
}

.discount-control select {
    width: 52px;
    padding: 6px;
}

/* ===== Botón eliminar ===== */
.btn-remove {
    background: #fee2e2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    cursor: pointer;
}

.btn-remove:hover {
    background: #fecaca;
}

/* ===== Empty ===== */
.empty-row {
    text-align: center;
    color: #9ca3af;
    padding: 20px;
}

    </style>
    @livewireStyles
</head>

<body>

<div class="pos">

    <!-- HEADER -->
    <div class="pos-header">
        <strong>Remision {{ $remision->folio }}</strong>
    </div>

    <!-- BODY -->
    <div class="pos-body">

        <!-- LEFT -->
        @livewire('pos-remision', ['remision' => $remision])


        



        

    </div>
</div>
@livewireScripts
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

</body>
</html>
