<?php
    if(isset($_POST['fairwayMissL'])) {
        include_once('dbFunctions.php');

        sendStats($_POST['fairwayMissL'], $_POST['fairwayMissR'], $_POST['fairwayHit'], $_POST['greenHit'], $_POST['score'], $_POST['cid']);
        changeStats($_POST['cid']);
    }
?>