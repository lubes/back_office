<?php 
session_start();
if(!isset($_SESSION['valid'])) {
	header('Location: index.php');
}
include_once("../../connection.php");
include('../../layout/header.php');?>

<?php 
$page_var = 'exhibitor';
$page_vars = 'exhibitors';
include ('../../layout/page-header.php');?>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>All Exhibitors</h3>
        </div>
        <div class="widget-content">
            <div class="row">
                <div class="col-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Filter by Event</label>
                        <?php filter_by_event($filter='4');?>
                    </div>
                </div>
            </div>
        </div>        
        <div class="widget-content">           
            <?php all_exhibitors();?>
        </div>
    </div>
</div>
<?php include('../../layout/footer.php');?>

