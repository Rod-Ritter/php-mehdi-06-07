<main>
    <form action="insert_user.php" method="post" novalidate>
        <div>
            <label for="nom">nom: </label>
            <input type="text" name="nom" id="nom">
        </div>
        <div>
            <label for="prenom">prenon: </label>
            <input type="text" name="prenon" id="prenon" required>
        </div>
        <div>
            <label for="email">Enter your email: </label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <input type="submit" name="submitted" value="ajouter un nouvel utilisateur">
        </div>

    </form>
</main>