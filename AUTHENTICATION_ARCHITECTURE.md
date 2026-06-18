# ECO-VERT - Architecture Système d'Authentification et Gestion des Rôles

## 📋 Vue d'ensemble

L'application ECO-VERT dispose désormais d'une infrastructure complète d'authentification avec gestion des rôles, incluant :
- **Utilisateurs** (agriculteurs)
- **Partenaires** (institutionnels, techniques, investisseurs)
- **Administrateurs** (gestion de la plateforme)

---

## 🗂️ Structure du Projet

### 1. **Modèles (Models)**

#### `User` (`app/Models/User.php`)
- Authenticable avec hachage du mot de passe
- Rôles : `user`, `partner`, `admin`
- Relations : `hasOne(Partner)`, `hasOne(Admin)`
- Méthodes helpers : `isAdmin()`, `isPartner()`, `isUser()`

#### `Partner` (`app/Models/Partner.php`)
- Profil complet pour les partenaires
- Champs : `company_name`, `type`, `description`, `website`, `contact_email`, `logo`, `status`, `is_active`
- Status : `pending`, `approved`, `rejected`

#### `Admin` (`app/Models/Admin.php`)
- Profil administrateur
- Niveaux de permission : `viewer`, `editor`, `superadmin`

#### `Role` (`app/Models/Role.php`)
- Modèle de référence pour les rôles (optionnel pour extensions futures)

---

## 🗄️ Tables Base de Données

### `users`
```sql
- id (bigint, PK)
- name (string)
- email (string, unique)
- password (string, hashed)
- role (enum: user, partner, admin)
- bio (text, nullable)
- phone (string, nullable)
- country (string, nullable)
- is_active (boolean, default: true)
- email_verified_at (timestamp, nullable)
- remember_token (string, nullable)
- timestamps
```

### `partners`
```sql
- id (bigint, PK)
- user_id (bigint, FK)
- company_name (string)
- type (enum: institutional, technical, investor)
- description (text, nullable)
- website (string, nullable)
- contact_email (string)
- logo (string, nullable)
- status (enum: pending, approved, rejected)
- is_active (boolean, default: true)
- timestamps
```

### `admins`
```sql
- id (bigint, PK)
- user_id (bigint, FK)
- permission_level (enum: viewer, editor, superadmin)
- timestamps
```

### `roles`
```sql
- id (bigint, PK)
- name (string, unique)
- description (text, nullable)
- timestamps
```

---

## 🔐 Authentification

### Routes d'Authentification
- **GET** `/login` - Affiche le formulaire de connexion
- **POST** `/login` - Traite la connexion
- **GET** `/register` - Affiche le formulaire d'inscription
- **POST** `/register` - Traite l'inscription (rôles : user, partner)
- **POST** `/logout` - Déconnexion (protected)

### Contrôleur : `AuthController`
- `showLogin()` - Affiche la vue login
- `showRegister()` - Affiche la vue register
- `login(Request)` - Authentifie l'utilisateur
- `register(Request)` - Crée un nouvel utilisateur
- `logout(Request)` - Déconnecte l'utilisateur

---

## 👥 Dashboards

### Dashboard Utilisateur
- **URL** : `/dashboard`
- **Route** : `user.dashboard`
- **Middleware** : `auth`, `user`
- **Contrôleur** : `DashboardController@userDashboard`
- **Vue** : `dashboard/user.blade.php`

### Dashboard Partenaire
- **URL** : `/partner/dashboard`
- **Route** : `partner.dashboard`
- **Middleware** : `auth`, `partner`
- **Contrôleur** : `DashboardController@partnerDashboard`
- **Vue** : `dashboard/partner.blade.php`

#### Routes supplémentaires partenaire :
- `GET` `/partner/profile` - Éditer le profil (`partner.profile`)
- `POST` `/partner/profile` - Enregistrer les modifications
- `GET` `/partner/analytics` - Tableau des analytics

### Dashboard Administrateur
- **URL** : `/admin/dashboard`
- **Route** : `admin.dashboard`
- **Middleware** : `auth`, `admin`
- **Contrôleur** : `DashboardController@adminDashboard`
- **Vue** : `dashboard/admin.blade.php`

#### Routes supplémentaires admin :
- `GET` `/admin/users` - Liste des utilisateurs
- `PATCH` `/admin/users/{user}/toggle-status` - Activer/désactiver utilisateur
- `DELETE` `/admin/users/{user}` - Supprimer utilisateur
- `GET` `/admin/partners` - Liste des partenaires
- `GET` `/admin/partners/{partner}` - Détails d'un partenaire
- `PATCH` `/admin/partners/{partner}/approve` - Approuver un partenaire
- `PATCH` `/admin/partners/{partner}/reject` - Rejeter un partenaire

