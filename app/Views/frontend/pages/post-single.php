<?php /** @var $post */ ?>
<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($post['title']) ?></h1>
        <p class="text-gray-600"><?= $post['content'] ?></p>
    </div>
</div>
<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
