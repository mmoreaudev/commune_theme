<?php /** @var $title */ ?>
<h1><?= htmlspecialchars($title ?? 'Actualités') ?></h1>
<?php foreach (($posts['items'] ?? []) as $p): ?>
    <article>
        <h2><a href="/actualites/<?= htmlspecialchars($p['slug']) ?>"><?= htmlspecialchars($p['title']) ?></a></h2>
        <p><?= htmlspecialchars($p['excerpt'] ?? '') ?></p>
    </article>
<?php endforeach; ?>
