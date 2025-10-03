#!/bin/bash

echo "🏛️  Installation CMS Mairie..."
echo "================================"

# Vérifier si Docker est installé
if ! command -v docker &> /dev/null; then
    echo "❌ Docker n'est pas installé. Veuillez installer Docker avant de continuer."
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose n'est pas installé. Veuillez installer Docker Compose avant de continuer."
    exit 1
fi

# Créer le fichier .env depuis l'exemple
if [ ! -f .env ]; then
    echo "📝 Création du fichier .env..."
    cp .env.example .env
    echo "✅ Fichier .env créé"
else
    echo "📝 Fichier .env déjà existant"
fi

# Créer les répertoires nécessaires
echo "📁 Création des répertoires..."
mkdir -p public/uploads/{images,documents,avatars}
mkdir -p database
mkdir -p storage/logs

# Définir les permissions
chmod -R 755 public/uploads/
chmod -R 755 database/
chmod -R 755 storage/

echo "✅ Répertoires créés"

# Démarrer les conteneurs
echo "🐳 Démarrage des conteneurs Docker..."
docker-compose up -d

# Attendre que les conteneurs soient prêts
echo "⏳ Attente du démarrage des services..."
sleep 10

# Exécuter les migrations
echo "📦 Création de la base de données..."
docker exec mairie_php php -r "
    try {
        \$db = new PDO('sqlite:/var/www/html/database/mairie.db');
        \$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        \$sql = file_get_contents('/var/www/html/database/migrations/init.sql');
        \$db->exec(\$sql);
        
        echo 'Base de données créée avec succès' . PHP_EOL;
    } catch (Exception \$e) {
        echo 'Erreur: ' . \$e->getMessage() . PHP_EOL;
        exit(1);
    }
"

if [ $? -ne 0 ]; then
    echo "❌ Erreur lors de la création de la base de données"
    exit 1
fi

echo "✅ Base de données créée"

# Insérer les données par défaut
echo "🌱 Insertion des données initiales..."
docker exec mairie_php php -r "
    try {
        \$db = new PDO('sqlite:/var/www/html/database/mairie.db');
        \$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        \$sql = file_get_contents('/var/www/html/database/seeds/default_data.sql');
        \$db->exec(\$sql);
        
        echo 'Données initiales insérées avec succès' . PHP_EOL;
    } catch (Exception \$e) {
        echo 'Erreur: ' . \$e->getMessage() . PHP_EOL;
        exit(1);
    }
"

if [ $? -ne 0 ]; then
    echo "❌ Erreur lors de l'insertion des données"
    exit 1
fi

echo "✅ Données initiales insérées"

# Créer l'administrateur par défaut
echo "👤 Création de l'administrateur..."
docker exec mairie_php php -r "
    try {
        \$db = new PDO('sqlite:/var/www/html/database/mairie.db');
        \$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        \$admin = [
            'username' => 'admin',
            'email' => 'admin@mairie.fr',
            'password' => password_hash('Admin123!', PASSWORD_BCRYPT),
            'role' => 'admin',
            'full_name' => 'Administrateur',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        \$stmt = \$db->prepare('INSERT INTO users (username, email, password, role, full_name, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        \$stmt->execute(array_values(\$admin));
        
        echo 'Administrateur créé avec succès' . PHP_EOL;
    } catch (Exception \$e) {
        echo 'Erreur: ' . \$e->getMessage() . PHP_EOL;
        exit(1);
    }
"

if [ $? -ne 0 ]; then
    echo "❌ Erreur lors de la création de l'administrateur"
    exit 1
fi

echo "✅ Administrateur créé"

# Définir les permissions finales
echo "🔐 Configuration des permissions..."
docker exec mairie_php chown -R www-data:www-data /var/www/html/database
docker exec mairie_php chown -R www-data:www-data /var/www/html/public/uploads
docker exec mairie_php chown -R www-data:www-data /var/www/html/storage

echo "✅ Permissions configurées"

echo ""
echo "🎉 Installation terminée avec succès!"
echo "================================"
echo ""
echo "📍 Accès au site:"
echo "   - Site public: http://localhost:8024"
echo "   - Administration: http://localhost:8024/admin"
echo ""
echo "🔐 Identifiants administrateur:"
echo "   - Email: admin@mairie.fr"
echo "   - Mot de passe: Admin123!"
echo ""
echo "⚠️  IMPORTANT:"
echo "   - Changez le mot de passe administrateur après la première connexion"
echo "   - Modifiez les paramètres du site dans l'administration"
echo "   - Configurez les informations de votre commune"
echo ""
echo "📚 Documentation:"
echo "   - README.md pour plus d'informations"
echo "   - Consultez /admin pour gérer votre site"
echo ""
echo "🎯 Prochaines étapes:"
echo "   1. Se connecter à l'administration"
echo "   2. Changer le mot de passe"
echo "   3. Configurer les informations de la commune"
echo "   4. Ajouter du contenu (articles, événements, etc.)"
echo ""