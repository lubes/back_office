<?php
include_once("../connection.php");
global $mysqli; 
$att_id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$att_id'");
while($res = mysqli_fetch_array($result)) {	?>	
    <div class="attendee-card">
    <?php if($_SESSION['permission'] == 1):?>

        <h1><?php echo $res['name'];?></h1>
        <div class="btn-group">
            <a href="<?php echo $uri;?>/attendee/edit/?id=<?php echo $res['id'];?>" class="btn btn-secondary">Edit Attendee</a>
            <a href="mailto:<?php echo $res['email'];?>" class="btn btn-secondary">Email Attendee</a>
        </div>
        <div class="attendee-responses">
            <h6>Attendee Response:</h6>
            <?php //standard_att_response();?>
            <?php att_response();?>
        </div>
    <?php endif;?>
        
    <?php if($_SESSION['permission'] == 2):?>
        
        <!-- Attendee Info Card for Exhibitors -->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
                <?php attendee_logo(); ?><br>
                <a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                View Details
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
                <h2><?php echo $res['company'];?></h2>
                <?php exhibitor_att_response();?>
            </div>
        </div>
    
        <div class="collapse" id="collapseExample">
          <div class="card card-block">
            <div class="attendee-responses">
                <h5>Additional Info:</h5>
                <?php att_response();?>
            </div>
          </div>
        </div>

    <?php endif;?>
    </div>

<?php }

$result = mysqli_query($mysqli, "
SELECT attendees.*, attendee_meta.attendee_id, attendee_meta.question, attendee_meta.answer, attendee_meta.revenue, forms.id, forms.title FROM attendees
LEFT JOIN attendee_meta ON attendees.id = attendee_meta.attendee_id
LEFT JOIN forms ON forms.id = attendee_meta.question
WHERE attendee_id='$att_id'");?>

<?php while($res = mysqli_fetch_array($result)) {	?>	

    <div class="form-response">
        <p class="question"><span>Q: </span><?php echo $res['title'];?></p>
        <p class="answer"><span>A: </span><?php echo $res['answer'];?></p>
    </div>

<?php } 

?>