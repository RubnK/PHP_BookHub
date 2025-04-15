<h2><?= htmlspecialchars($author['name']) ?></h2>

<?php if ($author['birth_date'] || $author['death_date']): ?>
    <p>
        <?= $author['birth_date'] ? "Né le " . date('d/m/Y', strtotime($author['birth_date'])) : '' ?>
        <?= $author['death_date'] ? " - Décédé le " . date('d/m/Y', strtotime($author['death_date'])) : '' ?>
    </p>
<?php endif; ?>

<?php if (!empty($author['bio'])): ?>
    <div class="author-bio">
        <p><?= nl2br(htmlspecialchars($author['bio'])) ?></p>
    </div>
<?php endif; ?>

<hr>

<h3>📚 Livres de cet auteur</h3>
<?php if (empty($books)): ?>
    <p>Aucun livre trouvé pour cet auteur.</p>
<?php else: ?>
    <ul class="book-list">
        <?php foreach ($books as $book): ?>
            <a href="/books/<?= $book['id'] ?>">
                <li class="book-item">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($book['cover_image']) ?>" class="book-cover">
                    <?php endif; ?>
                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                    <p><strong>Genre :</strong> <?= htmlspecialchars($book['genre_name'] ?? 'Inconnu') ?></p>
                </li>
            </a>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
