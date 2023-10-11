<?php
session_start();
require_once 'Controllers/UserController.php';
require_once 'Models/User.php';
require_once 'Database/config.php';
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $userController = new UserController($pdo);
    echo "Connecté";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userController->addUser($email, $password);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
</head>

<body>
    <form action="" method="post">
        <div>
            <label for="user_email">Email</label>
            <input type="email" name="email" id="user_email">
        </div>
        <div>
            <label for="user_password">Password</label>
            <input type="password" name="password" id="user_password">
        </div>
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>