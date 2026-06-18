<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ECO-VERT</title>
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
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
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
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h1>Connexion</h1>
            
            @if ($errors->any())
                <div style="background: #ffe6e6; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    @foreach ($errors->all() as $error)
                        <p style="color: var(--terracotta-alert); margin: 5px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Se connecter</button>
            </form>

            <div class="auth-footer">
                <p>Pas de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
                <p><a href="{{ route('index') }}">Retour à l'accueil</a></p>
            </div>
        </div>
    </div>
</body>
</html>
