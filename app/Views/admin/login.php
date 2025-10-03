<?php // Minimal admin login placeholder
/** @var $title */
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Login') ?></title>
</head>
<body>
    <h1>Connexion admin (placeholder)</h1>
    <form method="post" action="/admin/login">
        <label>Email: <input type="email" name="email"></label><br>
        <label>Mot de passe: <input type="password" name="password"></label><br>
        <?= csrf_field() ?>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>