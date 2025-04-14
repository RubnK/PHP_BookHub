<h2>Ajouter un auteur</h2>

<form action="/books/add_author" method="POST">
    <label for="name">Nom complet de l’auteur :</label><br>
    <input type="text" name="name" id="name" required><br><br>

    <label for="bio">Biographie (optionnel) :</label><br>
    <textarea name="bio" id="bio" rows="4"></textarea><br><br>

    <label for="birth_date">Date de naissance :</label><br>
    <input type="date" name="birth_date" id="birth_date"><br><br>

    <label for="death_date">Date de décès (le cas échéant) :</label><br>
    <input type="date" name="death_date" id="death_date"><br><br>

    <button type="submit">Ajouter l’auteur</button>
</form>

<p class="return-link"><a href="/books/add">Retour à l'ajout de livre</a></p>