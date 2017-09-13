<?php 
$body_class = 'form-builder';
$event = $_GET['event'];
$form_view = 'tab_3';
include_once("../../connection.php");
include('../../layout/header.php');
include('../nav.php');?>
<div class="container">
    <div class="page-wrap">
        <div class="container">
            <?php check_form_existence();?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div class="form-tab active" id="tab_3">
                        <h3>Custom Fields</h3>
                        <?php view_custom_fields();?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <?php include('form-nav.php');?>
                </div>
            </div>    
        </div>
    </div>
</div>
<?php include('../../layout/footer.php');?>