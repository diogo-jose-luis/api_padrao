<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Padrão</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f5f4;
        }
        header {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem 2rem;
        }
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .layout {
            display: grid;
            grid-template-columns: 1fr;
            max-width: 56rem;
            width: 100%;
            gap: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(26, 26, 0, 0.16);
        }
        @media (min-width: 1024px) {
            .layout { grid-template-columns: 1.2fr 1fr; }
        }
        .card {
            background: #fff;
            color: #1b1b18;
            padding: 2.5rem 2rem;
        }
        @media (min-width: 1024px) {
            .card { padding: 3.5rem 3rem; }
        }
        .eyebrow {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #f53003;
            margin-bottom: 0.75rem;
        }
        @media (prefers-color-scheme: dark) {
            .eyebrow { color: #ff4433; }
        }
        h1 {
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 600;
            line-height: 1.15;
            margin-bottom: 1rem;
            color: #1b1b18;
        }
        .lead {
            font-size: 1rem;
            line-height: 1.6;
            max-width: 32rem;
        }
        .muted { color: #444441; }
        .features {
            list-style: none;
            margin: 1.75rem 0 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
            font-size: 0.875rem;
            color: #2e2e2b;
        }
        .features li {
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }
        .features li::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #f53003;
            flex-shrink: 0;
        }
        @media (prefers-color-scheme: dark) {
            .features li::before { background: #ff4433; }
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-primary {
            background: #1b1b18;
            color: #fff;
            border: 1px solid #1b1b18;
        }
        .btn-primary:hover { background: #000; border-color: #000; }
        .btn-secondary {
            background: transparent;
            color: #1b1b18;
            border: 1px solid #e3e3e0;
        }
        .btn-secondary:hover { border-color: #19140035; }
        .accent-panel {
            background: #fff2f2;
            color: #1b1b18;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            text-align: center;
        }
        .logo-mark {
            width: 5rem;
            height: 5rem;
            border-radius: 1rem;
            background: #f53003;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 24px rgba(245, 48, 3, 0.25);
        }
        @media (prefers-color-scheme: dark) {
            .logo-mark { background: #f61500; box-shadow: 0 8px 24px rgba(246, 21, 0, 0.3); }
        }
        .logo-mark svg { width: 2.5rem; height: 2.5rem; color: #fff; }
        .panel-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.375rem;
            color: #1b1b18;
        }
        .panel-text {
            font-size: 0.8125rem;
            line-height: 1.5;
            max-width: 16rem;
        }
        .accent-panel .muted { color: #5a3d38; }
        .footer {
            padding: 1.25rem 2rem 2rem;
            text-align: center;
            font-size: 0.8125rem;
            line-height: 1.6;
            color: #444441;
            border-top: 1px solid #e3e3e0;
            background: #f5f5f4;
        }
        .footer a {
            color: #444441;
            text-decoration: none;
        }
        .footer a:hover { text-decoration: underline; color: #1b1b18; }
        header .btn-secondary {
            background: #fff;
        }

        @media (prefers-color-scheme: dark) {
            body { background: #0a0a0a; }
            .layout {
                box-shadow: inset 0 0 0 1px rgba(255, 250, 237, 0.12);
            }
            .card {
                background: #161615;
                color: #ededec;
                box-shadow: inset 0 0 0 1px rgba(255, 250, 237, 0.16);
            }
            h1 { color: #f5f5f4; }
            .muted { color: #c8c7c1; }
            .features { color: #e3e3e0; }
            .accent-panel {
                background: #221610;
                color: #ededec;
            }
            .panel-title { color: #f5f5f4; }
            .accent-panel .muted { color: #d4c4be; }
            .btn-primary {
                background: #ededec;
                color: #1c1c1a;
                border-color: #ededec;
            }
            .btn-primary:hover { background: #fff; border-color: #fff; }
            .btn-secondary {
                background: #161615;
                border-color: #62605b;
                color: #f5f5f4;
            }
            .btn-secondary:hover { border-color: #a1a09a; }
            header .btn-secondary { background: #161615; }
            .footer {
                background: #0a0a0a;
                color: #c8c7c1;
                border-color: #3e3e3a;
            }
            .footer a { color: #e3e3e0; }
            .footer a:hover { color: #fff; }
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ url('/api/documentation') }}" class="btn btn-secondary">
            Documentação
            <svg width="10" height="11" viewBox="0 0 10 11" fill="none" aria-hidden="true">
                <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
            </svg>
        </a>
    </header>

    <main>
        <div class="layout">
            <div class="card">
                <p class="eyebrow">REST API</p>
                <h1>API Padrão</h1>
                <p class="lead muted">
                    API REST com autenticação Sanctum para gestão de utilizadores, cargos e departamentos.
                    Respostas JSON padronizadas e documentação interativa Swagger.
                </p>

                <ul class="features">
                    <li>Autenticação com token Bearer</li>
                    <li>CRUD de utilizadores, cargos e departamentos</li>
                    <li>Upload de fotografia de perfil</li>
                </ul>

                <div class="actions">
                    <a href="{{ url('/api/documentation') }}" class="btn btn-primary">
                        Ver documentação Swagger
                        <svg width="10" height="11" viewBox="0 0 10 11" fill="none" aria-hidden="true">
                            <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                        </svg>
                    </a>
                    <a href="{{ url('/api/login') }}" class="btn btn-secondary">Endpoint /api/login</a>
                </div>
            </div>

            <div class="accent-panel">
                <div class="logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h10"/>
                        <circle cx="19" cy="18" r="2"/>
                    </svg>
                </div>
                <p class="panel-title">OpenAPI 3.0</p>
                <p class="panel-text muted">
                    Explore e teste todos os endpoints diretamente no navegador.
                </p>
            </div>
        </div>
    </main>

    <footer class="footer">
        Desenvolvida por Diogo Luis ·
        <a href="mailto:diogo.luis.job@hotmail.com">diogo.luis.job@hotmail.com</a> ·
        <a href="tel:+244936551407">+244 936 551 407</a>
    </footer>
</body>
</html>
