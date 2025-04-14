<h2>Ajouter un livre</h2>

<form action="/books/add" method="POST" enctype="multipart/form-data">
    <label for="title">Titre :</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="description">Description :</label><br>
    <textarea name="description" id="description"></textarea><br><br>

    <label for="publication_date">Date de publication :</label><br>
    <input type="date" name="publication_date" id="publication_date"><br><br>

    <label for="author">Auteur :</label><br>
    <select name="author_id" id="author" required>
        <option value="">-- Sélectionner un auteur --</option>
        <?php foreach ($authors as $author): ?>
            <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['name']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <a href="/books/add_author">Pas dans la liste ? Ajouter un auteur</a><br><br>

    <label for="genre">Genre :</label><br>
    <select name="genre_id" id="genre" required>
        <option value="">-- Sélectionner un genre --</option>
        <?php foreach ($genres as $genre): ?>
            <option value="<?= $genre['id'] ?>"><?= htmlspecialchars($genre['name']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <a href="/books/add_genre">Pas dans la liste ? Ajouter un genre</a><br><br>

    <div class="file-input-container">
        <label for="cover_image" class="file-input-label">
            <i>📁</i>
            <span>Cliquez pour sélectionner une image de couverture</span>
        </label>
        <input type="file" name="cover_image" id="cover_image">
        <span class="file-name" id="file-name">Aucun fichier sélectionné</span>
    </div>

    <button type="submit">Ajouter le livre</button>
</form>

<script type="text/javascript">
    document.getElementById('cover_image').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'Aucun fichier sélectionné';
        document.getElementById('file-name').textContent = fileName;
    });
</script>