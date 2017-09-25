<?php 
$body_class='event-attendees';
include_once("../../connection.php");
include('../../layout/header.php');
include('../nav.php');?>

<div class="container">  
    <div class="widget-wrap">
        <div class="widget-title">
            <h3><?php echo event_name();?> Attendees</h3>
        </div>
         <div class="widget-title">
            <h3>Registrations Pending Approval</h3>
        </div>
        <div class="widget-content">
            <?php approve_attendees();?>
        </div>
         <div class="widget-title">
            <h3>All Registrations</h3>
        </div>
        <div class="widget-content">
            <?php basic_event_attendees();?>
            <!--
            <a id="btn-csv" class="btn btn-secondary float-right btn-export" href="">Export as CSV</a>
            <table class="table table-responsive filter-table" id="attendees_ranking_table">
                <thead>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Revenue</th>
                    <th>Employees</th>
                    <th></th>            
                </thead>
                <tbody>
                    <?php // admin_attendees_by_event();?>
                </tbody>
            </table>
            -->
        </div>
    </div>
    <div class="widget-wrap" id="approvals">
        <div class="widget-title">
            <h3>Attendees Pending Approval</h3>
        </div>
        <div class="widget-content">
            <?php approve_attendees();?>
        </div>
    </div>   
</div>

<!-- Attendee Info Modal -->
<div class="modal" id="attendeeInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attende Information</h5>
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

<!-- Attendee Approval Modal -->
<div class="modal" id="attendeeApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Attendee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
          <div id="attendee_approval_info">
            <?php approve_attendee();?>
          </div>
      </div>
    </div>
  </div>
</div>

<?php include('../../layout/footer.php');?>

<script>
// View Attendee Info in Modal
$('.view-attendee').on('click', function() { 
    var this_exhibitor = $(this).data('exhibitor');
    var exhibitor_info = $('#exhibitor_info');
    exhibitor_info.html('');
    $.ajax({
            url: '../../layout/attendee-info.php?id='+this_exhibitor,
            type: 'POST',
            dataType: "html",
        })
        .done(function (data) {
            exhibitor_info.html(data);
            // this_ex_res.html(data);
        })
        .fail(function () {
            console.log('Something went wrong...');
        });
});
    
// View Attendee Info in Modal
$('.approve-attendee').on('click', function() { 
    var this_attendee = $(this).data('attendee');
    var attendee_info = $('#attendee_approval_info');
    attendee_info.html('hi');
    $.ajax({
            url: '../../layout/approve-attendee.php?id='+this_attendee,
            type: 'POST',
            dataType: "html",
        })
        .done(function (data) {
            attendee_info.html(data);
        })
        .fail(function () {
            console.log('Something went wrong...');
        });
});
</script>


