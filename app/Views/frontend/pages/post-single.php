<?php /** @var $post */ ?>
<article>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <div><?= $post['content'] ?></div>
</article>
