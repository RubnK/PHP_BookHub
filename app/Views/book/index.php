<h2>Liste des livres</h2>

<form method="GET" action="/books" class="search-form">
    <input type="text" name="q" placeholder="Rechercher un livre, un auteur ou un genre..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
    <button type="submit">Rechercher</button>
</form>
<br>

<?php if (!empty($query)): ?>
    <p class="search-info">🔍 <?= count($books) ?> résultat<?= count($books) > 1 ? 's' : '' ?> trouvé<?= count($books) > 1 ? 's' : '' ?> pour "<strong><?= htmlspecialchars($query) ?></strong>"</p>
<?php else: ?>
    <p class="search-info">📚 <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?> trouvé<?= count($books) > 1 ? 's' : '' ?></p>
<?php endif; ?>

<?php if (!empty($books)): ?>
    <ul class="book-list">
        <?php foreach ($books as $book): ?>
            <a href ="/books/<?= $book['id'] ?>">
                <li class="book-item">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="Couverture de <?= htmlspecialchars($book['title']) ?>" class="book-cover">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p><strong>Auteur :</strong> <?= htmlspecialchars($book['author_name'] ?? 'Inconnu') ?></p>
                    <p><strong>Genre :</strong> <?= htmlspecialchars($book['genre_name'] ?? 'Non défini') ?></p>
               </li>
            </a>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
