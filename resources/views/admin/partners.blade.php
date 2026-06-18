<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Partenaires - ECO-VERT Admin</title>
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
            color: var(--forest-deep);
            margin-bottom: 10px;
        }
        .partner-card {
            background: white;
            padding: 20px;
            border-radius: var(--radius-card);
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 5px solid var(--crop-green);
        }
        .partner-card.pending {
            border-left-color: var(--ochre);
        }
        .partner-card.rejected {
            border-left-color: var(--terracotta-alert);
        }
        .partner-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        .partner-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--forest-deep);
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .partner-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-item {
            padding: 10px;
            background: var(--sand);
            border-radius: 5px;
        }
        .info-label {
            font-size: 0.875rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .info-value {
            font-weight: 600;
            color: var(--forest-deep);
            margin-top: 5px;
        }
        .partner-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .btn-view {
            background: var(--crop-green);
            color: white;
        }
        .btn-approve {
            background: #28a745;
            color: white;
        }
        .btn-reject {
            background: var(--terracotta-alert);
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="{{ route('index') }}">ECO-VERT</a>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users') }}">Utilisateurs</a>
            <a href="{{ route('admin.partners') }}">Partenaires</a>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Gestion des Partenaires</h1>
            <p>Total : {{ $partners->total() }} partenaires</p>
        </div>

        @forelse($partners as $partner)
            <div class="partner-card {{ $partner->status }}">
                <div class="partner-header">
                    <div>
                        <div class="partner-name">{{ $partner->company_name }}</div>
                        <p style="color: #666; margin-top: 5px;">{{ $partner->user->name }} ({{ $partner->user->email }})</p>
                    </div>
                    <span class="status-badge status-{{ $partner->status }}">
                        {{ ucfirst($partner->status) }}
                    </span>
                </div>

                <div class="partner-info">
                    <div class="info-item">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ ucfirst($partner->type) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Contact</div>
                        <div class="info-value">{{ $partner->contact_email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Site Web</div>
                        <div class="info-value">{{ $partner->website ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Statut</div>
                        <div class="info-value">{{ $partner->is_active ? '✓ Actif' : '✗ Inactif' }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <p style="color: #666; font-size: 0.9rem;"><strong>Description :</strong></p>
                    <p style="color: #333; line-height: 1.6;">{{ $partner->description ?? 'Aucune description' }}</p>
                </div>

                <div class="partner-actions">
                    <a href="{{ route('admin.partners.view', $partner) }}" class="btn btn-view">Voir Détails</a>
                    
                    @if($partner->status === 'pending')
                        <form action="{{ route('admin.partners.approve', $partner) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-approve">Approuver</button>
                        </form>
                        <form action="{{ route('admin.partners.reject', $partner) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-reject">Rejeter</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div style="background: white; padding: 30px; border-radius: var(--radius-card); text-align: center; color: #666;">
                <p>Aucun partenaire trouvé</p>
            </div>
        @endforelse

        <div style="margin-top: 30px;">
            {{ $partners->links() }}
        </div>
    </div>
</body>
</html>
