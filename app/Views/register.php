<h2>Inscription</h2>

<form action="/register" method="POST">
    <label for="username">Nom d'utilisateur :</label><br>
    <input type="text" name="username" id="username" required><br><br>

    <label for="email">Adresse email :</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <label for="confirm">Confirmer le mot de passe :</label><br>
    <input type="password" name="confirm" id="confirm" required><br><br>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <button type="submit">S'inscrire</button>
    <br>
    <p>Déjà inscrit ? <a href="/login">Connectez-vous</a></p>
</form>

