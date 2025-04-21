<?php
    session_start();

    if(isset($_POST['user'], $_POST['pwd'])) {
        include_once('dbFunctions.php');
        $user = filter_input(INPUT_POST, 'user', FILTER_UNSAFE_RAW);
        $pwd = $_POST['pwd'];

        $response = auth($user, $pwd);

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if ($response['auth']) {
            session_regenerate_id();

            echo json_encode(["success" => true]);
            $_SESSION['uid'] = $response['uid'];
            $_SESSION['user'] = $response['user'];
            $_SESSION['firstname'] = $response['firstname'];
            $_SESSION['lastname'] = $response['lastname'];
            $_SESSION['lastPlayed'] = $response['lastPlayed'];
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "missing parameters"]);
    }
?>