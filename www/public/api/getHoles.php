<?php
    include_once("dbFunctions.php");

    $cid = $_GET['cid'];

    $holes = getHoles($cid);

    echo json_encode($holes);
?>