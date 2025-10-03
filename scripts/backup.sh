#!/bin/bash

echo "💾 Sauvegarde de la base de données..."

# Créer le répertoire de sauvegarde
mkdir -p backup

# Nom du fichier de sauvegarde avec timestamp
BACKUP_FILE="backup/mairie_backup_$(date +%Y%m%d_%H%M%S).db"

# Copier la base de données
docker exec mairie_php cp /var/www/html/database/mairie.db /var/www/html/$BACKUP_FILE

if [ $? -eq 0 ]; then
    echo "✅ Sauvegarde créée: $BACKUP_FILE"
    
    # Copier aussi les uploads
    UPLOADS_BACKUP="backup/uploads_backup_$(date +%Y%m%d_%H%M%S).tar.gz"
    docker exec mairie_php tar -czf /var/www/html/$UPLOADS_BACKUP -C /var/www/html/public uploads/
    
    if [ $? -eq 0 ]; then
        echo "✅ Sauvegarde des fichiers: $UPLOADS_BACKUP"
    else
        echo "⚠️  Erreur lors de la sauvegarde des fichiers"
    fi
    
    # Nettoyer les anciennes sauvegardes (garder les 10 plus récentes)
    cd backup
    ls -t mairie_backup_*.db | tail -n +11 | xargs -r rm
    ls -t uploads_backup_*.tar.gz | tail -n +11 | xargs -r rm
    cd ..
    
    echo "🧹 Anciennes sauvegardes nettoyées"
    
else
    echo "❌ Erreur lors de la sauvegarde"
    exit 1
fi