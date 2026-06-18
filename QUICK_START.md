# 🚀 Guide de Démarrage Rapide - ECO-VERT Auth System

## ✨ Qu'est-ce qui a été créé ?

Une **plateforme complète d'authentification et gestion de rôles** pour ECO-VERT avec :

- 👤 **3 rôles** : Utilisateur (agriculteur), Partenaire, Administrateur
- 📊 **3 dashboards** personnalisés par rôle
- 🔐 **Authentification** sécurisée (hachage bcrypt)
- 👥 **Gestion des utilisateurs** et partenaires
- ⚡ **Middlewares** de contrôle d'accès
- 📱 **Vues Blade** design cohérent avec ECO-VERT

---

## 🧪 Tester l'Application

### 1️⃣ Démarrer le Serveur Local

```bash
cd s:\ecovert
php artisan serve
```

L'app sera disponible à `http://localhost:8000`

---

### 2️⃣ Tester avec Admin

Accédez à : **http://localhost:8000/login**

```
Email    : admin@ecovert.local
Mot de passe : admin123
```

✅ Vous arriverez au dashboard admin avec :
- Liste des utilisateurs
- Gestion des partenaires
- Statistiques globales

---

### 3️⃣ S'Inscrire comme Agriculteur

Accédez à : **http://localhost:8000/register**

1. Cliquez sur "Créer un compte" ou allez directement à `/register`
2. Remplissez le formulaire
3. Sélectionnez : **"Utilisateur (Agriculteur)"**
4. Validez

✅ Vous arriverez à votre dashboard utilisateur

---

### 4️⃣ S'Inscrire comme Partenaire

Accédez à : **http://localhost:8000/register**

1. Remplissez le formulaire
2. Sélectionnez : **"Partenaire"**
3. Validez

✅ Vous arriverez à votre dashboard partenaire
⚠️ Votre statut sera "En attente d'approbation"

---

### 5️⃣ Approuver un Partenaire (Admin)

1. Connectez-vous en tant qu'admin
2. Allez à `/admin/partners`
3. Cliquez "Approuver" sur un partenaire
4. Le partenaire peut maintenant voir "Approuvé" dans son dashboard

---

## 📍 Routes Principales

### Public
```
/              → Page d'accueil ECO-VERT
/login         → Connexion
/register      → Inscription
```

### Utilisateur
```
/dashboard              → Mon tableau de bord
/logout                 → Déconnexion
```

### Partenaire
```
/partner/dashboard      → Tableau de bord partenaire
/partner/profile        → Éditer mon profil
/partner/analytics      → Mes statistiques
```

### Administrateur
```
/admin/dashboard        → Tableau de bord admin
/admin/users            → Gérer les utilisateurs
/admin/partners         → Gérer les partenaires
```

---

## 🎯 Cas d'Usage à Tester

### ✅ Cas 1 : Cycle Complet Partenaire
1. Inscription en tant que partenaire
2. Remplissage du profil (`/partner/profile`)
3. Connexion admin
4. Approbation du partenaire
5. Partenaire voit son statut "Approuvé"

### ✅ Cas 2 : Gestion Utilisateurs (Admin)
1. Connexion admin
2. Allez à `/admin/users`
3. Tesquez activer/désactiver un utilisateur
4. Téstez supprimer un utilisateur

### ✅ Cas 3 : Partenaire Complet
1. Inscription partenaire
2. Édition du profil complet
3. Vérification du dashboard partenaire
4. Consultation des analytics

### ✅ Cas 4 : Isolation des Rôles
1. Connectez-vous en tant qu'utilisateur
2. Essayez d'accéder à `/admin/dashboard` → 403 Forbidden ✓
3. Essayez d'accéder à `/partner/dashboard` → 403 Forbidden ✓

---

## 📝 Formulaires Disponibles

### Login
```
Email
Mot de passe
[Se connecter]
```

### Register
```
Nom complet
Email
Pays
Je suis (Utilisateur / Partenaire)
Mot de passe (min 8 caractères)
Confirmer mot de passe
[S'inscrire]
```

### Éditer Profil Partenaire
```
Nom de l'entreprise
Type de partenaire (Institutionnel / Technique / Investisseur)
Email de contact
Site Web
Description
[Enregistrer]
```

---

## 🔍 Vérifications Importantes

### Database
```bash
php artisan tinker
>>> \App\Models\User::all()
>>> \App\Models\Admin::all()
>>> \App\Models\Partner::all()
```

### Migrations
```bash
php artisan migrate:status
```

### Routes
```bash
php artisan route:list
```

---

## 🛠️ Commandes Utiles

```bash
# Réinitialiser la base de données
php artisan migrate:reset
php artisan migrate
php artisan db:seed

# Vider le cache
php artisan cache:clear

# Générer une clé d'app
php artisan key:generate

# Accéder à la console
php artisan tinker
```

---

## 🎨 Design & Styles

Toutes les vues utilisent le **CSS ECO-VERT** depuis `public/files/style.css` :

```html
<link rel="stylesheet" href="{{ asset('files/style.css') }}">
```

Couleurs primaires utilisées :
- 🟢 `--forest-deep` (#0F3D2E) - Couleur primaire
- 🟢 `--crop-green` (#2B6E5C) - Couleur secondaire
- 🟡 `--ochre` (#D4A24C) - Accent
- 🟤 `--sand` (#F5EFE3) - Background

---

## 📊 Structure Rappel

### Models
- `User` - Utilisateur avec rôles (user, partner, admin)
- `Partner` - Profil partenaire
- `Admin` - Profil administrateur
- `Role` - Modèle de référence

### Contrôleurs
- `AuthController` - Login, Register, Logout
- `DashboardController` - Affichage des dashboards
- `AdminController` - Gestion des utilisateurs et partenaires
- `PartnerController` - Gestion du profil partenaire

### Middlewares
- `CheckAdmin` - Vérifie que l'utilisateur est admin
- `CheckPartner` - Vérifie que l'utilisateur est partenaire
- `CheckUser` - Vérifie simplement que l'utilisateur est connecté

---

## ❓ FAQ Rapide

**Q: Comment créer un nouvel admin?**  
R: Allez dans la console et changez le rôle d'un utilisateur :
```bash
php artisan tinker
>>> $user = \App\Models\User::find(1);
>>> $user->role = 'admin';
>>> $user->save();
>>> \App\Models\Admin::create(['user_id' => 1, 'permission_level' => 'superadmin']);
```

**Q: Comment réinitialiser les données?**  
R: 
```bash
php artisan migrate:reset && php artisan migrate && php artisan db:seed
```

**Q: Les mots de passe sont-ils vraiment sécurisés?**  
R: Oui, ils sont hachés avec bcrypt par Laravel.

**Q: Comment changer le logo?**  
R: Modifiez `resources/views/layouts/` ou ajoutez votre logo dans `public/`.

---

## 📞 Support

Pour toute question sur l'architecture, consultez :
- `AUTHENTICATION_ARCHITECTURE.md` - Documentation technique complète
- `IMPLEMENTATION_SUMMARY.md` - Résumé des fichiers créés

---

**Bon test! 🎉**

Si tout fonctionne, vous êtes prêt à étendre l'application avec d'autres fonctionnalités!
