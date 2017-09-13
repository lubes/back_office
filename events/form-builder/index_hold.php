<?php 
$body_class = 'form-builder';
$event = $_GET['event'];
include_once("../../connection.php");
include('../../layout/header.php');
include('../nav.php');?>
<div class="container">
    <div class="page-wrap">
        <div class="container">
            <?php check_form_existence();?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div class="form-tab active" id="tab_1">
                        <h3>Form Messaging</h3>
                        <?php form_messages();?>
                    </div>
                    <div class="form-tab" id="tab_2">
                        <h3>Form Fields</h3>
                        <?php form_fields();?>
                    </div>
                    <div class="form-tab" id="tab_3">
                        <h3>Custom Fields</h3>
                        <?php view_custom_fields();?>
                    </div>
                    <div class="form-tab" id="tab_4">
                        <h3>Email Messaging</h3>
                        <?php email_messages();?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <ul class="list-unstyled form-togglers">
                        <a data-id="1" class="form-toggle btn btn-default btn-block active" href=""><i class="material-icons">line_weight</i>Form Message</a>
                        <a data-id="2" class="form-toggle btn btn-default btn-block" href=""><i class="material-icons">note</i>Standard Fields</a>
                        <a data-id="3" class="form-toggle btn btn-default btn-block" href=""><i class="material-icons">note_add</i>Custom Fields</a>
                        <a data-id="4" class="form-toggle btn btn-default btn-block" href=""><i class="material-icons">send</i>Email Messages</a>
                        <a class="btn btn-default btn-block" href="<?php echo $uri;?>/events/invite-form/?event=<?php echo $event;?>" target="_blank"><i class="material-icons">format_align_justify</i>Preview Form</a>
                    </ul>
                </div>
            </div>    
        </div>
    </div>
</div>
<?php include('../../layout/footer.php');?>

