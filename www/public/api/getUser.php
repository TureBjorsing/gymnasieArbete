<?php
    session_start();

    $fName = $_SESSION['firstname'];
    $lName = $_SESSION['lastname'];
    $user = $_SESSION['user'];

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    echo json_encode(["user" => $user, "firstname" => $fName, "lastname" => $lName]);
?>