<?php $this->layout('admin.layouts.app', ['title' => $title]); ?>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Créer une page</h1>
        <a href="/admin/pages" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Retour à la liste
        </a>
    </div>

    <form method="POST" action="/admin/pages/store" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= e(old('title', '')) ?>"
                    >
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">URL (slug) *</label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= e(old('slug', '')) ?>"
                    >
                    <p class="text-sm text-gray-500 mt-1">URL unique de la page (ex: services-publics, contact, histoire)</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Description (meta)</label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Description courte pour les moteurs de recherche et réseaux sociaux"
                    ><?= e(old('excerpt', '')) ?></textarea>
                    <p class="text-sm text-gray-500 mt-1">Recommandé : 150-160 caractères maximum</p>
                </div>

                <!-- Contenu -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="20" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ><?= e(old('content', '')) ?></textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statut -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Publication</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select 
                                id="status" 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="draft" <?= old('status', 'draft') === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                                <option value="published" <?= old('status', '') === 'published' ? 'selected' : '' ?>>Publié</option>
                            </select>
                        </div>

                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Date de publication</label>
                            <input 
                                type="datetime-local" 
                                id="published_at" 
                                name="published_at" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?= e(old('published_at', date('Y-m-d\TH:i'))) ?>"
                            >
                        </div>
                    </div>
                </div>

                <!-- Type de page -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Type de page</h3>
                    
                    <div>
                        <select 
                            id="template" 
                            name="template" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="default" <?= old('template', 'default') === 'default' ? 'selected' : '' ?>>Page standard</option>
                            <option value="contact" <?= old('template') === 'contact' ? 'selected' : '' ?>>Page de contact</option>
                            <option value="services" <?= old('template') === 'services' ? 'selected' : '' ?>>Page de services</option>
                            <option value="full-width" <?= old('template') === 'full-width' ? 'selected' : '' ?>>Page pleine largeur</option>
                            <option value="landing" <?= old('template') === 'landing' ? 'selected' : '' ?>>Page d'atterrissage</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Définit l'apparence et les fonctionnalités de la page</p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Navigation</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Page parente</label>
                            <select 
                                id="parent_id" 
                                name="parent_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">Aucune (page racine)</option>
                                <!-- Les pages existantes seront chargées ici via PHP -->
                                <?php if (isset($parentPages) && is_array($parentPages)): ?>
                                    <?php foreach ($parentPages as $page): ?>
                                        <option value="<?= $page['id'] ?>" <?= old('parent_id') == $page['id'] ? 'selected' : '' ?>>
                                            <?= e($page['title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Pour créer une hiérarchie de pages</p>
                        </div>

                        <div>
                            <label for="menu_order" class="block text-sm font-medium text-gray-700 mb-2">Ordre dans le menu</label>
                            <input 
                                type="number" 
                                id="menu_order" 
                                name="menu_order" 
                                min="0" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?= e(old('menu_order', '0')) ?>"
                            >
                            <p class="text-sm text-gray-500 mt-1">0 = premier, plus élevé = plus bas dans le menu</p>
                        </div>

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="show_in_menu" 
                                name="show_in_menu" 
                                value="1" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                <?= old('show_in_menu', '1') ? 'checked' : '' ?>
                            >
                            <label for="show_in_menu" class="ml-2 block text-sm text-gray-900">Afficher dans le menu</label>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Image de la page</h3>
                    
                    <div>
                        <input 
                            type="file" 
                            id="featured_image" 
                            name="featured_image" 
                            accept="image/*" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <p class="text-sm text-gray-500 mt-1">Image d'en-tête ou illustration (formats : JPG, PNG, GIF - max 2MB)</p>
                    </div>
                </div>

                <!-- SEO -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Référencement (SEO)</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Titre SEO</label>
                            <input 
                                type="text" 
                                id="meta_title" 
                                name="meta_title" 
                                maxlength="60" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?= e(old('meta_title', '')) ?>"
                                placeholder="Titre optimisé pour les moteurs de recherche"
                            >
                            <p class="text-sm text-gray-500 mt-1">Recommandé : 50-60 caractères maximum</p>
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Mots-clés</label>
                            <input 
                                type="text" 
                                id="meta_keywords" 
                                name="meta_keywords" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?= e(old('meta_keywords', '')) ?>"
                                placeholder="Séparez par des virgules"
                            >
                            <p class="text-sm text-gray-500 mt-1">Ex : mairie, services publics, commune</p>
                        </div>

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="no_index" 
                                name="no_index" 
                                value="1" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                <?= old('no_index') ? 'checked' : '' ?>
                            >
                            <label for="no_index" class="ml-2 block text-sm text-gray-900">Exclure des moteurs de recherche</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t">
            <button 
                type="submit" 
                name="action" 
                value="draft" 
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md"
            >
                Enregistrer comme brouillon
            </button>
            <button 
                type="submit" 
                name="action" 
                value="publish" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md"
            >
                Publier
            </button>
        </div>
    </form>
</div>

<script>
// Auto-génération du slug depuis le titre
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '') // Supprimer les accents
        .replace(/[^a-z0-9\s-]/g, '') // Garder seulement lettres, chiffres, espaces et tirets
        .replace(/\s+/g, '-') // Remplacer espaces par tirets
        .replace(/-+/g, '-') // Éviter les tirets multiples
        .replace(/^-|-$/g, ''); // Supprimer tirets en début/fin
    
    document.getElementById('slug').value = slug;
});

// Auto-génération du titre SEO depuis le titre principal
document.getElementById('title').addEventListener('input', function() {
    const metaTitleField = document.getElementById('meta_title');
    if (!metaTitleField.value) {
        metaTitleField.value = this.value;
    }
});

// Compteur de caractères pour les champs SEO
document.getElementById('meta_title').addEventListener('input', function() {
    const length = this.value.length;
    const color = length > 60 ? 'text-red-500' : length > 50 ? 'text-yellow-500' : 'text-green-500';
    
    // Mise à jour du compteur (si vous voulez l'ajouter)
    console.log(`Titre SEO: ${length}/60 caractères`);
});

document.getElementById('excerpt').addEventListener('input', function() {
    const length = this.value.length;
    const color = length > 160 ? 'text-red-500' : length > 150 ? 'text-yellow-500' : 'text-green-500';
    
    // Mise à jour du compteur (si vous voulez l'ajouter)
    console.log(`Description: ${length}/160 caractères`);
});
</script>