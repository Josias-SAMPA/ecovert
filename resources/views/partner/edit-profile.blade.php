<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer Profil Partenaire - ECO-VERT</title>
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
            max-width: 700px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .form-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius-card);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-card h1 {
            color: var(--crop-green);
            margin-bottom: 30px;
            font-family: var(--font-display);
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
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            font-family: inherit;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--crop-green);
        }
        .error-text {
            color: var(--terracotta-alert);
            font-size: 0.875rem;
            margin-top: 5px;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--crop-green);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }
        .btn-submit:hover {
            background: var(--forest-deep);
        }
        .help-text {
            font-size: 0.875rem;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="{{ route('index') }}">ECO-VERT</a>
            <a href="{{ route('partner.dashboard') }}">Dashboard</a>
            <a href="{{ route('partner.profile') }}">Profil</a>
        </div>
    </nav>

    <div class="container">
        <div class="form-card">
            <h1>Éditer Profil Partenaire</h1>

            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #ffe6e6; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    @foreach ($errors->all() as $error)
                        <p style="color: var(--terracotta-alert); margin: 5px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('partner.profile.post') }}">
                @csrf

                <div class="form-group">
                    <label for="company_name">Nom de l'entreprise *</label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $partner->company_name ?? '') }}" required>
                    @error('company_name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Type de partenaire *</label>
                    <select id="type" name="type" required>
                        <option value="institutional" {{ old('type', $partner->type ?? '') === 'institutional' ? 'selected' : '' }}>
                            Partenaire Institutionnel
                        </option>
                        <option value="technical" {{ old('type', $partner->type ?? '') === 'technical' ? 'selected' : '' }}>
                            Partenaire Technique
                        </option>
                        <option value="investor" {{ old('type', $partner->type ?? '') === 'investor' ? 'selected' : '' }}>
                            Investisseur
                        </option>
                    </select>
                    <p class="help-text">Sélectionnez votre type de partenariat</p>
                    @error('type')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_email">Email de contact *</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $partner->contact_email ?? '') }}" required>
                        @error('contact_email')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="website">Site Web</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $partner->website ?? '') }}" placeholder="https://example.com">
                        @error('website')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Décrivez votre entreprise et vos objectifs de partenariat...">{{ old('description', $partner->description ?? '') }}</textarea>
                    <p class="help-text">Présentez votre entreprise et vos intérêts</p>
                    @error('description')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</body>
</html>
