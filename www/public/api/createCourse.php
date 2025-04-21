<?php
    if(isset($_POST['name'], $_POST['holeNum'])) {
        include_once('dbFunctions.php');

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

        $response = createCourse($name, $_POST['holeNum'], $_POST['par']);

        if($response === "error") {
            echo json_encode(["error" => true]);
        } else {
            echo json_encode(["error" => false, "cid" => $response['cid'], "name" => $response['name']]);
        }
    }
?>