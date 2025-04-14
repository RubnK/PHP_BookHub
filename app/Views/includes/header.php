<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/style.css">
    <link rel="stylesheet" href="/assets/utils.css">
    <?php if($_SERVER['REQUEST_URI'] == '/books/add' || $_SERVER['REQUEST_URI'] == '/books/edit' || $_SERVER['REQUEST_URI'] == '/books/add_author' || $_SERVER['REQUEST_URI'] == '/books/add_genre' || preg_match('#^/books/\d+/edit$#', $_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '/register' || $_SERVER['REQUEST_URI'] == '/login'): ?>
        <link rel="stylesheet" href="/assets/forms.css">
    <?php elseif(preg_match('#^/books(/|$)#', $_SERVER['REQUEST_URI'])): ?>
        <link rel="stylesheet" href="/assets/book.css">
    <?php endif; ?>
</head>
<body>
<header>
    <a href="/" class="logo"><img src="/assets/logo.png" alt="Logo BookHub"><h1>BookHub</h1></a>
    <nav>
        <a href="/books">Livres</a>
        <a href="/books/add">Ajouter un livre</a>
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
