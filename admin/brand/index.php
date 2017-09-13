<?php 
include_once("../../connection.php");
include('../../layout/header.php');?>

<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <div class="events-header"><?php brand_logo_img();?></div>
                <h4>Edit Brand</h4>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>Edit Brand</h3>
        </div>
        <div class="widget-content">
            <?php edit_brand();?>
        </div>
    </div>
</div>

<?php include('../../layout/footer.php');?>

