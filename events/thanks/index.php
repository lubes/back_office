<?php session_start(); 
include_once("../../connection.php");
$body_class = 'thanks';
include_once("../../layout/header.php");
?>

<div class="container">
    <div class="thank-you">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 offset-md-2">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
                <?php thank_you();?>
                <hr>
                <?php standard_att_response();?>
                <?php att_response();?>
            </div>
        </div>
    </div>
</div>

<?php send_email();?>

<?php include('../../layout/footer.php');?>
 