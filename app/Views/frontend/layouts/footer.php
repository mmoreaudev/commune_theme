<!-- Footer -->
<footer class="bg-gray-900 text-white mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Informations Mairie -->
            <div>
                <h3 class="text-lg font-bold mb-4">Mairie de <?= e(setting('city_name')) ?></h3>
                <?php if (setting('address')): ?>
                    <p><?= e(setting('address')) ?></p>
                    <p><?= e(setting('postal_code')) ?> <?= e(setting('city')) ?></p>
                <?php endif; ?>
                
                <?php if (setting('phone')): ?>
                    <p class="mt-2">
                        <strong>Téléphone :</strong>
                        <a href="tel:<?= e(setting('phone')) ?>" class="hover:underline">
                            <?= e(setting('phone')) ?>
                        </a>
                    </p>
                <?php endif; ?>
                
                <?php if (setting('email')): ?>
                    <p>
                        <strong>Email :</strong>
                        <a href="mailto:<?= e(setting('email')) ?>" class="hover:underline">
                            <?= e(setting('email')) ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Horaires -->
            <div>
                <h3 class="text-lg font-bold mb-4">Horaires d'ouverture</h3>
                <?php if (setting('opening_hours')): ?>
                    <div class="whitespace-pre-line"><?= e(setting('opening_hours')) ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Liens rapides -->
            <div>
                <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                <ul class="space-y-2">
                    <li><a href="/actualites" class="hover:underline">Actualités</a></li>
                    <li><a href="/evenements" class="hover:underline">Événements</a></li>
                    <li><a href="/votre-mairie/contact" class="hover:underline">Contact</a></li>
                    <li><a href="/infos-pratiques/demarches" class="hover:underline">Démarches</a></li>
                    <li><a href="/infos-pratiques/numeros-utiles" class="hover:underline">Numéros utiles</a></li>
                </ul>
                
                <!-- Réseaux sociaux -->
                <?php 
                $socialLinks = [];
                if (setting('facebook')) $socialLinks['Facebook'] = setting('facebook');
                if (setting('twitter')) $socialLinks['Twitter'] = setting('twitter');
                if (setting('instagram')) $socialLinks['Instagram'] = setting('instagram');
                if (setting('youtube')) $socialLinks['YouTube'] = setting('youtube');
                ?>
                
                <?php if (!empty($socialLinks)): ?>
                    <div class="mt-6">
                        <h4 class="font-semibold mb-2">Suivez-nous</h4>
                        <div class="flex gap-4">
                            <?php foreach ($socialLinks as $name => $url): ?>
                                <a href="<?= e($url) ?>" target="_blank" rel="noopener" 
                                   class="text-gray-300 hover:text-white transition-colors"
                                   title="<?= e($name) ?>">
                                    <?php
                                    $icons = [
                                        'Facebook' => '📘',
                                        'Twitter' => '🐦',
                                        'Instagram' => '📷',
                                        'YouTube' => '📺'
                                    ];
                                    echo $icons[$name] ?? '🔗';
                                    ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Copyright -->
    <div class="bg-gray-950 py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <div>
                    <p>&copy; <?= date('Y') ?> Mairie de <?= e(setting('city_name')) ?> - Tous droits réservés</p>
                </div>
                <div class="flex gap-4 mt-2 md:mt-0">
                    <a href="/page/mentions-legales" class="hover:text-white">Mentions légales</a>
                    <a href="/page/politique-confidentialite" class="hover:text-white">Politique de confidentialité</a>
                    <a href="/page/accessibilite" class="hover:text-white">Accessibilité</a>
                    <?php if (isLoggedIn()): ?>
                        <a href="/admin" class="hover:text-white">Administration</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>