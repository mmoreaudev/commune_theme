<?php 
$content = ob_start(); 
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">Nous contacter</h1>
                <p class="text-xl opacity-90">Votre mairie est à votre écoute</p>
            </div>
        </div>
    </div>

    <!-- Fil d'Ariane -->
    <nav class="breadcrumb bg-gray-50 py-3" aria-label="Fil d'Ariane">
        <div class="container mx-auto px-4">
            <a href="/" class="text-blue-600 hover:text-blue-800">Accueil</a>
            <span class="breadcrumb-separator">></span>
            <span class="text-gray-600">Contact</span>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Formulaire de contact -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold">Envoyer un message</h2>
                    </div>
                    
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-error">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/contact" data-validate class="space-y-6">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="firstname" class="form-label">
                                        Prénom *
                                    </label>
                                    <input type="text" 
                                           id="firstname"
                                           name="firstname" 
                                           value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
                                           required
                                           class="form-input">
                                </div>
                                
                                <div>
                                    <label for="lastname" class="form-label">
                                        Nom *
                                    </label>
                                    <input type="text" 
                                           id="lastname"
                                           name="lastname" 
                                           value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>"
                                           required
                                           class="form-input">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="form-label">
                                    Adresse email *
                                </label>
                                <input type="email" 
                                       id="email"
                                       name="email" 
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                       required
                                       class="form-input">
                            </div>

                            <div>
                                <label for="phone" class="form-label">
                                    Téléphone
                                </label>
                                <input type="tel" 
                                       id="phone"
                                       name="phone" 
                                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                                       class="form-input">
                            </div>

                            <div>
                                <label for="subject" class="form-label">
                                    Sujet *
                                </label>
                                <select id="subject" name="subject" required class="form-input">
                                    <option value="">Sélectionnez un sujet</option>
                                    <option value="demande_info" <?= ($_POST['subject'] ?? '') === 'demande_info' ? 'selected' : '' ?>>
                                        Demande d'information
                                    </option>
                                    <option value="demarche_administrative" <?= ($_POST['subject'] ?? '') === 'demarche_administrative' ? 'selected' : '' ?>>
                                        Démarche administrative
                                    </option>
                                    <option value="travaux_voirie" <?= ($_POST['subject'] ?? '') === 'travaux_voirie' ? 'selected' : '' ?>>
                                        Travaux / Voirie
                                    </option>
                                    <option value="environnement" <?= ($_POST['subject'] ?? '') === 'environnement' ? 'selected' : '' ?>>
                                        Environnement
                                    </option>
                                    <option value="vie_associative" <?= ($_POST['subject'] ?? '') === 'vie_associative' ? 'selected' : '' ?>>
                                        Vie associative
                                    </option>
                                    <option value="education" <?= ($_POST['subject'] ?? '') === 'education' ? 'selected' : '' ?>>
                                        Éducation
                                    </option>
                                    <option value="social" <?= ($_POST['subject'] ?? '') === 'social' ? 'selected' : '' ?>>
                                        Action sociale
                                    </option>
                                    <option value="autre" <?= ($_POST['subject'] ?? '') === 'autre' ? 'selected' : '' ?>>
                                        Autre
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="message" class="form-label">
                                    Message *
                                </label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="6" 
                                          required
                                          maxlength="2000"
                                          class="form-input"
                                          placeholder="Décrivez votre demande..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                <div class="text-sm text-gray-500 mt-1">
                                    <span id="message-count">0</span>/2000 caractères
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <input type="checkbox" 
                                       id="consent" 
                                       name="consent" 
                                       required
                                       class="mt-1">
                                <label for="consent" class="text-sm text-gray-700">
                                    J'accepte que mes données personnelles soient utilisées pour traiter ma demande. 
                                    <a href="/confidentialite" class="text-blue-600 hover:text-blue-800">
                                        En savoir plus sur le traitement des données
                                    </a>
                                </label>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary w-full md:w-auto">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informations de contact -->
            <div class="space-y-8">
                <!-- Coordonnées -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold">Coordonnées</h2>
                    </div>
                    
                    <div class="card-body space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Adresse</h3>
                                <address class="text-gray-600 not-italic">
                                    Place de la Mairie<br>
                                    12345 Notre Commune<br>
                                    France
                                </address>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Téléphone</h3>
                                <div class="space-y-1">
                                    <div>
                                        <a href="tel:0123456789" class="text-blue-600 hover:text-blue-800">
                                            01 23 45 67 89
                                        </a>
                                        <span class="text-gray-500 text-sm ml-2">Standard</span>
                                    </div>
                                    <div>
                                        <a href="tel:0123456790" class="text-blue-600 hover:text-blue-800">
                                            01 23 45 67 90
                                        </a>
                                        <span class="text-gray-500 text-sm ml-2">Urgences</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Email</h3>
                                <div class="space-y-1">
                                    <div>
                                        <a href="mailto:contact@mairie.fr" class="text-blue-600 hover:text-blue-800">
                                            contact@mairie.fr
                                        </a>
                                        <span class="text-gray-500 text-sm ml-2">Contact général</span>
                                    </div>
                                    <div>
                                        <a href="mailto:secretariat@mairie.fr" class="text-blue-600 hover:text-blue-800">
                                            secretariat@mairie.fr
                                        </a>
                                        <span class="text-gray-500 text-sm ml-2">Secrétariat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horaires d'ouverture -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold">Horaires d'ouverture</h2>
                    </div>
                    
                    <div class="card-body">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium">Lundi</span>
                                <span class="text-green-600">8h00 - 12h00 / 14h00 - 18h00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Mardi</span>
                                <span class="text-green-600">8h00 - 12h00 / 14h00 - 18h00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Mercredi</span>
                                <span class="text-green-600">8h00 - 12h00 / 14h00 - 17h00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Jeudi</span>
                                <span class="text-green-600">8h00 - 12h00 / 14h00 - 18h00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Vendredi</span>
                                <span class="text-green-600">8h00 - 12h00 / 14h00 - 17h00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Samedi</span>
                                <span class="text-green-600">9h00 - 12h00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Dimanche</span>
                                <span class="text-red-600">Fermé</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <div class="font-medium text-yellow-800">Attention</div>
                                    <div class="text-sm text-yellow-700">
                                        Les horaires peuvent être modifiés pendant les vacances scolaires et les jours fériés.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services d'urgence -->
                <div class="card border-red-200">
                    <div class="card-header bg-red-50">
                        <h2 class="text-2xl font-bold text-red-800">Urgences</h2>
                    </div>
                    
                    <div class="card-body">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Police / Gendarmerie</span>
                                <a href="tel:17" class="text-red-600 font-bold text-lg">17</a>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Pompiers</span>
                                <a href="tel:18" class="text-red-600 font-bold text-lg">18</a>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">SAMU</span>
                                <a href="tel:15" class="text-red-600 font-bold text-lg">15</a>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Numéro d'urgence européen</span>
                                <a href="tel:112" class="text-red-600 font-bold text-lg">112</a>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Astreinte technique</span>
                                <a href="tel:0123456791" class="text-red-600 font-medium">01 23 45 67 91</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plan d'accès -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold">Plan d'accès</h2>
                    </div>
                    
                    <div class="card-body">
                        <div class="aspect-video bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p>Carte interactive</p>
                                <p class="text-sm">(Intégration Google Maps à prévoir)</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <span><strong>En voiture :</strong> Parking gratuit disponible</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                                <span><strong>En bus :</strong> Arrêt "Mairie" (lignes 12, 25)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span><strong>Accessibilité :</strong> Établissement accessible PMR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères pour le message
    const messageTextarea = document.getElementById('message');
    const messageCount = document.getElementById('message-count');
    
    if (messageTextarea && messageCount) {
        messageTextarea.addEventListener('input', function() {
            const count = this.value.length;
            messageCount.textContent = count;
            
            if (count > 1800) {
                messageCount.classList.add('text-orange-600');
            } else if (count > 1900) {
                messageCount.classList.add('text-red-600');
            } else {
                messageCount.classList.remove('text-orange-600', 'text-red-600');
            }
        });
        
        // Initialiser le compteur
        messageCount.textContent = messageTextarea.value.length;
    }
});
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>