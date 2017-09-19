<?php 
include_once("connection.php");
include('layout/header.php');
if(isset($_POST['login_exhibitor'])) {
    login_exhibitor(); 
} else if(isset($_POST['login_admin'])) {
    login_admin();
} else if(isset($_POST['login_attendee'])) {
    login_attendee();
} else {
    session_start();
?>
<?php  } ?>

<?php if(isset($_SESSION['valid']) && $_SESSION['permission']==1) {
    // Admin
    include('admin/index.php');
    
} else if(isset($_SESSION['valid']) && $_SESSION['permission']==2) { 
   
    header('Location: ./exhibitor/?id='.$_SESSION['id'].'');
   
} else if(isset($_SESSION['valid']) && $_SESSION['permission']==3) {    
    // Attendee
    header('Location: ./attendee/?id='.$_SESSION['id'].'');
    
} else { // Not Logged In ?>

<div class="login-page">
<div class="container-fluid">
    <div class="cols row flex-items-xs-middle">
        <div class="col-12 col-sm-12 col-md-7 left-col">
            <div class="col-entry">
                <?php view_message();?>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-5 right-col">
            <div class="col-entry">
            <!-- Tab panes -->
            <div class="tab-content">
            <div class="tab-pane" id="home" role="tabpanel">
                <div class="login-wrap">
                    <form name="form_exhibitor" class="login-form" method="post" action="">
                        <h2>Exhibitor Login</h2>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Username" value="exhibitor">
                            <input type="password" name="password" class="form-control" placeholder="Password" value="acc355">
                            <input type="submit" class="btn btn-primary btn-block" name="login_exhibitor" value="Login">
                        </div>
                    </form>  
                    <p class="text-muted">user: exhibitor<br>password: acc355</p>
                </div>
            </div>
            <div class="tab-pane active" id="profile" role="tabpanel">
                <div class="login-wrap">
                    <form name="form_admin" class="login-form" method="post" action="">
                        <h2>Admin Login</h2>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Email" value="admin@admin.com">
                            <input type="password" name="password" class="form-control" placeholder="Password" value="acc355">
                            <input type="submit" class="btn btn-primary btn-block" name="login_admin" value="Login">
                        </div>
                    </form> 
                    <p class="text-muted">user: admin@admin.com<br>password: acc355</p>
                </div>
            </div>
            <div class="tab-pane" id="messages" role="tabpanel">
                <div class="login-wrap">
                    <form name="form_attendee" class="login-form" method="post" action="">
                        <h2>Attendee Login</h2>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Email" value="lybovtch@gmail.com">
                            <input type="password" name="password" class="form-control" placeholder="Password" value="acc355">
                            <input type="submit" class="btn btn-primary btn-block" name="login_attendee" value="Login">
                        </div>
                    </form>    
                    <p class="text-muted">user: lybovtch@gmail.com<br>password: acc355</p>
                </div>
            </div>
            </div>
            <!-- Nav tabs -->
            <div class="login-links">
                <ul class="nav nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#home" role="tab">Exhibitor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Attendee</a>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
<?php } ?>
<?php include('layout/footer.php');?>

