
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iniciar sesión | Dulce Noviembre Pedidos</title>

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
            --secundario: #64748b;
            --borde: #dce7e1;
            --error: #b91c1c;
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
            background:
                radial-gradient(
                    ellipse at 85% 15%,
                    rgba(209, 250, 229, 0.5),
                    transparent 35%
                ),
                #f8fbf9;
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .contenedor {
            width: min(1100px, calc(100% - 40px));
            margin: 0 auto;
        }

        /* ENCABEZADO */

        .encabezado {
            background: rgba(255, 255, 255, 0.94);
            border-bottom: 1px solid #e7eee9;
        }

        .barra {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .marca {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .marca-icono {
            width: 43px;
            height: 43px;
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
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .marca-subtitulo {
            display: block;
            margin-top: 3px;
            color: var(--secundario);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .volver {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #52635b;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .volver:hover {
            color: var(--verde);
        }

        .volver svg {
            width: 17px;
            height: 17px;
        }

        /* CONTENIDO */

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 54px 20px;
        }

        .login-contenedor {
            width: 100%;
            max-width: 440px;
        }

        .login-encabezado {
            margin-bottom: 27px;
            text-align: center;
        }

        .login-icono {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            margin: 0 auto 22px;
            color: var(--verde);
            background: var(--verde-claro);
            border: 1px solid #d1fae5;
            border-radius: 17px;
        }

        .login-icono svg {
            width: 27px;
            height: 27px;
        }

        .etiqueta {
            color: var(--verde);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        h1 {
            margin-top: 10px;
            font-family: 'Manrope', sans-serif;
            font-size: 30px;
            line-height: 1.3;
            letter-spacing: -1px;
            font-weight: 800;
        }

        .descripcion {
            margin-top: 10px;
            color: var(--secundario);
            font-size: 13px;
            line-height: 1.8;
        }

        /* FORMULARIO */

        .login-card {
            padding: 32px;
            background: white;
            border: 1px solid #e5eee9;
            border-radius: 17px;
            box-shadow: 0 18px 50px rgba(6, 95, 70, 0.07);
        }

        .estado {
            margin-bottom: 21px;
            padding: 12px 14px;
            color: var(--verde-oscuro);
            background: var(--verde-claro);
            border: 1px solid #bbf7d0;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.7;
        }

        .campo {
            margin-bottom: 21px;
        }

        .campo-label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-size: 12px;
            font-weight: 700;
        }

        .campo-input {
            width: 100%;
            min-height: 47px;
            padding: 12px 14px;
            color: var(--texto);
            background: white;
            border: 1px solid var(--borde);
            border-radius: 9px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .campo-input::placeholder {
            color: #9ca3af;
        }

        .campo-input:focus {
            border-color: var(--verde);
            box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.10);
        }

        .campo-input[aria-invalid="true"] {
            border-color: #dc2626;
        }

        .error {
            margin-top: 7px;
            color: var(--error);
            font-size: 11px;
            line-height: 1.6;
        }

        .password-contenedor {
            position: relative;
        }

        .password-contenedor .campo-input {
            padding-right: 72px;
        }

        .mostrar-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            padding: 5px 0;
            color: var(--secundario);
            background: transparent;
            border: 0;
            font-family: inherit;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .mostrar-password:hover {
            color: var(--verde);
        }

        .opciones {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin: 1px 0 24px;
        }

        .recordar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #52635b;
            font-size: 12px;
            cursor: pointer;
        }

        .recordar input {
            width: 15px;
            height: 15px;
            accent-color: var(--verde);
            cursor: pointer;
        }

        .recuperar {
            color: var(--verde);
            font-size: 11px;
            font-weight: 700;
        }

        .recuperar:hover {
            color: var(--verde-oscuro);
            text-decoration: underline;
        }

        .boton {
            width: 100%;
            min-height: 47px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: white;
            background: var(--verde);
            border: 1px solid var(--verde);
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .boton:hover {
            background: var(--verde-oscuro);
            transform: translateY(-1px);
        }

        .boton:focus-visible,
        .volver:focus-visible,
        .recuperar:focus-visible,
        .mostrar-password:focus-visible {
            outline: 3px solid #a7f3d0;
            outline-offset: 3px;
        }

        .boton svg {
            width: 17px;
            height: 17px;
        }

        .seguridad {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 8px;
            margin-top: 22px;
            color: var(--secundario);
            font-size: 11px;
            line-height: 1.7;
            text-align: center;
        }

        .seguridad svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            margin-top: 1px;
            color: var(--verde);
        }

        /* PIE */

        .pie {
            padding: 22px 0;
            background: white;
            border-top: 1px solid #e7eee9;
        }

        .pie-contenido {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .pie-nombre {
            color: var(--texto);
            font-size: 11px;
            font-weight: 700;
        }

        .pie-nombre span {
            color: var(--verde);
        }

        .pie-nota {
            color: var(--secundario);
            font-size: 10px;
            text-align: right;
        }

        @media (max-width: 520px) {
            .contenedor {
                width: calc(100% - 30px);
            }

            .barra {
                min-height: 70px;
            }

            .marca {
                gap: 9px;
            }

            .marca-icono {
                width: 38px;
                height: 38px;
            }

            .marca-nombre {
                font-size: 14px;
            }

            .marca-subtitulo {
                font-size: 9px;
                letter-spacing: 0.6px;
            }

            .volver {
                font-size: 11px;
            }

            main {
                padding: 38px 15px;
            }

            .login-card {
                padding: 24px 20px;
            }

            h1 {
                font-size: 27px;
            }

            .pie-contenido {
                align-items: flex-start;
                flex-direction: column;
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
               aria-label="Volver al inicio">

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
                    <span class="marca-subtitulo">
                        Sistema de gestión interna
                    </span>
                </span>
            </a>

            <a href="{{ url('/') }}" class="volver">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Volver al inicio
            </a>

        </div>
    </header>

    <!-- FORMULARIO DE ACCESO -->
    <main>
        <div class="login-contenedor">

            <div class="login-encabezado">

                <div class="login-icono">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.7"
                         stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        <rect x="4" y="10" width="16" height="11" rx="2"/>
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                        <circle cx="12" cy="15" r="1.2"/>
                        <path d="M12 16.2V18"/>
                    </svg>
                </div>

                <span class="etiqueta">Acceso al personal</span>

                <h1>Iniciar sesión</h1>

                <p class="descripcion">
                    Ingresa tus credenciales para acceder al sistema
                    de gestión de Dulce Noviembre.
                </p>

            </div>

            <div class="login-card">

                <!-- MENSAJE DE ESTADO -->
                @if (session('status'))
                    <div class="estado" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- ERRORES GENERALES -->
                @if ($errors->any())
                    <div class="estado"
                         role="alert"
                         style="color:#b91c1c;background:#fef2f2;border-color:#fecaca;">
                        Verifica los datos ingresados e inténtalo nuevamente.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- CORREO ELECTRÓNICO -->
                    <div class="campo">
                        <label for="email" class="campo-label">
                            Correo electrónico
                        </label>

                        <input
                            id="email"
                            class="campo-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="usuario@ejemplo.com"
                            required
                            autofocus
                            autocomplete="username"
                            inputmode="email"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                        >

                        @error('email')
                            <p class="error" id="email-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- CONTRASEÑA -->
                    <div class="campo">
                        <label for="password" class="campo-label">
                            Contraseña
                        </label>

                        <div class="password-contenedor">
                            <input
                                id="password"
                                class="campo-input"
                                type="password"
                                name="password"
                                placeholder="Ingresa tu contraseña"
                                required
                                autocomplete="current-password"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                            >

                            <button
                                type="button"
                                class="mostrar-password"
                                id="togglePassword"
                                aria-controls="password"
                                aria-pressed="false"
                            >
                                Mostrar
                            </button>
                        </div>

                        @error('password')
                            <p class="error" id="password-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- OPCIONES DE SESIÓN -->
                    <div class="opciones">

                        <label for="remember_me" class="recordar">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                value="1"
                                @checked(old('remember'))
                            >
                            Recordar mi sesión
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="recuperar">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif

                    </div>

                    <!-- BOTÓN DE ACCESO -->
                    <button type="submit" class="boton">
                        Iniciar sesión

                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </button>

                </form>

                <div class="seguridad">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>

                    <span>
                        Acceso exclusivo para personal autorizado.
                        No compartas tus credenciales.
                    </span>
                </div>

            </div>
        </div>
    </main>

    <!-- PIE DE PÁGINA -->
    <footer class="pie">
        <div class="contenedor pie-contenido">

            <div class="pie-nombre">
                Dulce Noviembre <span>· Pedidos</span>
            </div>

            <p class="pie-nota">
                Sistema de gestión interna &copy; {{ date('Y') }}
            </p>

        </div>
    </footer>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const mostrar = passwordInput.type === 'password';

            passwordInput.type = mostrar ? 'text' : 'password';
            togglePassword.textContent = mostrar ? 'Ocultar' : 'Mostrar';
            togglePassword.setAttribute('aria-pressed', String(mostrar));
        });
    </script>

</body>
</html>
