<?php
include_once("../../connection.php");
$id = $_GET['id'];
$result = mysqli_query($mysqli, "UPDATE admins SET completed='1' WHERE id=$id");
?>

<script>
alert('done!');
</script>

