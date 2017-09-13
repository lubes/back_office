<?php 
include_once("../../connection.php");
include('../../layout/header.php');?>

<?php 
$page_var = 'Attendee';
$page_vars = 'attendees';
include ('../../layout/page-header.php');?>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>All Attendees</h3>
        </div>
        <div class="widget-content">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Filter by Event</label>
                        <?php filter_by_event($filter='8');?>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Filter by Invitation Number</label>
                        <?php filter_invite_no();?>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Filter by Approval Status</label>
                        <?php filter_status();?>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content">
            <?php all_attendees();?>
        </div>
    </div>
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

<?php include('../../layout/footer.php');?>

