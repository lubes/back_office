<?php 
include_once("../../connection.php");
include('../../layout/header.php');?>

<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <h1>Edit Season</h1>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>Edit Season</h3>
        </div>
        <div class="widget-content">
            <?php edit_event();?>
        </div>
    </div>
</div>

<?php include('../../layout/footer.php');?>

