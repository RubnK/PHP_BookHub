<h2>📚 Ma bibliothèque</h2>

<?php if (empty($books)): ?>
    <p>Vous n’avez encore ajouté aucun livre à votre bibliothèque.</p>
<?php else: ?>
    <ul class="book-list">
        <?php foreach ($books as $book): ?>
            <a href="/books/<?= $book['id'] ?>">
                <li class="book-item">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="Couverture de <?= htmlspecialchars($book['title']) ?>" class="book-cover">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p><strong>Auteur :</strong> <?= htmlspecialchars($book['author_name'] ?? 'Inconnu') ?></p>
                    <p><strong>Genre :</strong> <?= htmlspecialchars($book['genre_name'] ?? 'Non défini') ?></p>
                    <form action="/books/<?= $book['id'] ?>/remove" method="POST" style="display:inline;">
                        <button type="submit" class="remove-btn" onclick="return confirm('Retirer ce livre de votre bibliothèque ?')">
                            Retirer de ma bibliothèque
                        </button>
                    </form>

                </li>
            </a>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
