<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen w-screen overflow-hidden bg-gray-100 flex flex-col">


    {{-- HEADER --}}
    <header class="h-14 bg-white border-b flex items-center justify-between px-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.ordenes.index') }}" class="text-xl">✕</a>
            <span class="font-semibold">@yield('header')</span>
        </div>

        <button class="bg-blue-600 text-white px-4 py-1.5 rounded">
            Guardar
        </button>
    </header>

    {{-- AQUÍ NO HAY CONTAINER --}}
    <main class="flex-1 w-full overflow-hidden flex">
    @yield('content')
</main>

    


</body>
</html>
