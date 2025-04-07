<?php
    include_once("dbFunctions.php");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }   

    $cName = $_GET['cName'];

    $holes = getHoles($cName);

    // echo json_encode(["error" => "Holes not found"]);
    echo json_encode($holes);
?>