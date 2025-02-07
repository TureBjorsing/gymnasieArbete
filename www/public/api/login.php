<?php
    session_start();

    if(isset($_POST['user'], $_POST['pwd'])) {
        include_once('dbFunctions.php');
        $user = filter_input(INPUT_POST, 'user', FILTER_UNSAFE_RAW);
        $pwd = $_POST['pwd'];

        $response = auth($user, $pwd);

        if ($response['auth']) {
            session_regenerate_id();

            echo json_encode(["success" => true]);
            $_SESSION['user'] = $response['user'];
            $_SESSION['firstname'] = $response['firstname'];
            $_SESSION['lastname'] = $response['lastname'];
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "missing parameters"]);
    }
?>