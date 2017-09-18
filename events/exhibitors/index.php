<?php 
$body_class='event-exhibitors';
include_once("../../connection.php");
include('../../layout/header.php');
include('../nav.php');?>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3><?php echo event_name();?> Exhibitors</h3>
            <a href="mailto:<?php all_exhibitor_emails();?>" class="btn btn-secondary btn-sm float-right">Email All Exhibitors</a>
        </div>
        <div class="widget-content">
            <?php exhibitor_by_event();?>
        </div>
    </div>
</div>

<!-- Attendee Info Modal -->
<div class="modal" id="exhibitorInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Exhibitor Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <div id="exhibitor_info"></div>
      </div>
    </div>
  </div>
</div>

<?php include('../../layout/footer.php');?>

<script>
// View Attendee Info in Modal
$('.view-exhibitor-info').on('click', function() { 
    console.log();
    var this_exhibitor = $(this).data('exhibitor');
    var exhibitor_info = $('#exhibitor_info');
    exhibitor_info.html('');
    $.ajax({
            url: '../../layout/exhibitor-info.php?id='+this_exhibitor,
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
</script>