<h2>📖 Livre aléatoire</h2>
<?php if ($featured): ?>
    <div class="featured-book">
        <a href="/books/<?= $featured['id'] ?>">
            <?php if (!empty($featured['cover_image'])): ?>
                <img src="/uploads/<?= htmlspecialchars($featured['cover_image']) ?>" class="book-cover-large" alt="Couverture">
            <?php endif; ?>
            <h3><?= htmlspecialchars($featured['title']) ?></h3>
            <p><strong>Auteur :</strong> <?= htmlspecialchars($featured['author_name']) ?></p>
            <p><?= htmlspecialchars(substr($featured['description'], 0, 500)) ?>...</p>
        </a>
    </div>
<?php endif; ?>

<hr>

<h2>⭐ Les livres les plus appréciés</h2>
<ul class="book-list">
    <?php foreach ($topBooks as $book): ?>
        <a href="/books/<?= $book['id'] ?>">
            <li class="book-item">
                <?php if (!empty($book['cover_image'])): ?>
                    <img src="/uploads/<?= htmlspecialchars($book['cover_image']) ?>" class="book-cover">
                <?php endif; ?>
                <h4><?= htmlspecialchars($book['title']) ?></h4>
                <p><strong>Auteur :</strong> <?= htmlspecialchars($book['author_name']) ?></p>
                <p>⭐ <?= $book['average_rating'] ?>/5 (<?= $book['review_count'] ?> avis)</p>
            </li>
        </a>
    <?php endforeach; ?>
</ul>
