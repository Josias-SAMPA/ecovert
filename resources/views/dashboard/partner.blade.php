<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Partenaire - ECO-VERT</title>
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
            background: var(--crop-green);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a, .navbar button { color: white; text-decoration: none; margin-right: 20px; }
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
            color: var(--crop-green);
            margin-bottom: 10px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: var(--radius-card);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card h3 {
            color: var(--crop-green);
            margin-bottom: 15px;
            border-bottom: 2px solid var(--ochre);
            padding-bottom: 10px;
        }
        .card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 10px;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-primary {
            background: var(--crop-green);
            color: white;
        }
        .btn-secondary {
            background: var(--ochre);
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="navbar">
            <div>
                <a href="{{ route('index') }}">ECO-VERT</a>
                <span>Espace Partenaire</span>
            </div>
            <div>
                <a href="{{ route('partner.profile') }}">Profil</a>
                <a href="{{ route('partner.analytics') }}">Analytics</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </nav>

        <div class="container">
            <div class="welcome">
                <h1>Tableau de Bord Partenaire </h1>
                <p>Bienvenue {{ $user->name }}. Gérez votre partenariat et suivez votre activité.</p>
            </div>

            <div class="grid">
                <div class="card">
                    <h3> Informations de Partenariat</h3>
                    @if($partner)
                        <p><strong>Entreprise :</strong> {{ $partner->company_name }}</p>
                        <p><strong>Type :</strong> {{ ucfirst($partner->type) }}</p>
                        <p><strong>Email :</strong> {{ $partner->contact_email }}</p>
                        <p><strong>Site :</strong> {{ $partner->website ?? 'Non défini' }}</p>
                        <span class="status-badge status-{{ $partner->status }}">
                            {{ ucfirst($partner->status) }}
                        </span>
                    @else
                        <p>Aucun profil partenaire créé. Complétez votre profil.</p>
                    @endif
                </div>

                <div class="card">
                    <h3>Statistiques</h3>
                    <p>Utilisateurs engagés : <strong>0</strong></p>
                    <p>Alertes envoyées : <strong>0</strong></p>
                    <p>Taux d'activation : <strong>0%</strong></p>
                </div>

                <div class="card">
                    <h3> Intégrations</h3>
                    <p>Connectez vos canaux de diffusion (SMS, WhatsApp, App).</p>
                    <div class="actions">
                        <button class="btn btn-primary" disabled>Ajouter Canal</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3> Description du Partenariat</h3>
                <p>{{ $partner->description ?? 'Aucune description fournie' }}</p>
                <div class="actions">
                    <a href="{{ route('partner.profile') }}" class="btn btn-secondary">Modifier le Profil</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
