<?php
$geo   = $_GET['geo'];
$warehouse   = $_GET['warehouse'];
$body_class='event-attendees';
global $mysqli; 
$event = $_GET['event'];
$result = mysqli_query($mysqli, "
SELECT ranking FROM quartz_event WHERE id='$event'");
while($res = mysqli_fetch_array($result)) { ?>
    <?php if($res['ranking']=='1') { $ranking = 'open'; } else { $ranking = 'closed'; } ?>
<?php } 
if($ranking == 'open'):
include('../layout/filter.php');
endif;?>
<div class="container"> 
    <?php if($ranking == 'open') { ?>
    <div class="widget-wrap">
        <div class="widget-title">
            <h3><?php echo event_name();?> Attendees</h3>
        </div>
        <div class="widget-content">
            <a id="btn-csv" class="btn btn-secondary float-right btn-export" href="">Export as CSV</a>
            <table class="table table-responsive filter-table" id="attendees_ranking_table">
                <thead>
                <?php if($_SESSION['permission'] == 1) { ?>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Revenue</th>
                    <th>Employees</th>
                    <th></th>
                    <th></th>
                <?php } else { ?>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Revenue</th>
                    <th>Company Size</th>
                    <?php if(isset($geo)) { ?>
                        <th>Geo Location</th>          
                    <?php } ?>
                    <?php if(isset($warehouse)) { ?>
                        <th>Warehouse Equipment Interest</th>  
                        <th>Warehouse Software Interest</th>  
                    <?php } ?>
                    <th>Stars</th>
                    <th>Rating</th>
                    <th>Details</th>
                <?php } ?>                
                </thead>
                <tbody>
                    <?php attendees_by_event(); ?>  
                </tbody>
            </table>
        </div>
    </div>
    <?php } else { ?>
    <div class="alert alert-info" role="alert">
        <strong>Sorry</strong> Rating for this event is closed right now.
    </div>
    <?php } ?>
</div>

<!-- Attendee Info Modal -->
<div class="modal" id="attendeeInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attendee Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <div id="attendee_info"></div>
      </div>
    </div>
  </div>
</div>
