<h2>Connexion</h2>

<form action="/login" method="POST">
    <label for="email">Adresse email :</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <button type="submit">Se connecter</button>
    <br>
    <p>Pas encore de compte ? <a href="/register">S'inscrire</a></p>
</form>

