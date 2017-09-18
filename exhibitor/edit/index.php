<?php 
include_once("../../connection.php");
include('../../layout/header.php');?>
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <?php exhibitor_logo();?>
                <h1><?php user_name($user='exhibitor', $plural='exhibitors');?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>Edit <?php exhibitor_name();?></h3>
        </div>
        <div class="widget-content">
            <?php edit_exhibitor();?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="widget-wrap">
                <div class="widget-title">
                    <h3>Exhibitor Events</h3>
                </div>
                <div class="widget-content">
                    <?php if($_SESSION['permission']==1):?>
                        <?php edit_exhibitor_events();?>
                        <?php duplicate_exhibitor();?>
                    <?php // edit_exhibitor_events();?>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <div class="widget-wrap">
                <div class="widget-title">
                    <h3>Exhibitor Logo</h3>
                </div>
                <div class="widget-content">
                    <?php upload_exhibitor_logo();?>
                </div>
            </div> 
        </div>
    </div>   
</div>
<?php include('../../layout/footer.php');?>

