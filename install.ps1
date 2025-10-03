# Script d'installation PowerShell pour le Thème Commune Moderne
# Usage: .\install.ps1

Write-Host "🏛️  Installation du Thème Commune Moderne" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

# Vérification des prérequis
Write-Host "📋 Vérification des prérequis..." -ForegroundColor Yellow

# Node.js
try {
    $nodeVersion = & node --version 2>$null
    if ($nodeVersion) {
        Write-Host "✅ Node.js $nodeVersion détecté" -ForegroundColor Green
    } else {
        throw "Node.js non trouvé"
    }
} catch {
    Write-Host "❌ Node.js n'est pas installé. Version requise: 18+" -ForegroundColor Red
    exit 1
}

# NPM
try {
    $npmVersion = & npm --version 2>$null
    if ($npmVersion) {
        Write-Host "✅ NPM $npmVersion détecté" -ForegroundColor Green
    } else {
        throw "NPM non trouvé"
    }
} catch {
    Write-Host "❌ NPM n'est pas installé." -ForegroundColor Red
    exit 1
}

# Installation des dépendances
Write-Host ""
Write-Host "📦 Installation des dépendances..." -ForegroundColor Yellow

try {
    & npm install
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Dépendances installées avec succès" -ForegroundColor Green
    } else {
        throw "Erreur NPM install"
    }
} catch {
    Write-Host "❌ Erreur lors de l'installation des dépendances" -ForegroundColor Red
    exit 1
}

# Build des assets
Write-Host ""
Write-Host "🔨 Compilation des assets..." -ForegroundColor Yellow

try {
    & npm run build
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Assets compilés avec succès" -ForegroundColor Green
    } else {
        throw "Erreur build"
    }
} catch {
    Write-Host "❌ Erreur lors de la compilation" -ForegroundColor Red
    exit 1
}

# Vérification des fichiers générés
Write-Host ""
Write-Host "🔍 Vérification des fichiers générés..." -ForegroundColor Yellow

$requiredFiles = @(
    "assets\css\main.css",
    "assets\js\main.js",
    "assets\js\components.js"
)

foreach ($file in $requiredFiles) {
    if (Test-Path $file) {
        Write-Host "✅ $file" -ForegroundColor Green
    } else {
        Write-Host "❌ $file manquant" -ForegroundColor Red
        exit 1
    }
}

# Instructions finales
Write-Host ""
Write-Host "🎉 Installation terminée avec succès !" -ForegroundColor Green
Write-Host ""
Write-Host "📌 Prochaines étapes :" -ForegroundColor Cyan
Write-Host "   1. Activez le thème dans Drupal (Apparence > Thèmes)"
Write-Host "   2. Configurez les régions et blocs selon vos besoins"
Write-Host "   3. Créez les types de contenu recommandés :"
Write-Host "      - Actualités (actualites)"
Write-Host "      - Événements (evenements)"
Write-Host "      - Services (services)"
Write-Host ""
Write-Host "📖 Consultez INSTALLATION.md pour plus de détails"
Write-Host ""
Write-Host "🚀 Pour le développement, utilisez : npm run dev" -ForegroundColor Yellow