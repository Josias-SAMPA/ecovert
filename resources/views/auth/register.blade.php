<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - ECO-VERT</title>
    <link rel="stylesheet" href="{{ asset('files/style.css') }}">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--sand);
            padding: 20px;
        }
        .auth-form {
            background: white;
            border-radius: var(--radius-card);
            padding: 40px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .auth-form h1 {
            font-family: var(--font-display);
            font-size: 2rem;
            color: var(--forest-deep);
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--ink);
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--crop-green);
        }
        .error-text {
            color: var(--terracotta-alert);
            font-size: 0.875rem;
            margin-top: 5px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--forest-deep);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }
        .btn-submit:hover {
            background: var(--crop-green);
        }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .auth-footer a {
            color: var(--crop-green);
            text-decoration: none;
            font-weight: 600;
        }
        .role-info {
            font-size: 0.875rem;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h1>Inscription</h1>
            
            @if ($errors->any())
                <div style="background: #ffe6e6; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    @foreach ($errors->all() as $error)
                        <p style="color: var(--terracotta-alert); margin: 5px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="country">Pays</label>
                    <input type="text" id="country" name="country" value="{{ old('country') }}" placeholder="Ex: Sénégal">
                    @error('country')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Je suis</label>
                    <select id="role" name="role" required>
                        <option value="">-- Sélectionner un rôle --</option>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Utilisateur (Agriculteur)</option>
                        <option value="partner" {{ old('role') === 'partner' ? 'selected' : '' }}>Partenaire</option>
                    </select>
                    <p class="role-info">Les administrateurs sont invités uniquement.</p>
                    @error('role')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                    <p class="role-info">Minimum 8 caractères</p>
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">S'inscrire</button>
            </form>

            <div class="auth-footer">
                <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
                <p><a href="{{ route('index') }}">Retour à l'accueil</a></p>
            </div>
        </div>
    </div>
</body>
</html>
