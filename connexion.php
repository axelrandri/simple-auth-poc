<?php
session_start();
require_once 'Controllers/UserController.php';
require_once 'Models/User.php';
require_once 'Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitez le formulaire de connexion
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Vérifiez les informations d'identification en utilisant le UserController
    $userController = new UserController($pdo); // Initialisez votre contrôleur avec PDO
    if ($userController->authenticateUser($email, $password)) {
        $_SESSION['authentified'] = true; // Authentification réussie
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
    <?php
    if (isset($_SESSION['authentified']) && $_SESSION['authentified'] === true) {
        ?>

        <h3>Vous êtes déjà connecté</h3>

        <p><a href="logout.php">Se déconnecter</a></p>
        <?php
    } else {
        ?>

        <form action="connexion.php" method="post">
            <div>
                <label for="user_email">Email</label>
                <input type="email" name="email" id="user_email">
            </div>
            <div>
                <label for="user_password">Password</label>
                <input type="password" name="password" id="user_password">
            </div>
            <input type="submit" value="Se connecter">
        </form>
        <?php
    }
    ?>
</body>

</html>