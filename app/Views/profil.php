<h2>Mon profil</h2>

<?php if (!empty($success)): ?>
    <div style="background:#dff0d8; color:#3c763d; padding:10px; margin-bottom:15px; border:1px solid #d6e9c6; border-radius:5px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php elseif (!empty($error)): ?>
    <div style="background:#f2dede; color:#a94442; padding:10px; margin-bottom:15px; border:1px solid #ebccd1; border-radius:5px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/profil" method="POST">
    <label for="username">Nom d'utilisateur :</label><br>
    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label for="email">Email :</label><br>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

    <hr>

    <h4>Modifier le mot de passe</h4>

    <label for="current_password">Mot de passe actuel :</label><br>
    <input type="password" name="current_password"><br><br>

    <label for="new_password">Nouveau mot de passe :</label><br>
    <input type="password" name="new_password"><br><br>

    <label for="confirm_password">Confirmer le nouveau mot de passe :</label><br>
    <input type="password" name="confirm_password"><br><br>

    <button type="submit">Mettre à jour</button>
</form>

<div class="delete-account-container">
    <h3>Zone dangereuse</h3>
    <p>Cette action est irréversible. Toutes vos données seront perdues.</p>
    <a href="/profil/delete" class="delete-account" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
        Supprimer mon compte
    </a>
</div>