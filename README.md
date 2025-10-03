# CMS Mairie - Custom PHP

CMS sur-mesure en PHP pour sites de communes et mairies françaises.

## 🚀 Installation

### Prérequis
- Docker & Docker Compose
- Port 8024 disponible

### Installation rapide

1. **Cloner le projet**
```bash
git clone <repo>
cd commune_theme
```

2. **Démarrer Docker**
```bash
docker-compose up -d
```

3. **Installer le CMS**
```bash
chmod +x scripts/install.sh
./scripts/install.sh
```

4. **Accéder au site**
- Public: http://localhost:8024
- Admin: http://localhost:8024/admin

### Identifiants par défaut
- Email: `admin@mairie.fr`
- Password: `Admin123!`

⚠️ **Changez le mot de passe immédiatement!**

## 📦 Fonctionnalités

✅ Gestion multi-utilisateurs (Admin, Éditeur, Lecteur)  
✅ Actualités et articles  
✅ Calendrier événements  
✅ Gestion élus et conseil municipal  
✅ Publications (bulletins, magazines, délibérations)  
✅ Services municipaux  
✅ Numéros utiles avec interface simple  
✅ Associations locales  
✅ Pages FAQ et démarches  
✅ Horaires et tableaux  
✅ Widgets sidebar personnalisables  
✅ Formulaire de contact  
✅ Système de recherche  
✅ Interface admin complète  
✅ Upload fichiers (images, PDF)  
✅ Responsive design (Tailwind CSS)  
✅ Accessibilité RGAA  

## 🛠️ Technologies

- **PHP 8.2** (natif, zero framework)
- **SQLite 3** (base de données)
- **Tailwind CSS** (CDN)
- **Alpine.js** (interactivité)
- **Docker + Nginx**
- **Architecture MVC custom**

## 📂 Structure

```
commune_theme/
├── app/              # Application (MVC)
├── public/           # Document root
├── database/         # SQLite + migrations
├── storage/          # Logs
└── scripts/          # Installation
```

## 🔧 Commandes

```bash
# Démarrer
docker-compose up -d

# Arrêter
docker-compose down

# Logs
docker-compose logs -f

# Backup
./scripts/backup.sh

# Accéder au conteneur PHP
docker exec -it mairie_php sh
```

## 📊 Administration

### Gestion Utilisateurs
- Créer des comptes (admin, éditeur, lecteur)
- Gérer les permissions
- Logs d'activité

### Gestion Contenu
- CRUD complet sur toutes les entités
- Upload images et documents
- Éditeur WYSIWYG
- Prévisualisation

### Widgets Personnalisables
- Liens pratiques
- Numéros d'urgence
- Horaires
- Événements à venir

### Paramètres
- Informations mairie
- Coordonnées
- Réseaux sociaux
- Apparence

## 🔐 Sécurité

✅ Protection CSRF  
✅ Protection XSS  
✅ SQL Injection prevention  
✅ Password hashing (bcrypt)  
✅ Rate limiting login  
✅ Sessions sécurisées  
✅ Validation données  

## 🎨 Personnalisation

### Couleurs
Modifier dans `public/assets/css/custom.css`

### Templates
Modifier dans `app/Views/`

### Base de données
Ajouter migrations dans `database/migrations/`

## 📝 Développement

### Ajouter une table
1. Créer migration SQL
2. Créer Model (extend Model)
3. Créer Controller
4. Créer Views
5. Ajouter routes

### Ajouter un widget
1. Créer template dans `views/components/widgets/`
2. Ajouter type dans table widgets
3. Créer interface admin

## 🐛 Dépannage

### Base de données corrompue
```bash
docker exec mairie_php php scripts/migrate.php
```

### Permissions fichiers
```bash
docker exec mairie_php chown -R www-data:www-data /var/www/html
```

### Reset admin password
```bash
docker exec mairie_php php scripts/reset-admin.php
```

## 📜 Licence

MIT License - Libre d'utilisation

---

**Développé par:** mmoreaudev  
**Date:** 2025-10-03  
**Version:** 1.0.0