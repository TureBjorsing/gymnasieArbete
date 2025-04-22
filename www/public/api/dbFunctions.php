<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }   

    function connectToDb() {
        // Definierar konstanter med användarinformation.
        if(!defined('DB_USER')) { // kollar ifall dom redan är defined
            define ('DB_USER', 'gymnasieArbete');
            define ('DB_PASSWORD', '12345');
            define ('DB_HOST', 'mariadb'); // mariadb om docker annars localhost
            define ('DB_NAME', 'gymnasieArbete');
        }
        
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
                $response['uid'] = $user['uid'];
                $response['user'] = $user['username'];
                $response['firstname'] = $user['firstname'];
                $response['lastname'] = $user['lastname'];
                $response['lastPlayed'] = $user['lastPlayed'];
            }
        }

        return $response;
    }

    function getLastPlayed() {
        $db = connectToDb();

        $stmt = $db->prepare("SELECT lastPlayed FROM user WHERE uid = :uid");
        $stmt->bindValue(':uid', $_SESSION['uid']);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    function getCourse($cid) {
        $db = connectToDb();

        if (!isset($_SESSION['uid'])) {
            return ["error" => "User not logged in"];
        }

        if($cid == "none") {
            $stmt = $db->prepare("SELECT * FROM course WHERE uid = :uid");
            $stmt->bindValue(':uid', $_SESSION['uid']);
        } else {
            $stmt = $db->prepare("SELECT * FROM course WHERE cid = :cid");
            $stmt->bindValue(':cid', $cid);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getHoles($cid) {
        $db = connectToDb();

        if (!isset($_SESSION['user'])) {
            return ["error" => "User not logged in"];
        }

        $stmt = $db->prepare("SELECT hid, par FROM `hole` WHERE cid LIKE :cid AND uid = :uid");
        $stmt->bindValue(':cid', $cid);
        $stmt->bindValue(':uid', $_SESSION['uid']);
        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    function sendStats($fairwayMissL, $fairwayMissR, $fairwayHit, $greenHit, $score, $cid) {
        $db = connectToDb();

        $stmt = $db->prepare("INSERT INTO stats(uid, cid, fairwayMissL, fairwayMissR, fairwayHit, greenHit, score) VALUES(:uid, :cid, :left, :right, :middle, :green, :score)");

        $stmt->bindValue(":uid", $_SESSION['uid']);
        $stmt->bindValue(":cid", $cid);
        $stmt->bindValue(":left", $fairwayMissL);
        $stmt->bindValue(":right", $fairwayMissR);
        $stmt->bindValue(":middle", $fairwayHit);
        $stmt->bindValue(":green", $greenHit);
        $stmt->bindValue(":score", $score);

        $stmt->execute();

        $stmt2 = $db->prepare("UPDATE user SET lastPlayed = :cid WHERE uid LIKE :uid");
        $stmt2->bindValue(":cid", $cid);
        $stmt2->bindValue(":uid", $_SESSION['uid']);

        $stmt2->execute();
    }

    function changeStats($cid) {
        $db = connectToDb();

        $stmt = $db->prepare("SELECT * FROM stats WHERE cid LIKE :cid AND uid = :uid");

        $stmt->bindValue(":cid", $cid);
        $stmt->bindValue(":uid", $_SESSION['uid']);

        $stmt->execute();
        $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $fairwayMissL = 0;
        $fairwayMissR = 0;
        $fairwayHit = 0;
        $greenHit = 0;
        $score = 0;
        for($i = 0; $i < count($stats); $i++) {
            $fairwayMissL += $stats[$i]['fairwayMissL'];
            $fairwayMissR += $stats[$i]['fairwayMissR'];
            $fairwayHit += $stats[$i]['fairwayHit'];
            $greenHit += $stats[$i]['greenHit'];
            $score += $stats[$i]['score'];
        }

        $AllFairwayMissL = $fairwayMissL / count($stats);
        $AllFairwayMissR = $fairwayMissR / count($stats);
        $AllFairwayHit = $fairwayHit / count($stats);
        $AllGreenHit = $greenHit / count($stats);
        $AllScore = $score / count($stats);

        $stmt2 = $db->prepare("UPDATE course SET fairwayMissL = :left, fairwayMissR = :right, fairwayHit = :hit, greenHit = :green, averageScore = :score WHERE cid = :cid");

        $stmt2->bindValue(":left", $AllFairwayMissL);
        $stmt2->bindValue(":right", $AllFairwayMissR);
        $stmt2->bindValue(":hit", $AllFairwayHit);
        $stmt2->bindValue(":green", $AllGreenHit);
        $stmt2->bindValue(":score", $AllScore);
        $stmt2->bindValue(":cid", $cid);

        $stmt2->execute();
    }

    function createCourse($name, $holeNum, $par) {
        $db = connectToDb();

        $stmt = $db->prepare("INSERT INTO course(cid, uid, name, holes, par) VALUES(UUID(), :uid, :name, :holes, :par)");
        $stmt->bindValue(":uid", $_SESSION['uid']);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":holes", $holeNum);
        $stmt->bindValue(":par", $par);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return "error";
        }

        $stmt2 = $db->prepare("SELECT cid, name FROM course WHERE name LIKE :name");
        $stmt2->bindValue(":name", $name);

        $stmt2->execute();

        return $stmt2->fetch(PDO::FETCH_ASSOC);
    }

    function createHole($par, $cid, $name) {
        $db = connectToDb();

        $stmt = $db->prepare("INSERT INTO hole(uid, cid, courseName, par) VALUES(:uid, :cid, :name, :par)");
        $stmt->bindValue(':uid', $_SESSION['uid']);
        $stmt->bindValue(':cid', $cid);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':par', $par);

        $stmt->execute();
    }

    function deleteCourse($cid) {
        $db = connectToDb();

        $stmt = $db->prepare("DELETE FROM course WHERE cid LIKE :cid");
        $stmt->bindValue(":cid", $cid);

        $stmt->execute();
    }
?>