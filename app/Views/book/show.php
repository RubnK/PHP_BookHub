        <div class="book-header">
            <?php if (!empty($book['cover_image'])): ?>
                <img src="/uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="Couverture de <?= htmlspecialchars($book['title']) ?>" class="book-cover-large">
            <?php endif; ?>
            <div class="book-info">
                <h1><?= htmlspecialchars($book['title']) ?></h1>
                
                <div class="book-meta">
                    <p><span class="meta-label">Auteur :</span> <?= htmlspecialchars($book['author_name']) ?></p>
                    <p><span class="meta-label">Genre :</span> <?= htmlspecialchars($book['genre_name']) ?></p>
                    <p><span class="meta-label">Publication :</span> <?= htmlspecialchars($book['publication_date']) ?></p>
                </div>
            </div>
        </div>

        <div class="book-description">
            <h2>Description</h2>
            <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
        </div>

        <section class="reviews-section">
            <h2>Avis des lecteurs</h2>
            
            <?php if (empty($reviews)): ?>
                <p class="no-reviews">Aucun avis pour l'instant.</p>
            <?php else: ?>
                <div class="reviews-list">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <span class="reviewer"><?= htmlspecialchars($review['username']) ?></span>
                                <div class="rating-stars" data-rating="<?= $review['rating'] ?>"></div>
                            </div>
                            <p class="review-comment"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user'])): ?>
                <div class="add-review">
                    <h3>Ajouter un avis</h3>
                    <form action="/reviews/add" method="POST" class="review-form">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

                        <div class="form-group">
                            <label for="rating">Note :</label>
                            <div class="star-rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>">
                                    <label for="star<?= $i ?>">★</label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment">Commentaire :</label>
                            <textarea name="comment" id="comment" rows="5" placeholder="Votre avis sur ce livre..."></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Envoyer l'avis</button>
                    </form>
                </div>
            <?php else: ?>
                <p class="login-prompt"><a href="/login">Connectez-vous</a> pour laisser un avis.</p>
            <?php endif; ?>
        </section>