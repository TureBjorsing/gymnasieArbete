<?php
    session_start();

    $fName = $_SESSION['firstname'];
    $lName = $_SESSION['lastname'];
    $user = $_SESSION['user'];

    echo json_encode(["user" => $user, "firstname" => $fName, "lastname" => $lName]);
?>