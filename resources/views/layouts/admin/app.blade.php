
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel de control') | Dulce Noviembre</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --dn-green: #047857;
            --dn-green-dark: #065f46;
            --dn-green-light: #ecfdf5;
            --dn-sidebar: #ffffff;
            --dn-background: #f7f9f8;
            --dn-border: #e7eee9;
            --dn-text: #1f2937;
            --dn-muted: #64748b;
            --dn-sidebar-width: 258px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--dn-background);
            color: var(--dn-text);
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        button, input, select, textarea {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        .dn-app {
            min-height: 100vh;
        }

        /* MENÚ LATERAL */

        .dn-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 50;
            display: flex;
            width: var(--dn-sidebar-width);
            flex-direction: column;
            background: var(--dn-sidebar);
            border-right: 1px solid var(--dn-border);
            transition: transform .25s ease;
        }

        .dn-brand {
            display: flex;
            min-height: 83px;
            align-items: center;
            gap: 12px;
            padding: 18px 21px;
            border-bottom: 1px solid var(--dn-border);
            text-decoration: none;
        }

        .dn-brand-icon {
            display: grid;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 12px;
            background: var(--dn-green);
            color: #fff;
        }

        .dn-brand-icon svg {
            width: 24px;
            height: 24px;
        }

        .dn-brand-name {
            color: #172b24;
            font-family: 'Manrope', sans-serif;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -.45px;
            line-height: 1.4;
        }

        .dn-brand-subtitle {
            margin-top: 3px;
            color: var(--dn-muted);
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .dn-sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 22px 13px;
        }

        .dn-nav-group {
            margin-bottom: 25px;
        }

        .dn-nav-heading {
            padding: 0 12px;
            margin-bottom: 9px;
            color: #9ca3af;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .dn-nav-link {
            display: flex;
            min-height: 43px;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            margin-bottom: 4px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #59665f;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: background .18s, color .18s, border-color .18s;
        }

        .dn-nav-link:hover {
            background: #f5faf7;
            color: var(--dn-green);
        }

        .dn-nav-link.active {
            border-color: #d1fae5;
            background: var(--dn-green-light);
            color: var(--dn-green-dark);
            font-weight: 700;
        }

        .dn-nav-link svg {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
        }

        .dn-sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--dn-border);
        }

        .dn-internal-note {
            padding: 13px;
            border: 1px solid #d1fae5;
            border-radius: 11px;
            background: #f0fdf7;
        }

        .dn-internal-note-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dn-green-dark);
            font-size: 11px;
            font-weight: 700;
        }

        .dn-internal-note-title svg {
            width: 17px;
            height: 17px;
        }

        .dn-internal-note p {
            margin: 6px 0 0;
            color: #648176;
            font-size: 10px;
            line-height: 1.6;
        }

        /* ÁREA PRINCIPAL */

        .dn-main {
            min-height: 100vh;
            margin-left: var(--dn-sidebar-width);
        }

        /* BARRA SUPERIOR */

        .dn-topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            display: flex;
            min-height: 75px;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 14px 30px;
            border-bottom: 1px solid var(--dn-border);
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(12px);
        }

        .dn-topbar-left {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 13px;
        }

        .dn-menu-toggle {
            display: none;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--dn-border);
            border-radius: 9px;
            background: white;
            color: var(--dn-text);
            cursor: pointer;
        }

        .dn-menu-toggle svg {
            width: 20px;
            height: 20px;
        }

        .dn-page-title {
            overflow: hidden;
            color: #26352e;
            font-family: 'Manrope', sans-serif;
            font-size: 15px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dn-page-subtitle {
            margin-top: 3px;
            color: var(--dn-muted);
            font-size: 11px;
        }

        .dn-topbar-right {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 14px;
        }

        .dn-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dn-avatar {
            display: grid;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            place-items: center;
            border: 1px solid #d1fae5;
            border-radius: 50%;
            background: var(--dn-green-light);
            color: var(--dn-green-dark);
            font-size: 13px;
            font-weight: 800;
        }

        .dn-user-name {
            max-width: 180px;
            overflow: hidden;
            color: #33443a;
            font-size: 12px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dn-user-label {
            margin-top: 3px;
            color: var(--dn-muted);
            font-size: 10px;
        }

        /* CONTENIDO DE LAS VISTAS */

        .dn-content {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 30px;
        }

        .dn-overlay {
            display: none;
        }

        /* PIE */

        .dn-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 20px 30px;
            border-top: 1px solid var(--dn-border);
            background: #fff;
            color: var(--dn-muted);
            font-size: 10px;
        }

        .dn-footer strong {
            color: var(--dn-green);
            font-weight: 700;
        }

        /* ADAPTACIÓN A TABLETAS Y CELULARES */

        @media (max-width: 900px) {
            .dn-sidebar {
                transform: translateX(-100%);
            }

            .dn-sidebar.open {
                transform: translateX(0);
            }

            .dn-main {
                margin-left: 0;
            }

            .dn-menu-toggle {
                display: inline-flex;
            }

            .dn-overlay.visible {
                position: fixed;
                inset: 0;
                z-index: 40;
                display: block;
                background: rgba(15, 23, 42, .35);
            }

            .dn-topbar {
                padding: 13px 20px;
            }

            .dn-content {
                padding: 23px 20px;
            }

            .dn-footer {
                padding: 18px 20px;
            }
        }

        @media (max-width: 520px) {
            .dn-topbar {
                min-height: 67px;
                gap: 8px;
                padding: 11px 13px;
            }

            .dn-page-title {
                font-size: 13px;
            }

            .dn-page-subtitle {
                font-size: 10px;
            }

            .dn-topbar-right {
                gap: 7px;
            }

            .dn-user {
                gap: 7px;
            }

            .dn-user-name {
                max-width: 100px;
                font-size: 11px;
            }

            .dn-user-label {
                font-size: 9px;
            }

            .dn-avatar {
                width: 34px;
                height: 34px;
                font-size: 11px;
            }

            .dn-content {
                padding: 17px 13px;
            }

            .dn-footer {
                align-items: flex-start;
                flex-direction: column;
                gap: 6px;
                padding: 15px 13px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }

        /* CERRAR SESIÓN */

        .dn-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 13px;

            border: 1px solid #d1fae5;
            border-radius: 9px;
            background: #fff;
            color: #047857;

            font-size: 12px;
            font-weight: 700;
            cursor: pointer;

            transition: background .2s, color .2s, border-color .2s;
        }

        .dn-logout svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .dn-logout:hover {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        @media (max-width: 520px) {
            .dn-logout {
                padding: 9px;
            }

            .dn-logout span {
                display: none;
            }
        }
    </style>
</head>

<body>
    @php
        $usuario = Auth::user();
        $nombreUsuario = $usuario?->name ?? 'Usuario';
        $iniciales = collect(explode(' ', trim($nombreUsuario)))
            ->filter()
            ->take(2)
            ->map(fn ($parte) => mb_substr($parte, 0, 1))
            ->implode('');
    @endphp

    <div class="dn-app">

        {{-- MENÚ LATERAL --}}
        <aside class="dn-sidebar" id="dnSidebar">

            <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}"
               class="dn-brand">

                <span class="dn-brand-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        <path d="M4 10h16l-1.2 10H5.2L4 10Z"/>
                        <path d="M7 10a5 5 0 0 1 10 0"/>
                        <path d="M9 5.5c0-1 .8-1.5.8-2.5"/>
                        <path d="M14 5.5c0-1 .8-1.5.8-2.5"/>
                    </svg>
                </span>

                <span>
                    <span class="dn-brand-name">Dulce Noviembre</span>
                    <span class="dn-brand-subtitle">Pedidos · Gestión</span>
                </span>
            </a>

            <nav class="dn-sidebar-content" aria-label="Menú administrativo">

                {{-- INICIO --}}
                <div class="dn-nav-group">
                    <div class="dn-nav-heading">Inicio</div>

                    @if (Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}"
                           class="dn-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.7"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7" rx="1"/>
                                <rect x="14" y="3" width="7" height="7" rx="1"/>
                                <rect x="3" y="14" width="7" height="7" rx="1"/>
                                <rect x="14" y="14" width="7" height="7" rx="1"/>
                            </svg>
                            Panel de control
                        </a>
                    @endif
                </div>

                {{-- OPERACIÓN --}}
                @hasanyrole('admin|gerente|Ventas mostrador|fabrica')
                <div class="dn-nav-group">
                    <div class="dn-nav-heading">Operación</div>

                    @hasanyrole('admin|gerente|Ventas mostrador')
                    <a href="{{ route('admin.ordenes.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.ordenes.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/>
                            <circle cx="10" cy="21" r="1"/>
                            <circle cx="18" cy="21" r="1"/>
                        </svg>
                        Órdenes de venta
                    </a>

                    <a href="{{ route('admin.cortes.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.cortes.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <path d="M7 9h10M7 13h6M7 17h4"/>
                        </svg>
                        Cortes
                    </a>

                    <a href="{{ route('admin.remisiones.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.remisiones.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M6 2h9l5 5v15H6z"/>
                            <path d="M14 2v6h6M9 13h8M9 17h8"/>
                        </svg>
                        Remisiones
                    </a>
                    @endhasanyrole

                    @hasanyrole('admin|fabrica|gerente')
                    <a href="{{ route('admin.pedidos.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.pedidos.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                            <path d="M9 12h6M9 16h6"/>
                        </svg>
                        Pedidos
                    </a>

                    <a href="{{ route('admin.pedidos.maximos.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.pedidos.maximos.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M4 19V5m0 14h16"/>
                            <path d="m7 15 4-4 3 2 5-7"/>
                        </svg>
                        Pedidos máximos
                    </a>

                    @hasanyrole('admin|pedidos')
                    <a href="{{ route('admin.pedidos.globales.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.pedidos.globales.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"/>
                        </svg>
                        Pedidos globales
                    </a>
                    @endhasanyrole
                    @endhasanyrole
                </div>
                @endhasanyrole

                {{-- CATÁLOGO E INVENTARIO --}}
                @hasanyrole('admin')
                <div class="dn-nav-group">
                    <div class="dn-nav-heading">Catálogo e inventario</div>

                    <a href="{{ route('admin.productos.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="m12 3 9 5-9 5-9-5 9-5Z"/>
                            <path d="m3 12 9 5 9-5m-18 4 9 5 9-5"/>
                        </svg>
                        Productos
                    </a>

                    <a href="{{ route('admin.categorias.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <rect x="4" y="4" width="6" height="6" rx="1"/>
                            <rect x="14" y="4" width="6" height="6" rx="1"/>
                            <rect x="4" y="14" width="6" height="6" rx="1"/>
                            <rect x="14" y="14" width="6" height="6" rx="1"/>
                        </svg>
                        Categorías
                    </a>

                    <a href="{{ route('admin.movimientos.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.movimientos.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M7 7h14l-4-4m4 4-4 4M17 17H3l4 4m-4-4 4-4"/>
                        </svg>
                        Movimientos
                    </a>
                </div>

                {{-- ADMINISTRACIÓN --}}
                <div class="dn-nav-group">
                    <div class="dn-nav-heading">Administración</div>

                    <a href="{{ route('admin.sucursales.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.sucursales.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M3 21h18M5 21V7l8-4v18M13 10h6v11"/>
                            <path d="M8 9h1m-1 4h1m-1 4h1m7-3h1m-1 3h1"/>
                        </svg>
                        Sucursales
                    </a>

                    <a href="{{ route('admin.usuarios.index') }}"
                       class="dn-nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="10" cy="7" r="4"/>
                            <path d="M20 8v6m3-3h-6"/>
                        </svg>
                        Usuarios
                    </a>
                </div>
                @endhasanyrole

            </nav>

            <div class="dn-sidebar-footer">
                <div class="dn-internal-note">
                    <div class="dn-internal-note-title">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                        Sistema interno
                    </div>
                    <p>Utiliza tus credenciales personales y no compartas tu acceso.</p>
                </div>
            </div>

        </aside>

        {{-- FONDO PARA EL MENÚ MÓVIL --}}
        <div class="dn-overlay" id="dnOverlay"></div>

        {{-- ÁREA PRINCIPAL --}}
        <div class="dn-main">

            {{-- BARRA SUPERIOR --}}
            <header class="dn-topbar">

                <div class="dn-topbar-left">
                    <button type="button"
                            class="dn-menu-toggle"
                            id="dnMenuToggle"
                            aria-label="Abrir menú"
                            aria-controls="dnSidebar"
                            aria-expanded="false">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <div class="dn-page-title">
                            @yield('title', 'Panel de control')
                        </div>
                        <div class="dn-page-subtitle">
                            Dulce Noviembre · Sistema administrativo
                        </div>
                    </div>
                </div>

                <div class="dn-topbar-right">
                    <div class="dn-user">
                        <div class="dn-avatar" aria-hidden="true">
                            {{ mb_strtoupper($iniciales) }}
                        </div>

                        <div class="hidden sm:block">
                            <div class="dn-user-name">
                                {{ $nombreUsuario }}
                            </div>
                            <div class="dn-user-label">
                                Sesión activa
                            </div>
                        </div>
                    </div>

                    {{-- CERRAR SESIÓN --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="dn-logout">
                            <svg viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M10 17l5-5-5-5"/>
                                <path d="M15 12H3"/>
                                <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                            </svg>

                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>


            </header>

            {{-- CONTENIDO DE CADA PÁGINA --}}
            <main class="dn-content">
                @yield('content')
            </main>

            <footer class="dn-footer">
                <span>
                    <strong>Dulce Noviembre</strong> · Pedidos
                </span>
                <span>
                    Sistema de gestión interna &copy; {{ date('Y') }}
                </span>
            </footer>

        </div>
    </div>

    <script>
        (() => {
            const sidebar = document.getElementById('dnSidebar');
            const overlay = document.getElementById('dnOverlay');
            const toggle = document.getElementById('dnMenuToggle');

            if (!sidebar || !overlay || !toggle) {
                return;
            }

            function abrirMenu() {
                sidebar.classList.add('open');
                overlay.classList.add('visible');
                toggle.setAttribute('aria-expanded', 'true');
                toggle.setAttribute('aria-label', 'Cerrar menú');
                document.body.style.overflow = 'hidden';
            }

            function cerrarMenu() {
                sidebar.classList.remove('open');
                overlay.classList.remove('visible');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Abrir menú');
                document.body.style.overflow = '';
            }

            toggle.addEventListener('click', () => {
                if (sidebar.classList.contains('open')) {
                    cerrarMenu();
                } else {
                    abrirMenu();
                }
            });

            overlay.addEventListener('click', cerrarMenu);

            sidebar.querySelectorAll('a').forEach((enlace) => {
                enlace.addEventListener('click', () => {
                    if (window.innerWidth <= 900) {
                        cerrarMenu();
                    }
                });
            });

            document.addEventListener('keydown', (evento) => {
                if (evento.key === 'Escape') {
                    cerrarMenu();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 900) {
                    cerrarMenu();
                }
            });
        })();
    </script>

</body>
</html>
