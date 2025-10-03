<?php /** @var $events */ ?>
<h1>Événements</h1>
<?php foreach (($events['items'] ?? []) as $e): ?>
    <div>
        <h2><a href="/evenements/<?= htmlspecialchars($e['slug']) ?>"><?= htmlspecialchars($e['title']) ?></a></h2>
        <p><?= htmlspecialchars($e['description'] ?? '') ?></p>
    </div>
<?php endforeach; ?>
