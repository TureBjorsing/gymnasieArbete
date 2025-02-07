<?php
    function connectToDb() {
        // Definierar konstanter med användarinformation.
        define ('DB_USER', 'gymnasieArbete');
        define ('DB_PASSWORD', '12345');
        define ('DB_HOST', 'mariadb'); // mariadb om docker annars localhost
        define ('DB_NAME', 'gymnasieArbete');
        
        // Skapar en anslutning till MySql och databasen egytalk
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $db = new PDO($dsn, DB_USER, DB_PASSWORD);
 
        return $db;
    }

    function auth($user, $pwd) {
        $db = connectToDb();

        $stmt = $db->prepare("SELECT * FROM user WHERE username = :user");
        $stmt->bindValue(':user', $user);
        $stmt->execute();

        $response['auth'] = false;

        if($stmt->rowCount() == 1) {    //kontrollerar att det bara finns en användare
            $user = $stmt->fetch(PDO::FETCH_ASSOC); //hämtar användaren

            if(password_verify($pwd, $user['password'])) {
                $response['auth'] = true;
                $response['user'] = $user['username'];
                $response['firstname'] = $user['firstname'];
                $response['lastname'] = $user['lastname'];
            }
        }

        return $response;
    }

    function register($user, $firstname, $lastname, $pwd) {
        $db = connectToDb();

        $success = false;

        $stmt = $db->prepare("INSERT INTO user(uid, firstname, lastname, username, password) VALUES(UUID(), :fn, :ln, :user, :pwd)");

        $stmt->bindValue(":fn", $firstname);
        $stmt->bindValue(":ln", $lastname);
        $stmt->bindValue(":user", $user);
        $stmt->bindValue(":pwd", $pwd);

        $success = true;
        try {
            $stmt->execute();
        } catch (Exception $e) {
            $success = false;
        }

        return $success;
    }
?>