<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }   

    include_once("dbFunctions.php");

    $course = getCourse();

    if (!empty($course)) {
        echo json_encode($course);
    } else {
        echo json_encode(["error" => "Course not found"]);
    }
?>