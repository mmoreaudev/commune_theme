# 🚀 Guide d'installation rapide - Thème Mairie France

## ⚡ Installation en 5 minutes

### 1️⃣ Installer le thème

1. Téléchargez le dossier `commune_theme`
2. Connectez-vous à votre WordPress
3. Allez dans **Apparence > Thèmes > Ajouter**
4. Cliquez sur **Téléverser un thème**
5. Sélectionnez le fichier ZIP du thème
6. Cliquez sur **Installer maintenant**
7. Activez le thème

### 2️⃣ Créer vos menus (IMPORTANT !)

⚠️ **Le thème n'affiche AUCUN menu par défaut. Vous devez les créer !**

#### Menu principal (obligatoire)

1. Allez dans **Apparence > Menus**
2. Cliquez sur **Créer un nouveau menu**
3. Nommez-le "Menu Principal"
4. Ajoutez vos pages :
   - Accueil
   - Actualités
   - Services
   - Contact
   - etc.
5. Cochez **Menu Principal** dans "Réglages du menu"
6. Cliquez sur **Enregistrer le menu**

#### Autres menus (optionnels)

- **Barre supérieure** - Liens rapides en haut (ex: Accès direct, Urgences)
- **Menu pied de page** - Liens dans le footer
- **Menu légal** - Mentions légales, RGPD, etc.

### 3️⃣ Configurer les informations de base

1. Allez dans **Apparence > Personnaliser**

2. **Identité du site**
   - Logo de la mairie
   - Nom de la commune
   - Slogan

3. **Commune > Identité**
   - Nom de la commune
   - Slogan
   - Blason (optionnel)

4. **Commune > Contact**
   - Adresse complète
   - Téléphone (s'affiche dans le header)
   - Email (s'affiche dans le header)
   - Horaires d'ouverture

5. **Commune > Réseaux sociaux** (optionnel)
   - Facebook
   - Twitter
   - Instagram
   - YouTube

6. Cliquez sur **Publier**

### 4️⃣ Installer les plugins recommandés

Une notification apparaîtra pour installer les plugins. Cliquez dessus et installez :

**Essentiels :**
- ✅ The Events Calendar (événements)
- ✅ Contact Form 7 (formulaires)

**Recommandés :**
- Our Team Members (conseil municipal)
- Download Manager (documents)
- TablePress (tableaux)
- Accordion (FAQ)
- UpdraftPlus (sauvegardes)
- Wordfence (sécurité)

### 5️⃣ Créer vos premières pages

#### Page d'accueil

1. **Pages > Ajouter**
2. Titre : "Accueil"
3. **Attributs de page > Modèle** : "Page d'accueil"
4. Remplissez les champs du modèle
5. Publiez

6. **Réglages > Lecture**
7. Sélectionnez "Une page statique"
8. Page d'accueil : "Accueil"
9. Enregistrez

#### Autres pages importantes

Créez ces pages avec les modèles appropriés :

- **Actualités** (modèle : Actualités)
- **Contact** (modèle : Contact)
- **Événements** (modèle : Événements)
- **Numéros utiles** (modèle : Numéros Utiles)

## 📱 Vérifications post-installation

### ✅ Checklist

- [ ] Le menu principal s'affiche dans le header
- [ ] Le menu mobile s'ouvre correctement (bouton hamburger)
- [ ] Le nom de la commune s'affiche
- [ ] Le téléphone et l'email s'affichent dans le header (desktop)
- [ ] Le footer contient vos informations
- [ ] Le site est responsive (testez sur mobile)

### 🐛 Problèmes courants

**Le menu ne s'affiche pas**
→ Avez-vous créé et assigné un menu à "Menu Principal" ?

**Le menu mobile ne s'ouvre pas**
→ Vérifiez que JavaScript est activé dans votre navigateur

**Les informations de contact ne s'affichent pas**
→ Allez dans Apparence > Personnaliser > Commune > Contact

**Les styles ne s'appliquent pas**
→ Le thème utilise Tailwind CSS via CDN. Vérifiez votre connexion Internet.

## 🎨 Personnalisation avancée

### Modifier les couleurs

1. **Apparence > Personnaliser > Couleurs**
2. Modifiez les couleurs officielles si nécessaire

Ou éditez directement `assets/css/custom.css` :

```css
:root {
    --color-primary: #000091;    /* Bleu France */
    --color-secondary: #E1000F;  /* Rouge Marianne */
}
```

### Ajouter du CSS personnalisé

1. **Apparence > Personnaliser > CSS additionnel**
2. Ajoutez votre CSS

Ou éditez `assets/css/custom.css`

## 📞 Support

- **Documentation** : Lisez `README-TAILWIND.md`
- **Guide Tailwind** : Consultez `GUIDE-TAILWIND.md`
- **Changelog** : Voir `CHANGELOG.md` pour les dernières modifications

## 🎯 Prochaines étapes

1. ✅ Créer vos pages de contenu
2. ✅ Ajouter des actualités (Articles > Ajouter)
3. ✅ Configurer The Events Calendar pour les événements
4. ✅ Créer des numéros utiles (Numéros Utiles > Ajouter)
5. ✅ Ajouter des widgets dans la sidebar (Apparence > Widgets)
6. ✅ Configurer Contact Form 7 pour le formulaire de contact

## 🚀 Votre site de mairie est prêt !

Félicitations ! Votre site de mairie est maintenant opérationnel avec un design moderne, accessible (RGAA) et responsive.

---

**Besoin d'aide ?** Créez une issue sur GitHub ou consultez la documentation complète.
