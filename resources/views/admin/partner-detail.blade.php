<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Partenaire - ECO-VERT Admin</title>
    <link rel="stylesheet" href="{{ asset('files/style.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--sand); }
        .navbar {
            background: var(--forest-deep);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .detail-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius-card);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .detail-card h1 {
            color: var(--forest-deep);
            margin-bottom: 30px;
            font-family: var(--font-display);
        }
        .info-section {
            margin-bottom: 30px;
            border-bottom: 2px solid var(--sand);
            padding-bottom: 20px;
        }
        .info-section:last-child {
            border-bottom: none;
        }
        .info-section h3 {
            color: var(--crop-green);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .info-item {
            padding: 15px;
            background: var(--sand);
            border-radius: 8px;
        }
        .info-label {
            color: #666;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 5px;
        }
        .info-value {
            color: var(--ink);
            font-weight: 600;
            word-break: break-word;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--crop-green);
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="{{ route('index') }}">ECO-VERT</a>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.partners') }}">Partenaires</a>
        </div>
    </nav>

    <div class="container">
        <a href="{{ route('admin.partners') }}" class="back-link">← Retour à la liste</a>

        <div class="detail-card">
            <h1>{{ $partner->company_name }}</h1>

            <div class="info-section">
                <h3>Informations de l'entreprise</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Type de partenaire</div>
                        <div class="info-value">{{ ucfirst($partner->type) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Site Web</div>
                        <div class="info-value">
                            @if($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" style="color: var(--crop-green);">
                                    {{ $partner->website }}
                                </a>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Contact</div>
                        <div class="info-value">{{ $partner->contact_email }}</div>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h3>Contact Responsable</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nom</div>
                        <div class="info-value">{{ $partner->user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $partner->user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Pays</div>
                        <div class="info-value">{{ $partner->user->country ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">{{ $partner->user->phone ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h3>Statut et Activité</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Statut d'approbation</div>
                        <div class="info-value">{{ ucfirst($partner->status) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Actif</div>
                        <div class="info-value">{{ $partner->is_active ? '✓ Oui' : '✗ Non' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date d'inscription</div>
                        <div class="info-value">{{ $partner->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h3>Description</h3>
                <p style="color: #333; line-height: 1.8;">
                    {{ $partner->description ?? 'Aucune description fournie' }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
