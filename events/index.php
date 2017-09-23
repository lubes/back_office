<?php 
$body_class = 'event-exhibitors';
include_once("../connection.php");
include('../layout/header.php');
include('nav.php');

if (!isset($_SESSION['id'])) {
    header('Location: ../');
}
?>

<?php if($_SESSION['permission']==2) {?>
    <?php include('attendees/index.php');?>
<?php } else { ?>
    <?php include('exhibitors/index.php');?>
<?php } ?>

<!-- Exhibitor Info Modal -->
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

<?php include('../layout/footer.php');?>

<script>
// View Attendee Info in Modal
$('.view-info').on('click', function() { 
    var this_attendee = $(this).data('attendee');
    var attendee_info = $('#attendee_info');
    attendee_info.html('');
    
    $.ajax({
            url: '../layout/attendee-info.php?id='+this_attendee,
            type: 'POST',
            dataType: "html",
        })
        .done(function (data) {
            attendee_info.html(data);
            // this_ex_res.html(data);
        })
        .fail(function () {
            console.log('Something went wrong...');
        });
});
</script>

<script>
// View Attendee Info in Modal
$('.view-exhibitor-info').on('click', function() { 
    console.log();
    var this_exhibitor = $(this).data('exhibitor');
    var exhibitor_info = $('#exhibitor_info');
    exhibitor_info.html('');
    $.ajax({
            url: '../layout/exhibitor-info.php?id='+this_exhibitor,
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