<?php
    include_once("dbFunctions.php");

    $course = getCourse($_GET['cid']);

    if (!empty($course)) {
        echo json_encode($course);
    } else {
        echo json_encode(["error" => "Course not found"]);
    }
?>