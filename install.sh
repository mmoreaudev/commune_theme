#!/bin/bash

# Script d'installation automatique du Thème Commune Moderne
# Usage: ./install.sh

set -e

echo "🏛️  Installation du Thème Commune Moderne"
echo "========================================"

# Vérification des prérequis
echo "📋 Vérification des prérequis..."

# Node.js
if ! command -v node &> /dev/null; then
    echo "❌ Node.js n'est pas installé. Version requise: 18+"
    exit 1
fi

NODE_VERSION=$(node -v | cut -d'v' -f2 | cut -d'.' -f1)
if [ "$NODE_VERSION" -lt 18 ]; then
    echo "❌ Node.js version $NODE_VERSION détectée. Version 18+ requise."
    exit 1
fi

# NPM
if ! command -v npm &> /dev/null; then
    echo "❌ NPM n'est pas installé."
    exit 1
fi

echo "✅ Node.js $(node -v) et NPM $(npm -v) détectés"

# Installation des dépendances
echo ""
echo "📦 Installation des dépendances..."
npm install

if [ $? -eq 0 ]; then
    echo "✅ Dépendances installées avec succès"
else
    echo "❌ Erreur lors de l'installation des dépendances"
    exit 1
fi

# Build des assets
echo ""
echo "🔨 Compilation des assets..."
npm run build

if [ $? -eq 0 ]; then
    echo "✅ Assets compilés avec succès"
else
    echo "❌ Erreur lors de la compilation"
    exit 1
fi

# Vérification des fichiers générés
echo ""
echo "🔍 Vérification des fichiers générés..."

REQUIRED_FILES=(
    "assets/css/main.css"
    "assets/js/main.js"
    "assets/js/components.js"
)

for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file manquant"
        exit 1
    fi
done

# Permissions
echo ""
echo "🔐 Configuration des permissions..."
chmod -R 755 assets/
chmod -R 644 assets/css/
chmod -R 644 assets/js/
chmod 644 templates/*.twig

echo "✅ Permissions configurées"

# Instructions finales
echo ""
echo "🎉 Installation terminée avec succès !"
echo ""
echo "📌 Prochaines étapes :"
echo "   1. Activez le thème dans Drupal (Apparence > Thèmes)"
echo "   2. Configurez les régions et blocs selon vos besoins"
echo "   3. Créez les types de contenu recommandés :"
echo "      - Actualités (actualites)"
echo "      - Événements (evenements)"
echo "      - Services (services)"
echo ""
echo "📖 Consultez INSTALLATION.md pour plus de détails"
echo ""
echo "🚀 Pour le développement, utilisez : npm run dev"