<?php
include_once("../connection.php");
global $mysqli; 
$att_id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$att_id'");
while($res = mysqli_fetch_array($result)) {	?>	

<div class="attendee-card">
    <h1><?php echo $res['name'];?></h1>
    <div class="btn-group">
        <a href="<?php echo $uri;?>/exhibitor/edit/?id=<?php echo $res['id'];?>" class="btn btn-secondary">Edit Exhibitor</a>
        <a href="mailto:<?php echo $res['email'];?>" class="btn btn-secondary">Email Exhibitor</a>
    </div>
</div>

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
    <ul class="user-details list-unstyled">
        <li><span>Email:</span>
            <?php echo $exhibitors['email'];?>
        </li>
        <li><span>Username:</span>
            <?php echo $exhibitors['username'];?>
        </li>
        <li><span>Password:</span>
            <input type="password" class="form-control-static" disabled value="<?php echo $exhibitors['password'];?>">
        </li>
    </ul>
</div>
    <table id="rank_table" class="table table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Industry</th>
                <th>Revenue</th>
                <th>Stars</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $attendee_result = mysqli_query($mysqli, "
            SELECT attendees.*, exhibitors_meta.attendee_id, exhibitors_meta.exhibitor_id, exhibitors_meta.stars AS ex_stars, exhibitors_meta.rating
            FROM attendees
            LEFT JOIN exhibitors_meta ON attendees.id = exhibitors_meta.attendee_id
            WHERE exhibitors_meta.attendee_id=attendees.id
            AND exhibitors_meta.exhibitor_id='$att_id' AND NOT exhibitors_meta.stars=0 
            ");
            while($att_res = mysqli_fetch_array($attendee_result)) {?>
            <tr>
                <td>
                    <?php echo $att_res['name'];?>
                </td>
                <td>
                    <?php echo $att_res['industry'];?>
                </td>
                <td>
                    <?php echo $att_res['revenue'];?>
                </td>
                <td>
                    <div class="star-num">
                        <?php echo $att_res['ex_stars'];?>
                    </div>
                    <div class="star gold"><i class="ion-ios-star"></i></div>
                </td>
                <td>
                    <?php echo $att_res['rating'];?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
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
