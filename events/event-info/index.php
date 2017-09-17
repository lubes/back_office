<?php 
$body_class = 'event-info';
$form_view = 'tab_1';
$event = $_GET['event'];
include_once("../../connection.php");
include('../../layout/header.php');
include('../nav.php');?>
<div class="container">
    <div class="page-wrap">
        <div class="container">
            <?php event_info_form();?>  
        </div>
    </div>
</div>
<?php include('../../layout/footer.php');?>