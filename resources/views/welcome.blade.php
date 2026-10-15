
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dulce Noviembre | Sistema de gestión</title>

    <meta name="description"
          content="Sistema interno de gestión de pedidos de Dulce Noviembre.">

    <meta name="theme-color" content="#047857">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --verde: #047857;
            --verde-oscuro: #065f46;
            --verde-claro: #ecfdf5;
            --texto: #1f2937;
            --texto-secundario: #64748b;
            --fondo: #ffffff;
            --borde: #e5eee9;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--texto);
            background: var(--fondo);
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .contenedor {
            width: min(1100px, calc(100% - 48px));
            margin: 0 auto;
        }

        /* ENCABEZADO */

        .encabezado {
            border-bottom: 1px solid var(--borde);
            background: rgba(255, 255, 255, 0.96);
        }

        .barra {
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .marca {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .marca-icono {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: white;
            background: var(--verde);
            border-radius: 12px;
        }

        .marca-icono svg {
            width: 24px;
            height: 24px;
        }

        .marca-nombre {
            font-family: 'Manrope', sans-serif;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .marca-subtitulo {
            margin-top: 3px;
            color: var(--texto-secundario);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .acceso {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 43px;
            padding: 0 18px;
            color: white;
            background: var(--verde);
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            transition: background 0.2s, transform 0.2s;
        }

        .acceso:hover {
            background: var(--verde-oscuro);
            transform: translateY(-1px);
        }

        .acceso svg {
            width: 17px;
            height: 17px;
        }

        /* CONTENIDO PRINCIPAL */

        main {
            flex: 1;
        }

        .principal {
            position: relative;
            overflow: hidden;
            padding: 94px 0 82px;
            background:
                radial-gradient(
                    ellipse at 95% 10%,
                    rgba(209, 250, 229, 0.55),
                    transparent 35%
                ),
                #ffffff;
        }

        .principal-contenido {
            position: relative;
            z-index: 1;
            max-width: 720px;
            margin: 0 auto;
            text-align: center;
        }

        .etiqueta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            color: var(--verde-oscuro);
            background: var(--verde-claro);
            border: 1px solid #d1fae5;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .etiqueta svg {
            width: 15px;
            height: 15px;
        }

        h1 {
            margin-top: 28px;
            font-family: 'Manrope', sans-serif;
            font-size: clamp(34px, 5vw, 52px);
            line-height: 1.2;
            letter-spacing: -1.8px;
            font-weight: 800;
        }

        h1 span {
            display: block;
            color: var(--verde);
        }

        .descripcion {
            max-width: 590px;
            margin: 22px auto 0;
            color: var(--texto-secundario);
            font-size: 15px;
            line-height: 1.9;
        }

        .acciones {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 31px;
        }

        .boton-secundario {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 0 18px;
            color: var(--texto);
            background: white;
            border: 1px solid var(--borde);
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            transition: border-color 0.2s, background 0.2s;
        }

        .boton-secundario:hover {
            border-color: #a7d9c3;
            background: var(--verde-claro);
        }

        /* ÁREAS DEL SISTEMA */

        .areas {
            padding: 39px 0 64px;
            border-top: 1px solid var(--borde);
            background: #fafcfb;
        }

        .areas-encabezado {
            margin-bottom: 23px;
            text-align: center;
        }

        .areas-encabezado h2 {
            font-family: 'Manrope', sans-serif;
            font-size: 18px;
            font-weight: 800;
        }

        .areas-encabezado p {
            margin-top: 7px;
            color: var(--texto-secundario);
            font-size: 13px;
            line-height: 1.7;
        }

        .areas-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .area {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            padding: 18px 15px;
            background: white;
            border: 1px solid var(--borde);
            border-radius: 11px;
        }

        .area-icono {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: var(--verde);
            background: var(--verde-claro);
            border-radius: 9px;
        }

        .area-icono svg {
            width: 20px;
            height: 20px;
        }

        .area-nombre {
            font-size: 12px;
            font-weight: 700;
            line-height: 1.5;
        }

        .area-descripcion {
            margin-top: 3px;
            color: var(--texto-secundario);
            font-size: 10px;
            line-height: 1.5;
        }

        /* PIE DE PÁGINA */

        .pie {
            border-top: 1px solid var(--borde);
            background: white;
        }

        .pie-contenido {
            min-height: 73px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .pie-nombre {
            font-size: 12px;
            font-weight: 700;
        }

        .pie-nombre span {
            color: var(--verde);
        }

        .pie-nota {
            color: var(--texto-secundario);
            font-size: 11px;
            text-align: right;
        }

        /* RESPONSIVE */

        @media (max-width: 850px) {
            .principal {
                padding: 76px 0 65px;
            }

            .areas-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 520px) {
            .contenedor {
                width: calc(100% - 32px);
            }

            .barra {
                min-height: 72px;
                gap: 10px;
            }

            .marca {
                gap: 9px;
            }

            .marca-icono {
                width: 39px;
                height: 39px;
            }

            .marca-nombre {
                font-size: 14px;
            }

            .marca-subtitulo {
                font-size: 9px;
                letter-spacing: 0.8px;
            }

            .acceso {
                min-height: 39px;
                padding: 0 11px;
                font-size: 11px;
            }

            .principal {
                padding: 62px 0 55px;
            }

            h1 {
                margin-top: 24px;
                font-size: 36px;
                letter-spacing: -1.3px;
            }

            .descripcion {
                margin-top: 17px;
                font-size: 14px;
            }

            .acciones {
                flex-direction: column;
                align-items: stretch;
            }

            .acciones a {
                width: 100%;
            }

            .areas {
                padding: 34px 0 42px;
            }

            .areas-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .area {
                padding: 15px;
            }

            .pie-contenido {
                min-height: 78px;
                align-items: flex-start;
                justify-content: center;
                flex-direction: column;
                gap: 7px;
                padding: 16px 0;
            }

            .pie-nota {
                text-align: left;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- ENCABEZADO -->
    <header class="encabezado">
        <div class="contenedor barra">

            <a href="{{ url('/') }}" class="marca"
               aria-label="Inicio de Dulce Noviembre">

                <span class="marca-icono">
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
                    <span class="marca-nombre">Dulce Noviembre</span>
                    <span class="marca-subtitulo" style="display:block">
                        Sistema de gestión interna
                    </span>
                </span>
            </a>

            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="acceso">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                        </svg>
                        Iniciar sesión
                    </a>
                @endif
            @else
                @if (Route::has('dashboard'))
                    <a href="{{ route('dashboard') }}" class="acceso">
                        Ir al sistema
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            @endguest

        </div>
    </header>

    <main>

        <!-- PORTADA INSTITUCIONAL -->
        <section class="principal">
            <div class="contenedor">
                <div class="principal-contenido">

                    <div class="etiqueta">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M8 5V3h8v2"/>
                            <path d="M8 10h8M8 14h5"/>
                        </svg>
                        Plataforma administrativa
                    </div>

                    <h1>
                        Sistema de gestión
                        <span>de pedidos</span>
                    </h1>

                    <p class="descripcion">
                        Plataforma interna para la administración y el
                        seguimiento de pedidos, productos, inventario y
                        sucursales de Dulce Noviembre.
                    </p>

                    <div class="acciones">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="acceso">
                                    Acceder al sistema
                                    <svg viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         aria-hidden="true">
                                        <path d="M5 12h14"/>
                                        <path d="m12 5 7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        @else
                            @if (Route::has('dashboard'))
                                <a href="{{ route('dashboard') }}" class="acceso">
                                    Ir al dashboard
                                    <svg viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         aria-hidden="true">
                                        <path d="M5 12h14"/>
                                        <path d="m12 5 7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        @endguest

                        <a href="#areas" class="boton-secundario">
                            Consultar áreas del sistema
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- ÁREAS ADMINISTRATIVAS -->
        <section class="areas" id="areas">
            <div class="contenedor">

                <div class="areas-encabezado">
                    <h2>Áreas de gestión</h2>
                    <p>
                        Módulos disponibles dentro de la plataforma administrativa.
                    </p>
                </div>

                <div class="areas-grid">

                    <article class="area">
                        <div class="area-icono">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="m12 3 9 5-9 5-9-5 9-5Z"/>
                                <path d="m3 12 9 5 9-5"/>
                                <path d="m3 16 9 5 9-5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="area-nombre">Productos</div>
                            <div class="area-descripcion">
                                Catálogo y variantes
                            </div>
                        </div>
                    </article>

                    <article class="area">
                        <div class="area-icono">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M3 7h18v13H3z"/>
                                <path d="M3 7l3-4h12l3 4"/>
                                <path d="M9 12h6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="area-nombre">Inventario</div>
                            <div class="area-descripcion">
                                Control de existencias
                            </div>
                        </div>
                    </article>

                    <article class="area">
                        <div class="area-icono">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M3 21h18"/>
                                <path d="M5 21V7l8-4v18"/>
                                <path d="M13 10h6v11"/>
                                <path d="M8 9h1M8 13h1M8 17h1"/>
                                <path d="M16 14h1M16 17h1"/>
                            </svg>
                        </div>
                        <div>
                            <div class="area-nombre">Sucursales</div>
                            <div class="area-descripcion">
                                Gestión de ubicaciones
                            </div>
                        </div>
                    </article>

                    <article class="area">
                        <div class="area-icono">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/>
                                <circle cx="10" cy="21" r="1"/>
                                <circle cx="18" cy="21" r="1"/>
                            </svg>
                        </div>
                        <div>
                            <div class="area-nombre">Pedidos</div>
                            <div class="area-descripcion">
                                Órdenes de venta
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

    </main>

    <!-- PIE DE PÁGINA -->
    <footer class="pie">
        <div class="contenedor pie-contenido">

            <div class="pie-nombre">
                Dulce Noviembre <span>· Pedidos</span>
            </div>

            <p class="pie-nota">
                Acceso exclusivo para personal autorizado.
                &copy; {{ date('Y') }}
            </p>

        </div>
    </footer>

</body>
</html>
