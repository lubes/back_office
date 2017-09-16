<?php 
include_once("../connection.php");
include('../layout/header.php');?>

<div class="page-header">
    <div class="container">
        <h1>Hello, Admin</h1>
    </div>
</div>

<div class="container">
    <div class="widget-wrap">
        <div class="widget-title">
            <h3>All Events</h3>
        </div>
        <div class="widget-content">
            <?php all_quartz_events();?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="widget-wrap">
                <div class="widget-title">
                    <h3>All Brands</h3>
                    <a class="btn btn-success btn-sm float-right" data-target="#newBrand" data-toggle="modal" href="#">Add New</a>
                </div>
                <div class="widget-content">
                    <table class="table table-responsive">
                        <thead>
                            <th>Brand</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php all_brands();?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <div class="widget-wrap">
                <div class="widget-title">
                    <h3>All Seasons</h3>
                    <a class="btn btn-success btn-sm float-right" data-target="#newSeason" data-toggle="modal" href="$">Add New</a>
                </div>
                <div class="widget-content">
                    <table class="table table-responsive">
                        <thead>
                            <th>Season</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php all_seasons();?>
                        </tbody>
                    </table>
                </div>
            </div>
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

<?php include('../layout/footer.php');?>

