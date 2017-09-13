<?php
include_once("../connection.php");
global $mysqli; 
$att_id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$att_id'");
while($res = mysqli_fetch_array($result)) {	?>	



<?php } ?>

<?php
include_once("../connection.php");
$event_id = $_GET['event'];
$brand_id = $_GET['brand'];
$ex_id = $_GET['ex_id'];
$exhibitor_result = mysqli_query($mysqli, "
SELECT * FROM exhibitors WHERE id='$att_id'");
while($exhibitors = mysqli_fetch_array($exhibitor_result)) { ?>

    <div class="attendee-responses">
        <?php exhibitor_profile_sm();?>
    </div>
<?php } ?>

<script>
    
// DataTables
var rank_table = $('#rank_table').DataTable({
    paging: false,
    dom: 'Bfrtip',
        buttons: [
            'csvHtml5'
        ]
});
    
 
</script>
