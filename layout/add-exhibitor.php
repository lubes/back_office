<!-- New Exhibitor Modal -->
<?php add_exhibitor();?>
<div class="modal fade" id="addexhibitor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Exhibitor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" name="form1">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
                <label>Company</label>
                <input type="text" name="company" class="form-control" placeholder="Company">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label>Event</label>
                <?php event_select();?>
            </div>
            <input type="hidden" name="role" value="1">
            <div class="form-group">
                <input type="submit" name="add_new" class="btn btn-success" value="Add Exhibitor">
            </div>
        </form>          
      </div>
    </div>
  </div>
</div>


