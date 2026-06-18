<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin - ECO-VERT</title>
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: var(--radius-card);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 5px solid var(--crop-green);
        }
        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--forest-deep);
            font-family: var(--font-display);
        }
        .action-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .action-link {
            display: block;
            padding: 20px;
            background: white;
            border-radius: var(--radius-card);
            text-decoration: none;
            color: var(--forest-deep);
            font-weight: 600;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .action-link:hover {
            background: var(--crop-green);
            color: white;
            transform: translateY(-5px);
        }
        .alert {
            background: #fff3cd;
            border-left: 5px solid var(--ochre);
            padding: 20px;
            border-radius: var(--radius-card);
            margin-bottom: 20px;
        }
        .alert-title {
            font-weight: 600;
            color: #856404;
            margin-bottom: 10px;
        }
        .alert p {
            color: #856404;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="navbar">
            <div>
                <a href="{{ route('index') }}">ECO-VERT</a>
                <span>Panneau d'Administration</span>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </nav>

        <div class="container">
            <div class="welcome">
                <h1>Tableau de Bord Administrateur </h1>
                <p>Gérez les utilisateurs, les partenaires et l'ensemble de la plateforme.</p>
            </div>

            @if($pendingPartners > 0)
                <div class="alert">
                    <div class="alert-title"> Partenaires en attente d'approbation</div>
                    <p>{{ $pendingPartners }} nouveau(x) partenaire(s) en attente de votre approbation.</p>
                </div>
            @endif

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Utilisateurs totaux</h3>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>

                <div class="stat-card" style="border-left-color: var(--ochre);">
                    <h3>Partenaires</h3>
                    <div class="stat-value">{{ $totalPartners }}</div>
                </div>

                <div class="stat-card" style="border-left-color: var(--terracotta-alert);">
                    <h3>En attente d'approbation</h3>
                    <div class="stat-value">{{ $pendingPartners }}</div>
                </div>
            </div>

            <div class="action-links">
                <a href="{{ route('admin.users') }}" class="action-link"> Gérer les Utilisateurs</a>
                <a href="{{ route('admin.partners') }}" class="action-link"> Gérer les Partenaires</a>
                <a href="#" class="action-link" style="opacity: 0.6; cursor: not-allowed;">📊 Rapports</a>
                <a href="#" class="action-link" style="opacity: 0.6; cursor: not-allowed;">⚙️ Paramètres</a>
            </div>
        </div>
    </div>
</body>
</html>
