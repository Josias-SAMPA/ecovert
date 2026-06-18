<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Partenaire - ECO-VERT</title>
    <link rel="stylesheet" href="{{ asset('files/style.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--sand); }
        .navbar {
            background: var(--crop-green);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            background: white;
            padding: 30px;
            border-radius: var(--radius-card);
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header h1 {
            color: var(--crop-green);
            margin-bottom: 10px;
            font-family: var(--font-display);
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
        .stat-label {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }
        .stat-value {
            font-size: 2.2rem;
            font-weight: bold;
            color: var(--crop-green);
            font-family: var(--font-display);
        }
        .coming-soon {
            background: white;
            padding: 60px 30px;
            border-radius: var(--radius-card);
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .coming-soon h2 {
            color: var(--crop-green);
            margin-bottom: 15px;
        }
        .coming-soon p {
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="{{ route('index') }}">ECO-VERT</a>
            <a href="{{ route('partner.dashboard') }}">Dashboard</a>
            <a href="{{ route('partner.analytics') }}">Analytics</a>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Analytics - Tableau de Bord Partenaire 📊</h1>
            <p>Suivez vos performances et votre impact.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Utilisateurs engagés</div>
                <div class="stat-value">0</div>
            </div>

            <div class="stat-card" style="border-left-color: var(--ochre);">
                <div class="stat-label">Alertes envoyées</div>
                <div class="stat-value">0</div>
            </div>

            <div class="stat-card" style="border-left-color: var(--terracotta-alert);">
                <div class="stat-label">Taux d'ouverture</div>
                <div class="stat-value">-</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Taux de clics</div>
                <div class="stat-value">-</div>
            </div>
        </div>

        <div class="coming-soon">
            <h2>🚀 Graphiques détaillés en cours de développement</h2>
            <p>Les graphiques d'activité, les tendances et les rapports détaillés seront disponibles très bientôt.</p>
            <p style="color: #999; font-size: 0.9rem;">Revenez régulièrement pour découvrir vos performances complètes.</p>
        </div>
    </div>
</body>
</html>
