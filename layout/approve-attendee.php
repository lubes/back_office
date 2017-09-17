<?php
include_once("../connection.php");
global $mysqli; 
$id = $_GET['id'];
$result_1 = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$id'");
$password = substr(md5(microtime()),rand(0,26),6);
while($res = mysqli_fetch_array($result_1)) {	?>	
    <h1>Are you sure you want to approve <strong><?php echo $res['name'];?></strong>?</h1>
    <h3>Login Details:</h3>
    <p>Login credentials will be emailed to attendee upon approval</p>
    <hr>
    <p>Login Email: <strong><?php echo $res['email'];?></strong></p>
    <p>Password: <strong><?php echo $password;?></strong></p> 
    <form  method="post" action="">
        <input type="hidden" name="id" value="<?php echo $res['id'];?>">
        <input type="hidden" name="event" value="<?php echo $res['event'];?>">
        <input type="hidden" name="password" value="<?php echo $password;?>">
        <input type="hidden" name="email" value="<?php echo $res['email'];?>">
        <input type="submit" class="btn btn-success" name="approve_attendee" value="Approve">
        <?php approve_attendee();?>
    </form>
<?php } ?>
