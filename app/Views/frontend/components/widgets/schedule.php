<!-- Widget Horaires -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
        🕒 <?= e($widget['title']) ?>
    </h3>
    
    <?php 
    $schedule = json_decode($widget['content'], true)['schedule'] ?? [];
    ?>
    
    <?php if (!empty($schedule)): ?>
        <div class="space-y-2">
            <?php 
            $days = [
                'lundi' => 'Lundi',
                'mardi' => 'Mardi', 
                'mercredi' => 'Mercredi',
                'jeudi' => 'Jeudi',
                'vendredi' => 'Vendredi',
                'samedi' => 'Samedi',
                'dimanche' => 'Dimanche'
            ];
            ?>
            
            <?php foreach ($days as $key => $dayName): ?>
                <?php if (isset($schedule[$key]) && $schedule[$key]): ?>
                    <div class="flex justify-between text-sm">
                        <span class="font-medium text-gray-700"><?= $dayName ?></span>
                        <span class="text-gray-600"><?= e($schedule[$key]) ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Horaires par défaut depuis les settings -->
        <div class="text-sm text-gray-600 whitespace-pre-line">
            <?= e(setting('opening_hours', 'Lundi-Vendredi: 9h-12h, 14h-17h')) ?>
        </div>
    <?php endif; ?>
    
    <div class="mt-4 pt-4 border-t border-gray-200">
        <a href="/infos-pratiques/horaires" 
           class="text-primary hover:underline text-sm font-medium">
            Voir tous les horaires →
        </a>
    </div>
</div>