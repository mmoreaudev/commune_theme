<?php /** @var $event */ ?>
<?php 
$content = ob_start(); 
?>


<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($event['title']) ?></h1>
    <p class="text-gray-600"><?= $event['description'] ?></p>
</div>
<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>