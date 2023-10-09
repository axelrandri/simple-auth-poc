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
}