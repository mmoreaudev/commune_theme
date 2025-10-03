<!-- Widget Liens rapides -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">
        <?= e($widget['title']) ?>
    </h3>
    
    <?php 
    $links = json_decode($widget['content'], true)['links'] ?? [];
    ?>
    
    <?php if (!empty($links)): ?>
        <ul class="space-y-3">
            <?php foreach ($links as $link): ?>
                <li>
                    <a href="<?= e($link['url']) ?>" 
                       class="flex items-center text-gray-700 hover:text-primary transition-colors group">
                        <span class="w-2 h-2 bg-primary rounded-full mr-3 group-hover:scale-125 transition-transform"></span>
                        <?= e($link['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <!-- Liens par défaut -->
        <ul class="space-y-3">
            <li>
                <a href="/infos-pratiques/horaires" 
                   class="flex items-center text-gray-700 hover:text-primary transition-colors group">
                    <span class="w-2 h-2 bg-primary rounded-full mr-3 group-hover:scale-125 transition-transform"></span>
                    Horaires d'ouverture
                </a>
            </li>
            <li>
                <a href="/votre-mairie/contact" 
                   class="flex items-center text-gray-700 hover:text-primary transition-colors group">
                    <span class="w-2 h-2 bg-primary rounded-full mr-3 group-hover:scale-125 transition-transform"></span>
                    Contact
                </a>
            </li>
            <li>
                <a href="/infos-pratiques/demarches" 
                   class="flex items-center text-gray-700 hover:text-primary transition-colors group">
                    <span class="w-2 h-2 bg-primary rounded-full mr-3 group-hover:scale-125 transition-transform"></span>
                    Démarches administratives
                </a>
            </li>
            <li>
                <a href="/infos-pratiques/numeros-utiles" 
                   class="flex items-center text-gray-700 hover:text-primary transition-colors group">
                    <span class="w-2 h-2 bg-primary rounded-full mr-3 group-hover:scale-125 transition-transform"></span>
                    Numéros utiles
                </a>
            </li>
        </ul>
    <?php endif; ?>
</div>