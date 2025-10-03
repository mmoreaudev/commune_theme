# 🏛️ CMS Mairie - Content Management System

> CMS sur-mesure développé en PHP natif pour les sites de mairies et communes françaises

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker&logoColor=white)](https://docker.com)
[![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=flat&logo=sqlite&logoColor=white)](https://sqlite.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🌟 Présentation

**CMS Mairie** est une solution complète et moderne conçue spécifiquement pour les communes françaises. Développé en PHP natif avec une architecture MVC robuste, il offre tous les outils nécessaires pour créer et gérer un site web municipal professionnel.

### ✨ Points forts
- 🚀 **Déploiement en 5 minutes** avec Docker
- 🔒 **Sécurité renforcée** (CSRF, XSS, validation stricte)
- ♿ **Accessibilité RGAA** native
- 📱 **Responsive mobile-first**
- 🇫🇷 **Couleurs officielles** République Française
- 🛠️ **Zéro dépendance** externe
- 💾 **Base SQLite** légère et performante

## 🎯 Fonctionnalités

### 👨‍💼 Administration complète
- **Dashboard** avec statistiques temps réel
- **Gestion des articles** (CRUD, catégories, médias)
- **Calendrier d'événements** municipal
- **Pages statiques** configurables
- **Équipe municipale** et élus
- **Services** et démarches
- **Associations** locales
- **Messages** de contact avec notifications
- **Widgets** personnalisables
- **Système d'utilisateurs** multi-rôles
- **Sauvegarde** automatique

### 🌐 Frontend moderne
- **Design responsive** adaptatif
- **Navigation intuitive** avec fil d'Ariane
- **Moteur de recherche** intégré
- **Sidebar widgets** configurables
- **Partage social** (Facebook, Twitter)
- **Newsletter** intégrée
- **Conformité RGAA** pour l'accessibilité
- **Performance optimisée**

### 🔐 Sécurité avancée
- **Authentification** bcrypt sécurisée
- **Protection CSRF** automatique
- **Échappement XSS** systématique
- **Validation** côté serveur stricte
- **Upload** de fichiers sécurisé
- **Gestion de sessions** robuste
- **Logs d'activité** détaillés

## 🚀 Installation rapide

### Prérequis
- **Docker** & **Docker Compose**
- **2 Go RAM** minimum
- **Port 8080** disponible

### Installation en une commande

```bash
# Cloner et installer
git clone https://github.com/votre-repo/commune-cms.git
cd commune-cms
chmod +x scripts/install.sh && ./scripts/install.sh
```

### Accès immédiat
- 🌐 **Site public** : http://localhost:8080
- ⚙️ **Administration** : http://localhost:8080/admin
- 👤 **Identifiants** : `admin@mairie.fr` / `Admin123!`

## 📁 Architecture du projet

```
commune_theme/
├── 🏗️ app/                     # Application MVC
│   ├── Controllers/            # Logique métier
│   │   ├── Frontend/          # Contrôleurs publics
│   │   └── Admin/             # Contrôleurs admin
│   ├── Core/                  # Framework MVC
│   │   ├── Database.php       # ORM SQLite
│   │   ├── Router.php         # Système de routes
│   │   ├── Auth.php           # Authentification
│   │   ├── Validator.php      # Validation
│   │   └── ...
│   ├── Models/                # Modèles de données
│   ├── Views/                 # Templates PHP
│   └── Middleware/            # Sécurité & Auth
├── ⚙️ config/                  # Configuration
├── 💾 database/                # Base SQLite + migrations
├── 🌐 public/                  # Assets & point d'entrée
│   ├── assets/                # CSS/JS/Images
│   └── uploads/               # Fichiers utilisateur
├── 🔧 scripts/                 # Outils maintenance
└── 🐳 Docker + Nginx          # Infrastructure
```

## 🛠️ Développement

### Commandes essentielles

```bash
# Logs en temps réel
docker-compose logs -f

# Shell PHP
docker-compose exec php bash

# Sauvegarde
./scripts/backup.sh

# Reset admin
./scripts/reset-admin.sh
```

### Architecture MVC native

**Modèles** - ORM simple et efficace
```php
$post = new Post();
$articles = $post->findAll(['status' => 'published']);
$post->create(['title' => 'Nouveau', 'content' => '...']);
```

**Contrôleurs** - Logique métier claire
```php
class HomeController extends Controller {
    public function index() {
        $posts = $this->model('Post')->getRecent(5);
        $this->view('home', compact('posts'));
    }
}
```

**Vues** - Templates avec héritage
```php
<?php $this->layout('layouts/main', ['title' => 'Accueil']); ?>
<h1><?= htmlspecialchars($title) ?></h1>
```

### Système d'authentification

```php
// Connexion utilisateur
Auth::login($email, $password);

// Vérification de rôle
if (Auth::hasRole('admin')) {
    // Actions administrateur
}

// Utilisateur connecté
$user = Auth::user();
```

## 🎨 Personnalisation

### Couleurs et thème

Modifiez `/public/assets/css/custom.css` :

```css
:root {
    --primary-color: #000091;    /* Bleu République */
    --secondary-color: #E1000F;   /* Rouge République */
    /* Personnalisez selon vos besoins */
}
```

### Widgets personnalisés

```php
// Créer un widget
$widget = new Widget();
$widget->create([
    'title' => 'Infos pratiques',
    'content' => json_encode(['text' => 'Contenu...']),
    'type' => 'custom',
    'position' => 'sidebar'
]);
```

### Nouvelles fonctionnalités

1. **Route** dans `config/routes.php`
2. **Contrôleur** dans `app/Controllers/`
3. **Modèle** dans `app/Models/`
4. **Vue** dans `app/Views/`

## 🔒 Sécurité

### Protection intégrée

- ✅ **CSRF** sur tous les formulaires
- ✅ **XSS** avec échappement automatique
- ✅ **Validation** stricte des données
- ✅ **Upload** sécurisé avec types autorisés
- ✅ **Sessions** sécurisées
- ✅ **Mots de passe** hashés bcrypt

### Exemple validation

```php
$validator = new Validator();
$validator->required('email')->email();
$validator->required('password')->minLength(8);

if ($validator->validate($_POST)) {
    // Données valides
} else {
    $errors = $validator->getErrors();
}
```

## 🌐 Déploiement production

### Configuration serveur
- **PHP 8.2+** avec extensions : PDO, SQLite3, GD, mbstring
- **Nginx/Apache** configuré
- **HTTPS** obligatoire
- **Permissions** correctes sur `storage/` et `uploads/`

### Variables d'environnement

Copiez `.env.example` vers `.env` :

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-mairie.fr
ADMIN_EMAIL=admin@votre-mairie.fr
```

### Sécurisation production

```bash
# Permissions
sudo chown -R www-data:www-data storage/ public/uploads/
sudo chmod -R 755 storage/ public/uploads/

# Sauvegarde automatique (crontab)
0 2 * * * /path/to/scripts/backup.sh
```

## 📊 Performance

### Optimisations incluses
- 🚀 **Cache** des vues avec invalidation
- 📦 **Compression Gzip** automatique
- 🖼️ **Images** redimensionnées automatiquement
- 🗃️ **Index** de base optimisés
- ⚡ **Requêtes** optimisées

### Monitoring

```bash
# Resources système
docker stats

# Logs performance
tail -f storage/logs/app.log | grep SLOW

# Intégrité base
sqlite3 database/commune.db "PRAGMA integrity_check;"
```

## 🔧 Maintenance

### Sauvegarde/Restauration

```bash
# Sauvegarde complète
./scripts/backup.sh

# Restauration depuis sauvegarde
docker-compose exec php php restore_backup.php backup_20240101.sql
```

### Mises à jour

```bash
# Sauvegarde préventive
./scripts/backup.sh

# Mise à jour
git pull origin main
docker-compose up -d --build

# Vérification
curl -I http://localhost:8080
```

### Dépannage

**Permissions**
```bash
sudo chown -R www-data:www-data storage/ public/uploads/
sudo chmod -R 755 storage/ public/uploads/
```

**Base corrompue**
```bash
sqlite3 database/commune.db ".recover" | sqlite3 database/fixed.db
mv database/fixed.db database/commune.db
```

**Logs d'erreur**
```bash
# Application
tail -f storage/logs/app.log

# Containers
docker-compose logs --tail=50 php nginx
```

## 🗺️ Roadmap

### 📋 Version 1.1 (Q2 2024)
- [ ] **API REST** pour apps mobiles
- [ ] **Import/Export** de contenu
- [ ] **Multisites** (plusieurs communes)
- [ ] **Workflow** de validation

### 🚀 Version 1.2 (Q3 2024)
- [ ] **Éditeur WYSIWYG** riche
- [ ] **Médiathèque** avancée
- [ ] **Templates** multiples
- [ ] **Analytics** intégrées

### 🌟 Version 2.0 (2025)
- [ ] **Support PostgreSQL/MySQL**
- [ ] **Cache Redis** optionnel
- [ ] **Architecture microservices**
- [ ] **Interface moderne** (Vue.js)

## 📈 Statistiques du projet

- 📝 **15+ modèles** de données
- 🎨 **25+ vues** responsive
- 🔧 **40+ fonctionnalités** admin
- 🧪 **Tests** unitaires couverts
- 📚 **Documentation** complète
- 🏆 **Production ready**

## 🤝 Contribution

Nous accueillons toutes les contributions ! 

### Comment contribuer
1. 🍴 **Fork** le projet
2. 🌿 **Branche** : `git checkout -b feature/super-feature`
3. 💾 **Commit** : `git commit -m 'Ajout super fonctionnalité'`
4. 📤 **Push** : `git push origin feature/super-feature`
5. 🔃 **Pull Request** avec description détaillée

### Règles de contribution
- ✅ Code PSR-12 compliant
- ✅ Tests unitaires
- ✅ Documentation à jour
- ✅ Changelog mis à jour

## 📞 Support & Contact

### Aide et support
- 📧 **Email** : support@mairie-cms.fr
- 📖 **Documentation** : https://docs.mairie-cms.fr
- 🐛 **Issues** : [GitHub Issues](https://github.com/votre-repo/issues)
- 💬 **Discord** : [Communauté CMS Mairie](https://discord.gg/mairie-cms)

### Support professionnel
- 🏢 **Installation** sur serveur
- 🎓 **Formation** équipes
- 🔧 **Maintenance** dédiée
- 🎨 **Personnalisation** avancée

## 📄 Licence

Ce projet est sous **licence MIT**. Voir [LICENSE](LICENSE) pour les détails.

```
MIT License - Libre utilisation commerciale et personnelle
Copyright (c) 2024 CMS Mairie Contributors
```

## 🏆 Remerciements

- 🇫🇷 **République Française** pour les guidelines design
- 🌐 **Communauté Open Source** PHP
- 🏛️ **Mairies françaises** pour les retours utilisateurs
- 👥 **Contributeurs** du projet

---

<div align="center">

**🏛️ CMS Mairie - La solution digitale des communes françaises 🇫🇷**

[![Étoiles](https://img.shields.io/github/stars/votre-repo/commune-cms?style=social)](https://github.com/votre-repo/commune-cms)
[![Forks](https://img.shields.io/github/forks/votre-repo/commune-cms?style=social)](https://github.com/votre-repo/commune-cms/fork)

[📖 Documentation](https://docs.mairie-cms.fr) • [🚀 Demo Live](https://demo.mairie-cms.fr) • [💬 Support](mailto:support@mairie-cms.fr)

*Fait avec ❤️ pour les communes françaises*

</div>