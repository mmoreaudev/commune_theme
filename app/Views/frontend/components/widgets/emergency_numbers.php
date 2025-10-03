<!-- Widget Numéros d'urgence -->
<div class="bg-red-50 border border-red-200 rounded-lg p-6">
    <h3 class="text-lg font-bold text-red-800 mb-4 flex items-center">
        🚨 <?= e($widget['title']) ?>
    </h3>
    
    <?php 
    $numbers = json_decode($widget['content'], true)['numbers'] ?? [];
    ?>
    
    <?php if (!empty($numbers)): ?>
        <ul class="space-y-3">
            <?php foreach ($numbers as $number): ?>
                <li class="flex justify-between items-center">
                    <span class="text-gray-700 font-medium"><?= e($number['name']) ?></span>
                    <a href="tel:<?= e($number['phone']) ?>" 
                       class="text-red-600 font-bold text-lg hover:text-red-800 transition-colors">
                        <?= e($number['phone']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <!-- Numéros par défaut -->
        <ul class="space-y-3">
            <li class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">Pompiers</span>
                <a href="tel:18" class="text-red-600 font-bold text-lg hover:text-red-800 transition-colors">18</a>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">Police</span>
                <a href="tel:17" class="text-red-600 font-bold text-lg hover:text-red-800 transition-colors">17</a>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">SAMU</span>
                <a href="tel:15" class="text-red-600 font-bold text-lg hover:text-red-800 transition-colors">15</a>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">Urgence Européen</span>
                <a href="tel:112" class="text-red-600 font-bold text-lg hover:text-red-800 transition-colors">112</a>
            </li>
        </ul>
    <?php endif; ?>
    
    <div class="mt-4 pt-4 border-t border-red-200">
        <p class="text-sm text-red-700">
            💡 En cas d'urgence non vitale, appelez d'abord votre médecin traitant
        </p>
    </div>
</div>