<?php 
include_once("../../connection.php");
include('../../layout/header.php');?>
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <?php attendee_logo();?>
                <h1><?php user_name($user='attendee', $plural='attendees');?> <?php attendee_approval_status();?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>Edit <?php user_name($user='attendee', $plural='attendees');?></h3>
        </div>
        <div class="widget-content">
            <?php attendee_logo_use();?>
            <?php edit_attendee();?>
            <?php update_password($user='attendees');?>
            <?php upload_attendee_logo();?>
        </div>
    </div>
</div>
<?php include('../../layout/footer.php');?>

