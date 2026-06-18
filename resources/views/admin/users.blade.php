<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - ECO-VERT Admin</title>
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
        .table-container {
            background: white;
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: var(--forest-deep);
            color: white;
            padding: 15px;
            text-align: left;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: var(--sand);
        }
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .btn-small {
            background: var(--ochre);
            color: white;
            margin-right: 5px;
        }
        .btn-danger {
            background: var(--terracotta-alert);
            color: white;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.875rem;
        }
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.875rem;
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
            <h1>Gestion des Utilisateurs</h1>
            <p>Total : {{ $users->total() }} utilisateurs</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Pays</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->country ?? '-' }}</td>
                            <td>
                                <span class="status-{{ $user->is_active ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-small">
                                        {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.delete', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #666;">Aucun utilisateur trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px;">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>
