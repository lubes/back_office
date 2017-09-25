<?php 
include_once("../../connection.php");
include('../../layout/header.php');?>

<?php 
$page_var = 0;
$page_vars = 'Edit Event';
include ('../../layout/page-header.php');?>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>Edit <?php echo event_name();?></h3>
        </div>
        <div class="widget-content">
            <?php edit_quartz_event();?>
        </div>
    </div>
</div>

<?php include('../../layout/footer.php');?>

