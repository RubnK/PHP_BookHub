<h2>Liste des livres</h2>

<?php if (empty($books)): ?>
    <p>Aucun livre pour le moment.</p>
<?php else: ?>
    <ul class="book-list">
        <?php foreach ($books as $book): ?>
            <li class="book-item">
                <h3><?= htmlspecialchars($book['title']) ?></h3>
                <p><strong>Auteur :</strong> <?= htmlspecialchars($book['author_name'] ?? 'Inconnu') ?></p>
                <p><strong>Genre :</strong> <?= htmlspecialchars($book['genre_name'] ?? 'Non défini') ?></p>
                <a href="/book/<?= $book['id'] ?>">📖 Voir le livre</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
