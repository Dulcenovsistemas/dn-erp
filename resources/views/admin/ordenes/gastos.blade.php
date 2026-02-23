

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gastos . Orden {{ $orden->folio }}</title>
</head>

<style>

:root {
            --bg: #f3f4f6;
            --card: #ffffff;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --primary: #2563eb;
            --danger: #dc2626;
            --dark: #0f172a;
            --radius: 10px;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            height: 100%;
            font-family: system-ui, -apple-system, BlinkMacSystemFont;
            background: var(--bg);
            color: var(--text);
        }

        .pos-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.pos-table th {
    text-align: left;
    color: var(--muted);
    font-weight: 600;
    padding: 8px;
}

.pos-table td {
    padding: 8px;
    border-bottom: 1px solid var(--border);
}



        /* ===== Layout ===== */
        .pos {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* ===== Header ===== */
        .pos-header {
            height: 60px;
            background: var(--card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .pos-header h1 {
            font-size: 16px;
            margin: 0;
            font-weight: 600;
        }

        .pos-header span {
            color: var(--muted);
            font-size: 13px;
        }

        /* ===== Body ===== */
        .pos-body {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        /* ===== Left ===== */
        .pos-left {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            margin-bottom: 16px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        /* ===== Right ===== */
        .pos-right {
            width: 360px;
            border-left: 1px solid var(--border);
            background: var(--card);
            display: flex;
            flex-direction: column;
        }

        .pos-info {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            font-size: 14px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: var(--muted);
        }

        .info-row strong {
            color: var(--text);
            font-weight: 600;
        }

        .pos-total {
            background: var(--dark);
            color: #fff;
            padding: 20px;
        }

  

        .total-row.total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 600;
        }


        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .total-row.total {
            font-size: 18px;
            font-weight: bold;
            border-top: 1px solid #334155;
            padding-top: 10px;
            margin-top: 10px;
        }

        /* ===== Inputs ===== */
        input, select, textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }

        label {
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 4px;
            display: block;
        }

        button {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        button.danger {
            background: var(--danger);
        }

       .td-detalle {
            width: 240px;
        }

        
        .merma-link {
            background: none;
            border: none;
            padding: 0;
            color: #2563eb; /* azul discreto */
            font-size: 14px;
            cursor: pointer;
        }

        .merma-link:hover {
            text-decoration: underline;
        }


        .merma-detalle-inline {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .merma-detalle-inline select {
            width: 120px;
            height: 34px;
            font-size: 13px;
        }

        .merma-detalle-inline input {
            width: 90px;
            height: 34px;
            font-size: 13px;
        }

        .merma-detalle-inline select,
        .merma-detalle-inline input {
            border-radius: 6px;
            border: 1px solid #d1d5db;
            padding: 4px 8px;
        }

        .producto-row.separador td {
    padding: 10px 0;
    border-bottom: 1px solid #e5e7eb; /* gris muy sutil */
}

</style>
<body>
    <livewire:orden-venta-gastos :orden="$orden" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('gasto-guardado', () => {
            Swal.fire({
                icon: 'success',
                title: 'Gastos guardados',
                text: 'Los gastos se registraron correctamente.',
                confirmButtonColor: '#2563eb'
            })
        })
    })
</script>
</body>
</html>