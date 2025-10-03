<!-- Widget Prochain événement -->
<?php
// Récupérer le prochain événement
$nextEvent = Event::getNext();
?>

<?php if ($nextEvent): ?>
    <div class="bg-gradient-to-br from-primary to-blue-600 text-white rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            📅 Prochain événement
        </h3>
        
        <div class="space-y-3">
            <h4 class="font-semibold text-lg">
                <a href="/evenements/<?= e($nextEvent['slug']) ?>" class="hover:underline">
                    <?= e($nextEvent['title']) ?>
                </a>
            </h4>
            
            <div class="text-blue-100">
                <div class="flex items-center mb-2">
                    <span class="mr-2">📅</span>
                    <?= formatDate($nextEvent['start_date'], 'd/m/Y à H:i') ?>
                </div>
                
                <?php if ($nextEvent['location']): ?>
                    <div class="flex items-center">
                        <span class="mr-2">📍</span>
                        <?= e($nextEvent['location']) ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($nextEvent['description']): ?>
                <p class="text-blue-100 text-sm">
                    <?= e(str_limit($nextEvent['description'], 100)) ?>
                </p>
            <?php endif; ?>
            
            <a href="/evenements/<?= e($nextEvent['slug']) ?>" 
               class="inline-block bg-white text-primary px-4 py-2 rounded font-semibold hover:bg-blue-50 transition-colors text-sm">
                En savoir plus
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="bg-gray-100 rounded-lg p-6 text-center">
        <div class="text-4xl mb-3">📅</div>
        <h3 class="font-semibold text-gray-700 mb-2">Aucun événement à venir</h3>
        <p class="text-gray-600 text-sm">Consultez la page événements pour plus d'informations.</p>
        <a href="/evenements" class="inline-block mt-3 text-primary hover:underline font-medium">
            Voir tous les événements
        </a>
    </div>
<?php endif; ?>