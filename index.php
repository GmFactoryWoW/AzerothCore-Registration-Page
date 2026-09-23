<?php
require 'config.php';
try {
    // Checks if the DB info is correct / accessible.
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Redirect to db_error.php with error details and blank the page
    $query = http_build_query([
            'error_message' => $e->getMessage(),
            'error_code'    => $e->getCode()
    ]);
    header('Location: app/errors/db_error.php?' . $query);
    exit();
}

$recruiters = Auth::getRecruiterCharacters();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
</head>
<body class="dark-mode">
<div class="registration-page">
    <div class="registration-content">
        <?php include 'app/controllers/register.php' ?>
        <form action="" method="post" class="registration-form" novalidate>
            <div class="registration-field">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" required>
                <div id="usernameHelper" class="form-text"></div>
            </div>

            <?php if (EMAIL_ENABLED): ?>
                <div class="registration-field">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" maxlength="255" required>
                    <div id="emailHelper" class="form-text"></div>
                </div>
            <?php endif; ?>

            <div class="registration-field">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" minlength="<?php echo PASSWORD_MIN_LENGTH; ?>" required>
                <div id="passwordCharsHelper" class="form-text"></div>
            </div>

            <div class="registration-field">
                <label for="passwordRepeat">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat" required>
                <div id="passwordMatchHelper" class="form-text"></div>
            </div>

            <div class="registration-field registration-field--wide">
                <label for="recruiter">Parrain <span class="optional">(optionnel)</span></label>
                <input type="text" class="form-control" id="recruiter" name="recruiter" list="recruiterList" autocomplete="off" placeholder="Rechercher un personnage">
                <datalist id="recruiterList">
                    <?php foreach ($recruiters as $recruiter): ?>
                        <option value="<?php echo htmlspecialchars($recruiter['name'], ENT_QUOTES, 'UTF-8'); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>

            <div class="registration-footer">
                <p class="registration-hint">
                    Identifiant : <?php echo USERNAME_MIN_LENGTH; ?>-<?php echo USERNAME_MAX_LENGTH; ?> caractères
                    <?php if (EMAIL_ENABLED): ?> · E-mail valide requis<?php endif; ?>
                    · Mot de passe : <?php echo PASSWORD_MIN_LENGTH; ?>-<?php echo PASSWORD_MAX_LENGTH; ?> caractères
                </p>
                <button type="submit" id="submit" class="btn btn-primary" disabled>S'inscrire</button>
            </div>
        </form>
    </div>
</div>
<script>
    const USERNAME_MIN_LENGTH = <?php echo USERNAME_MIN_LENGTH; ?>;
    const USERNAME_MAX_LENGTH = <?php echo USERNAME_MAX_LENGTH; ?>;
    const PASSWORD_MIN_LENGTH = <?php echo PASSWORD_MIN_LENGTH; ?>;
    const PASSWORD_MAX_LENGTH = <?php echo PASSWORD_MAX_LENGTH; ?>;
    const EMAIL_ENABLED = <?php echo EMAIL_ENABLED ? 'true' : 'false'; ?>;
</script>
<script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>"></script>
</body>
</html>
