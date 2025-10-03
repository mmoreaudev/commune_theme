<?php /** @var $numbers */ ?>
<h1>Numéros utiles</h1>
<ul>
<?php foreach (($numbers ?? []) as $n): ?>
    <li><?= htmlspecialchars($n['label']) ?>: <?= htmlspecialchars($n['number']) ?></li>
<?php endforeach; ?>
</ul>
