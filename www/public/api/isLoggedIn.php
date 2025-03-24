<?php
    session_start();

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    if(isset($_SESSION['user'])) {
        echo json_encode(["loggedIn" => true]);
    } else {
        echo json_encode(["loggedIn" => false]);
    }
?>