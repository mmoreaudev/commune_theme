<?php $this->layout('admin.layouts.app', ['title' => $title]); ?>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Créer un article</h1>
        <a href="/admin/posts" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Retour à la liste
        </a>
    </div>

    <form method="POST" action="/admin/posts/store" enctype="multipart/form-data" class="space-y-6">
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
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">URL (slug)</label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= e(old('slug', '')) ?>"
                    >
                    <p class="text-sm text-gray-500 mt-1">Laissez vide pour générer automatiquement depuis le titre</p>
                </div>

                <!-- Extrait -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Extrait</label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ><?= e(old('excerpt', '')) ?></textarea>
                </div>

                <!-- Contenu -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="15" 
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

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="is_featured" 
                                name="is_featured" 
                                value="1" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                <?= old('is_featured') ? 'checked' : '' ?>
                            >
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">Article à la une</label>
                        </div>
                    </div>
                </div>

                <!-- Image mise en avant -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Image mise en avant</h3>
                    
                    <div>
                        <input 
                            type="file" 
                            id="featured_image" 
                            name="featured_image" 
                            accept="image/*" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPG, PNG, GIF (max 2MB)</p>
                    </div>
                </div>

                <!-- Catégorie -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Catégorie</h3>
                    
                    <div>
                        <select 
                            id="category" 
                            name="category" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Aucune catégorie</option>
                            <option value="actualites" <?= old('category') === 'actualites' ? 'selected' : '' ?>>Actualités</option>
                            <option value="evenements" <?= old('category') === 'evenements' ? 'selected' : '' ?>>Événements</option>
                            <option value="conseil-municipal" <?= old('category') === 'conseil-municipal' ? 'selected' : '' ?>>Conseil municipal</option>
                            <option value="travaux" <?= old('category') === 'travaux' ? 'selected' : '' ?>>Travaux</option>
                            <option value="culture" <?= old('category') === 'culture' ? 'selected' : '' ?>>Culture</option>
                            <option value="sport" <?= old('category') === 'sport' ? 'selected' : '' ?>>Sport</option>
                        </select>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tags</h3>
                    
                    <div>
                        <input 
                            type="text" 
                            id="tags" 
                            name="tags" 
                            placeholder="Séparez les tags par des virgules" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?= e(old('tags', '')) ?>"
                        >
                        <p class="text-sm text-gray-500 mt-1">Exemple : mairie, conseil, actualité</p>
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
</script>