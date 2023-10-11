<?php 

class UserController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addUser($email, $password) {
        // Validation des données d'entrée ici
        $user = new User($email, $password); // Créez une instance de User

        $hash = password_hash($user->getPassword(), PASSWORD_BCRYPT);
        $email = $user->getEmail();
        try {
            $stmt = $this->db->prepare("INSERT INTO users (login, password_hash) VALUES (?, ?)");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $hash);
            $stmt->execute();

            // Gérer la réponse à l'utilisateur ou rediriger vers une vue de succès.
        } catch (PDOException $e) {
            // Gérer les erreurs ici (par exemple, enregistrer dans un journal ou afficher un message d'erreur à l'utilisateur).
        }
    }

    public function connexionUser($email, $userPassword) {
        try {
            $stt = $this->db->prepare("SELECT password_hash FROM `users` WHERE `login` = ?");
            $stt->bindParam(1, $email);
            $stt->execute();

            $dbhash = null;
            if ($stt->rowCount() === 1) {
                $dbhash = $stt->fetch()['password_hash'];
            }

            if (password_verify($userPassword, $dbhash)) {
                return true; // L'authentification est réussie
            }
        } catch (PDOException $e) {
            // Gérer les erreurs ici (par exemple, enregistrer dans un journal ou afficher un message d'erreur à l'utilisateur).
        }

        return false; // L'authentification a échoué
    }
}