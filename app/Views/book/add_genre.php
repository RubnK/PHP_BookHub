<h2>Ajouter un genre</h2>

<form action="/books/add_genre" method="POST">
    <label for="name">Nom du genre :</label><br>
    <input type="text" name="name" id="name" required><br><br>

    <button type="submit">Ajouter le genre</button>
</form>

<p class="return-link"><a href="/books/add">Retour à l'ajout de livre</a></p>
