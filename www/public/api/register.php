<?php 
    if(isset($_POST['user'], $_POST['firstname'], $_POST['lastname'], $_POST['pwd'])) {
        include_once("dbFunctions.php");

        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

        $success = register($user, $firstname, $lastname, $pwd);

        if ($success) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }
?>