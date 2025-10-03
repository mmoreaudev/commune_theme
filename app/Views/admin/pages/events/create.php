<?php $this->layout('admin.layouts.app', ['title' => $title]); ?>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Créer un événement</h1>
        <a href="/admin/events" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Retour à la liste
        </a>
    </div>

    <form method="POST" action="/admin/events/store" enctype="multipart/form-data" class="space-y-6">
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

                <!-- Description courte -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Description courte</label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ><?= e(old('excerpt', '')) ?></textarea>
                </div>

                <!-- Description complète -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Description complète</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="12" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ><?= e(old('content', '')) ?></textarea>
                </div>

                <!-- Dates et heures -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Date et heure de début *</label>
                        <input 
                            type="datetime-local" 
                            id="start_date" 
                            name="start_date" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?= e(old('start_date', '')) ?>"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Date et heure de fin</label>
                        <input 
                            type="datetime-local" 
                            id="end_date" 
                            name="end_date" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?= e(old('end_date', '')) ?>"
                        >
                    </div>
                </div>

                <!-- Lieu -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lieu</label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= e(old('location', '')) ?>"
                        placeholder="Ex: Salle des fêtes, Place de la mairie..."
                    >
                </div>

                <!-- Organisateur -->
                <div>
                    <label for="organizer" class="block text-sm font-medium text-gray-700 mb-2">Organisateur</label>
                    <input 
                        type="text" 
                        id="organizer" 
                        name="organizer" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= e(old('organizer', '')) ?>"
                        placeholder="Ex: Mairie, Association..."
                    >
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

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="is_featured" 
                                name="is_featured" 
                                value="1" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                <?= old('is_featured') ? 'checked' : '' ?>
                            >
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">Événement à la une</label>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Image de l'événement</h3>
                    
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
                            <option value="culture" <?= old('category') === 'culture' ? 'selected' : '' ?>>Culture</option>
                            <option value="sport" <?= old('category') === 'sport' ? 'selected' : '' ?>>Sport</option>
                            <option value="ceremony" <?= old('category') === 'ceremony' ? 'selected' : '' ?>>Cérémonie</option>
                            <option value="meeting" <?= old('category') === 'meeting' ? 'selected' : '' ?>>Réunion</option>
                            <option value="festival" <?= old('category') === 'festival' ? 'selected' : '' ?>>Festival</option>
                            <option value="market" <?= old('category') === 'market' ? 'selected' : '' ?>>Marché</option>
                            <option value="youth" <?= old('category') === 'youth' ? 'selected' : '' ?>>Jeunesse</option>
                            <option value="seniors" <?= old('category') === 'seniors' ? 'selected' : '' ?>>Seniors</option>
                        </select>
                    </div>
                </div>

                <!-- Informations pratiques -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations pratiques</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Prix</label>
                            <input 
                                type="text" 
                                id="price" 
                                name="price" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?= e(old('price', '')) ?>"
                                placeholder="Ex: Gratuit, 10€, 5€/8€..."
                            >
                        </div>

                        <div>
                            <label for="registration_required" class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="registration_required" 
                                    name="registration_required" 
                                    value="1" 
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    <?= old('registration_required') ? 'checked' : '' ?>
                                >
                                <span class="ml-2 block text-sm text-gray-900">Inscription obligatoire</span>
                            </label>
                        </div>

                        <div>
                            <label for="contact_info" class="block text-sm font-medium text-gray-700 mb-2">Contact/Inscription</label>
                            <textarea 
                                id="contact_info" 
                                name="contact_info" 
                                rows="3" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Téléphone, email, adresse..."
                            ><?= e(old('contact_info', '')) ?></textarea>
                        </div>
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
                        <p class="text-sm text-gray-500 mt-1">Exemple : fête, concert, famille</p>
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

// Validation des dates
document.getElementById('end_date').addEventListener('change', function() {
    const startDate = document.getElementById('start_date').value;
    const endDate = this.value;
    
    if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
        alert('La date de fin ne peut pas être antérieure à la date de début');
        this.value = '';
    }
});
</script>