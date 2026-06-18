<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Tableau de Bord - ECO-VERT</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.svg') }}">
    <meta name="theme-color" content="#2B6E5C">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="{{ asset('files/style.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--sand); }
        .dashboard { min-height: 100vh; }
        .navbar {
            background: var(--forest-deep);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .logout-btn {
            background: var(--terracotta-alert);
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: var(--radius-card);
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .welcome h1 {
            font-family: var(--font-display);
            color: var(--forest-deep);
            margin-bottom: 10px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: var(--radius-card);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card h3 {
            color: var(--forest-deep);
            margin-bottom: 15px;
        }
        .card p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="navbar">
            <div>
                <a href="{{ route('index') }}">ECO-VERT</a>
            </div>
            <div>
                <span>{{ $user->name }}</span> |
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </nav>

        <div class="container">
            <div class="welcome">
                <h1>Bienvenue, {{ $user->name }} ! </h1>
                <p>Vous êtes connecté en tant qu'utilisateur. Explorez les alertes météo et les bulletins disponibles.</p>
            </div>

            <div class="grid">
                <div class="card">
                    <h3> Localisation</h3>
                    <p>Pays : <strong>{{ $user->country ?? 'Non défini' }}</strong></p>
                    <p>Email : <strong>{{ $user->email }}</strong></p>
                </div>

                <div class="card">
                    <h3> Alertes</h3>
                    <p>Recevez des alertes météo en temps réel pour votre région.</p>
                </div>

                <div class="card">
                    <h3> Bulletins</h3>
                    <p>Consultez les bulletins météo localisés et les conseils techniques.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
