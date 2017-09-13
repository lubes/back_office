<?php 
include_once("../connection.php");
include('../layout/header.php');?>
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <?php exhibitor_logo();?>
                <h1><?php user_name($user='exhibitor', $plural='exhibitors');?></h1>
            </div>
            <div class="col-12 col-sm-3">
                <a class="btn btn-warning float-right" href="<?php echo $uri;?>/exhibitor/edit/?id=<?php echo $_SESSION['id'];?>">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3><?php user_name($user='exhibitor', $plural='exhibitors');?>'s Profile</h3>
        </div>
   
<?php
global $mysqli; 
global $uri;
$exhibitor = $_SESSION['id'];
$result = mysqli_query($mysqli, "
SELECT id, active FROM exhibitors
WHERE id='$exhibitor'
");
while($res = mysqli_fetch_array($result)) { 
    if($res['active']=='1') {
?>
         
    <div class="widget-title">
        <h6>Event:</h6>
        <?php exhibitor_events();?>
    </div>
        
  <?php } else { echo '<div class="alert alert-info"><strong>Your account is not currently active</strong></div>'; } } ?>      
        
        <div class="widget-content">
            <?php exhibitor_profile();?>
        </div>
    </div>
</div>
<?php include('../layout/footer.php');?>

