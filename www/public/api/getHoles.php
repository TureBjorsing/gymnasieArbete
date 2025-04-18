<?php
    include_once("dbFunctions.php");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }   

    $cid = $_GET['cid'];

    $holes = getHoles($cid);

    // echo json_encode(["error" => "Holes not found"]);
    echo json_encode($holes);
?>