---

## 🛡️ Middlewares

### CheckAdmin (`app/Http/Middleware/CheckAdmin.php`)
- Vérifie que l'utilisateur est connecté ET admin
- Retourne 403 sinon
- Alias : `admin`

### CheckPartner (`app/Http/Middleware/CheckPartner.php`)
- Vérifie que l'utilisateur est connecté ET partenaire
- Retourne 403 sinon
- Alias : `partner`

### CheckUser (`app/Http/Middleware/CheckUser.php`)
- Vérifie simplement que l'utilisateur est connecté
- Redirige vers `/login` sinon
- Alias : `user`

---

## 🎨 Vues Blade Créées

### Authentication
- `resources/views/auth/login.blade.php` - Formulaire de connexion
- `resources/views/auth/register.blade.php` - Formulaire d'inscription

### Dashboards
- `resources/views/dashboard/user.blade.php` - Dashboard utilisateur
- `resources/views/dashboard/partner.blade.php` - Dashboard partenaire
- `resources/views/dashboard/admin.blade.php` - Dashboard admin

### Admin Management
- `resources/views/admin/users.blade.php` - Liste des utilisateurs
- `resources/views/admin/partners.blade.php` - Liste des partenaires
- `resources/views/admin/partner-detail.blade.php` - Détails d'un partenaire

### Partner Management
- `resources/views/partner/edit-profile.blade.php` - Édition du profil partenaire
- `resources/views/partner/analytics.blade.php` - Analytics partenaire

---

## 👤 Utilisateur Admin Par Défaut

**Email** : `admin@ecovert.local`  
**Mot de passe** : `admin123`  
**Rôle** : `admin`  
**Permission** : `superadmin`

> ⚠️ **Important** : Changer le mot de passe après la première connexion !

---

## 🔄 Flux d'Authentification

### Inscription
1. L'utilisateur choisit un rôle (`user` ou `partner`)
2. Les données sont validées
3. Un nouvel utilisateur est créé avec le rôle sélectionné
4. L'utilisateur est automatiquement connecté
5. Si partenaire → redirection vers `/partner/dashboard`
6. Si utilisateur → redirection vers `/dashboard`

### Connexion
1. L'utilisateur entre son email et mot de passe
2. Les credentials sont vérifiés
3. Session est créée
4. Redirection basée sur le rôle :
   - Admin → `/admin/dashboard`
   - Partenaire → `/partner/dashboard`
   - Utilisateur → `/dashboard`

### Déconnexion
1. Session est invalidée
2. Token régénéré
3. Redirection vers la page d'accueil

---

## 📊 Contrôleurs

### `AuthController`
Gère l'authentification complète (login, register, logout)

### `DashboardController`
Affiche les dashboards appropriés selon le rôle

### `AdminController`
- Gestion des utilisateurs (liste, activation/désactivation, suppression)
- Gestion des partenaires (liste, approbation, rejet, détails)

### `PartnerController`
- Édition du profil partenaire
- Analytics/statistiques

---

## 🚀 Utilisation

### Pour tester l'admin :
```
Email : admin@ecovert.local
Mot de passe : admin123
```

### Pour créer un utilisateur normal :
- Accédez à `/register`
- Sélectionnez "Utilisateur (Agriculteur)" comme rôle
- Complétez le formulaire

### Pour créer un partenaire :
- Accédez à `/register`
- Sélectionnez "Partenaire" comme rôle
- Complétez le formulaire (sera en attente d'approbation)

---

## 🔧 Extensions Futures

1. **Email Verification** - Vérification d'email
2. **Two-Factor Authentication** - 2FA
3. **Permissions Granulaires** - ACL (Access Control List)
4. **Audit Logging** - Journalisation des actions
5. **Notifications** - Système de notifications
6. **Profile Pictures** - Upload d'avatars
7. **Activity Timeline** - Historique des activités

---

## 📝 Notes de Configuration

- Les middlewares sont enregistrés dans `bootstrap/app.php`
- Les routes sont organisées par rôle dans `routes/web.php`
- Les vues partagent le CSS d'ECO-VERT
- Les validations sont côté serveur

---

**Créé le** : 2026-06-18  
**Version** : 1.0.0
