<?php
include_once("../../connection.php");

    $exhibitor_id = $_SESSION['id'];
    $attendee_id = $_POST['attendee_id'];
    $stars = $_POST['stars'];
    $rating = $_POST['rating'];

    if($_POST['meta'] || $_POST['meta_2']) {
        
        $result = mysqli_query($mysqli, "UPDATE exhibitors_meta SET exhibitor_id='$exhibitor_id', attendee_id='$attendee_id', stars='$stars', rating='$rating' WHERE exhibitor_id='$exhibitor_id' AND attendee_id='$attendee_id'");
        
    } else {
        $result = mysqli_query($mysqli, "
        INSERT INTO exhibitors_meta (exhibitor_id,attendee_id,stars,rating) VALUES('$exhibitor_id', '$attendee_id', '$stars', '$rating')
        ");
    }
?>



