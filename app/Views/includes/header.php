<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header>
    <a href="/" class="logo"><img src="/assets/logo.png" alt="Logo BookHub"><h1>BookHub</h1></a>
    <nav>
        <a href="/add">Ajouter un livre</a>
        <?php if (isset($_SESSION['user'])): ?>
            <span>👤 <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
            <a href="/logout">Déconnexion</a>
        <?php else: ?>
            <a href="/login">Connexion</a>
            <a href="/register">Inscription</a>
        <?php endif; ?>
    </nav>
    <hr>
</header>
<main>
