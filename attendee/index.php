<?php 
include_once("../connection.php");
include('../layout/header.php');?>

<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <?php attendee_logo();?>
                <h1><?php user_name($user='attendee', $plural='attendees');?></h1>
            </div>
            <div class="col-12 col-sm-3">
                <a class="btn btn-warning float-right" href="<?php echo $uri;?>/attendee/edit/?id=<?php echo $_SESSION['id'];?>">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3><?php user_name($user='attendee', $plural='attendees');?>'s Profile</h3>
        </div>
        <div class="widget-content">
            <?php standard_att_response();?>
            <hr>
            <?php att_response();?>
        </div>
    </div>
</div>

<?php include('../layout/footer.php');?>

