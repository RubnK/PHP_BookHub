<h2>Liste des livres</h2>

<?php if (empty($books)): ?>
    <p>Aucun livre pour le moment.</p>
<?php else: ?>
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
