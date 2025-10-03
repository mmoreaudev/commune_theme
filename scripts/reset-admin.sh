#!/bin/bash

echo "🔄 Réinitialisation du mot de passe administrateur..."

# Nouveau mot de passe par défaut
NEW_PASSWORD="Admin123!"

# Réinitialiser le mot de passe
docker exec mairie_php php -r "
    try {
        \$db = new PDO('sqlite:/var/www/html/database/mairie.db');
        \$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        \$hashedPassword = password_hash('$NEW_PASSWORD', PASSWORD_BCRYPT);
        
        \$stmt = \$db->prepare('UPDATE users SET password = ? WHERE role = \"admin\" LIMIT 1');
        \$stmt->execute([\$hashedPassword]);
        
        if (\$stmt->rowCount() > 0) {
            echo 'Mot de passe administrateur réinitialisé avec succès' . PHP_EOL;
        } else {
            echo 'Aucun administrateur trouvé' . PHP_EOL;
            exit(1);
        }
    } catch (Exception \$e) {
        echo 'Erreur: ' . \$e->getMessage() . PHP_EOL;
        exit(1);
    }
"

if [ $? -eq 0 ]; then
    echo "✅ Mot de passe réinitialisé"
    echo ""
    echo "🔐 Nouveaux identifiants:"
    echo "   - Email: admin@mairie.fr"
    echo "   - Mot de passe: $NEW_PASSWORD"
    echo ""
    echo "⚠️  Changez ce mot de passe après connexion!"
else
    echo "❌ Erreur lors de la réinitialisation"
    exit 1
fi